<?php

namespace App\Http\Controllers\Admin;

use App\Model\ContactUs;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class ContactUsController extends Controller
{
    private $data = array(
        'route' => 'admin.contactus.',
        'title' => 'Contactus',
        'menu' => 'contactus',
        'submenu' => '',
    );
    public function __construct()
    {
        // $this->middleware('auth');
    }
    private function _validate($request, $id = null)
    {

//        if ($id == null) {
//            $this->validate($request, [
//                'password' => 'required|max:255',
//                'password_confirmation' => 'required|max:255|same:password',
//            ]);
//        }
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $records = ContactUs::select('*');
            return DataTables::of($records)
                ->editColumn('created_at', function ($record) {
                    return $record->created_at->format(config('setting.DATE_FORMAT'));
                })

                ->addColumn('action', function ($record) {
                    return '<a href="' . route($this->data['route'] . 'show', ['id' => $record->id]) . '" class="btn btn-primary btn-sm" title="" data-toggle="tooltip" data-original-title="View"><i class="fa fa-eye-slash"></i></a>' .
                        '&nbsp;<a href="' . route($this->data['route'] . 'edit', ['id' => $record->id]) . '" class="btn btn-info btn-sm" title="" data-toggle="tooltip" data-original-title="Edit"><i class="fas fa-edit"></i></a>' .
                        '&nbsp;<button class="btn btn-danger btn-sm data-delete " data-id="' . $record->id . '" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash"></i></button>';
                })
                ->rawColumns([ 'action'])
                ->make(true);
        }
        return view('admin.contactus.index',$this->data);
    }

    public function create()
    {
        return view('admin.contactus.create',$this->data);
    }

    public function store(Request $request) {

        $this->_validate($request);
        $inputs = $request->all();

        $record = new ContactUs($inputs);
        $record->save();

        Session::flash('success', $this->data['title'] . ' inserted successfully.');
        return redirect()->route($this->data['route'] . 'index');
    }
    public function show($id)
    {
        $this->data['record'] = ContactUs::findOrFail($id);
        return view('admin.contactus.show',$this->data);
    }
    public function edit($id) {
        //abort_unless(Auth::guard('admin')->user()->hasAnyPermission(['festival_image_category edit']), 403);
        $this->data['record'] = ContactUs::findOrFail($id);
        return view('admin.contactus.create', $this->data);
    }

    public function update(Request $request, $id) {

        //abort_unless(Auth::guard('admin')->user()->hasAnyPermission(['festival_image_category edit']), 403);
        $record = ContactUs::findOrFail($id);
        /* Change Status Block */
        if ($request->ajax()) {
            $record->update($request->all());
            return \Illuminate\Support\Facades\Response::json(['result' => 'success']);
        }
        //  $this->_validate($request);

        $inputs = $request->all();
        $record->update($inputs);

        Session::flash('info', $this->data['title'] . ' updated successfully.');
        return redirect()->route($this->data['route'] . 'index');
    }
    public function destroy($id) {

        //abort_unless(Auth::guard('admin')->user()->hasAnyPermission(['festival_image_category delete']), 403);
        $record = ContactUs::findOrFail($id);

        $record->delete();
        return \Illuminate\Support\Facades\Response::json([
            'result' => 'success',
            'message' => 'Deleted Data successfully!']);
    }

}
