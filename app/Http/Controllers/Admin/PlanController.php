<?php

namespace App\Http\Controllers\Admin;

use App\Model\BannerUpload;
use App\Model\FestivalImage;
use App\Model\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;


class PlanController extends Controller
{
    //
    private $data = array(
        'route' => 'admin.plan.',
        'title' => 'Plan',
        'menu' => 'plan',
        'submenu' => '',
    );

    public function __construct()
    {
        // $this->middleware('auth');
        //$this->middleware(['permission:publish |festival_image_category add|festival_image_category edit|festival_image_category delete']);
    }

    private function _validate($request, $id = null)
    {
        $this->validate($request, [
            'contact' => 'required|max:255',
            'plan_image' => 'required|image|mimes:jpeg,png,jpg|max:1024',
            'payment_image' => 'required|image|mimes:jpeg,png,jpg|max:1024',

        ]);
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $records = Plan::select('*')->orderBy('id', 'ASC');

            return DataTables::of($records)
                ->editColumn('sequence', function ($record) {
                    return '<input style="width:100px" type="text" class="form-control txt_inline_edit inline_update" name="" value="' . $record['sequence'] . '" row_id="' . $record['id'] . '" field="sequence" ajax_url="' . route($this->data['route'] . 'update', $record['id']) . '" />';
                })
                ->editColumn('plan_image', function ($record) {
                    return '<a target="_blank" href="' . $record['plan_image_url'] . '"><img src="' . $record['plan_image_url'] . '" width="150"></a>';
                })
                ->editColumn('payment_image', function ($record) {
                    return '<a target="_blank" href="' . $record['payment_image_url'] . '"><img src="' . $record['payment_image_url'] . '" width="150"></a>';
                })
                ->addColumn('action', function ($record) {
                    return '<a href="' . route($this->data['route'] . 'show', ['id' => $record->id]) . '" class="btn btn-primary btn-sm" title="" data-toggle="tooltip" data-original-title="View"><i class="fa fa-eye-slash"></i></a>' .
                        '&nbsp;<a href="' . route($this->data['route'] . 'edit', ['id' => $record->id]) . '" class="btn btn-info btn-sm" title="" data-toggle="tooltip" data-original-title="Edit"><i class="fas fa-edit"></i></a>' .
                        '&nbsp;<button class="btn btn-danger btn-sm data-delete " data-id="' . $record->id . '" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash"></i></button>';
                })
                ->rawColumns(['action', 'payment_image', 'sequence', 'plan_image'])
                ->make(true);
        }

        return view('admin.plan.index', $this->data);

    }

    public function create()
    {

        return view('admin.plan.create', $this->data);
    }

    public function store(Request $request)
    {
        abort_if(env('APP_ENV') == "demo", 403);
        $this->_validate($request);
        $inputs = $request->all();
        $inputs['status'] = 'Active';
        $inputs['plan_image'] = $this->uploadFile($request, null, 'plan_image', 'plan');
        $inputs['payment_image'] = $this->uploadFile($request, null, 'payment_image', 'payment');

        $record = new Plan($inputs);
        $record->save();

        Session::flash('success', $this->data['title'] . ' inserted successfully.');
        return redirect()->route($this->data['route'] . 'index');
    }

    public function show($id)
    {
        $this->data['record'] = Plan::findOrFail($id);
        return view('admin.plan.show', $this->data);
    }

    public function edit($id)
    {
        //abort_unless(Auth::guard('admin')->user()->hasAnyPermission(['festival_image_category edit']), 403);
        $this->data['record'] = Plan::findOrFail($id);
        return view('admin.plan.create', $this->data);
    }

    public function update(Request $request, $id)
    {
        abort_if(env('APP_ENV') == "demo", 403);
        $record = Plan::findOrFail($id);
        /* Change Status Block */
        if ($request->ajax()) {
            $record->update($request->all());
            return \Illuminate\Support\Facades\Response::json(['result' => 'success']);
        }

        $inputs = $request->all();
        $inputs['plan_image'] = $this->uploadFile($request, null, 'plan_image', 'plan');
        $inputs['payment_image'] = $this->uploadFile($request, null, 'payment_image', 'payment');
        if (empty($inputs['plan_image'])) {
            unset($inputs['plan_image']);
        }
        if (empty($inputs['payment_image'])) {
            unset($inputs['payment_image']);
        }
        $record->update($inputs);

        Session::flash('info', $this->data['title'] . ' updated successfully.');
        return redirect()->route($this->data['route'] . 'index');
    }

    public function destroy($id)
    {
        abort_if(env('APP_ENV') == "demo", 403);

        $record = Plan::findOrFail($id);
        $this->deleteFile($record, 'plan_image');
        $this->deleteFile($record, 'payment_image');

        $record->delete();
        return \Illuminate\Support\Facades\Response::json([
            'result' => 'success',
            'message' => 'Deleted Data successfully!']);
    }

}
