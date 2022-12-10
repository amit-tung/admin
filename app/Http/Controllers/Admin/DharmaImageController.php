<?php 

namespace App\Http\Controllers\Admin;

use App\Model\DharmaImage;
use App\Model\BusinessImage;
use App\Model\FestivalImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class DharmaImageController extends Controller
{
    private $data = array(
        'route' => 'admin.dharma_image.',
        'title' => 'Dharma Image ',
        'menu' => 'dharma',
        'submenu' => 'dharma_image',
    );
    
      public function __construct() {
        // $this->middleware('auth');
        //$this->middleware(['permission:publish |festival_image_category add|festival_image_category edit|festival_image_category delete']);
    }
    
    private function _validate($request, $id = null) {
        $this->validate($request, [
            'title' => 'required|max:255',
            'image'=> 'required|image|mimes:jpeg,png,jpg|max:1024',
            'dharma_image_category_id'=>'required',
            'description'=>'required',
            'language'=>'required',
        ]);
    }
    
    public function index(Request $request) {

        if ($request->ajax()) {
            $records = DharmaImage::select('*')->with('dharma_image_category')->orderBy('id','ASC');
           
            return DataTables::of($records)
                ->editColumn('sequence', function ($record) {
                    return '<input style="width:100px" type="text" class="form-control txt_inline_edit inline_update" name="" value="'.$record['sequence'].'" row_id="'.$record['id'].'" field="sequence" ajax_url="'. route($this->data['route'] . 'update',$record['id']).'" />';
                })
                ->editColumn('title', function ($record) {
                    return $record->title;
                })
                ->editColumn('image', function ($record) {
                    return '<a target="_blank" href="'.$record['image_url'].'"><img src="'.$record['image_url'].'" width="150"></a>';
                })
                ->addColumn('status', function ($record) {
                    return '<input id="toggle-demo" value="' . $record->id . '" class="chk_status" data-toggle="toggle" data-on=" Active " data-off="Inactive &nbsp;" data-size="small" data-onstyle="success" data-offstyle="info"  type="checkbox" ' . ($record->status == "Active" ? " checked" : "" ) . ' >';
                })
                ->addColumn('action', function ($record) {
                    return '<a href="' . route($this->data['route'] . 'show', ['id' => $record->id]) . '" class="btn btn-primary btn-sm" title="" data-toggle="tooltip" data-original-title="View"><i class="fa fa-eye-slash"></i></a>' .
                        '&nbsp;<a href="' . route($this->data['route'] . 'edit', ['id' => $record->id]) . '" class="btn btn-info btn-sm" title="" data-toggle="tooltip" data-original-title="Edit"><i class="fas fa-edit"></i></a>' .
                        '&nbsp;<button class="btn btn-danger btn-sm data-delete " data-id="' . $record->id . '" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash"></i></button>';
                })
                ->rawColumns(['status', 'action','image','sequence'])
                ->make(true);
        }
        return view('admin.dharma_image.index', $this->data);
    }
    
    public function create() {
        return view('admin.dharma_image.create', $this->data);
    }
    
      public function store(Request $request) {
        abort_if(env('APP_ENV')=="demo",403);
        $this->_validate($request);
        $inputs = $request->all();
        $inputs['status'] = 'Active';
        $inputs['image'] = $this->uploadFile($request, null, 'image', 'dharma_image');

        $record = new DharmaImage($inputs);
        $record->save();

        Session::flash('success', $this->data['title'] . ' inserted successfully.');
        return redirect()->route($this->data['route'] . 'index');
    }
    public function show($id) {
        $this->data['record'] = DharmaImage::findOrFail($id);
        return view('admin.dharma_image.show', $this->data);
    }

    public function edit($id) {
        //abort_unless(Auth::guard('admin')->user()->hasAnyPermission(['festival_image_category edit']), 403);
        $this->data['record'] = DharmaImage::findOrFail($id);
        return view('admin.dharma_image.create', $this->data);
    }
    
    public function update(Request $request, $id) {
        abort_if(env('APP_ENV')=="demo",403);
        //abort_unless(Auth::guard('admin')->user()->hasAnyPermission(['festival_image_category edit']), 403);
        $record = DharmaImage::findOrFail($id);
        /* Change Status Block */
        if ($request->ajax()) {
            $record->update($request->all());
            return \Illuminate\Support\Facades\Response::json(['result' => 'success']);
        }
       // $this->_validate($request);

        $inputs = $request->all();
        $inputs['image'] = $this->uploadFile($request, $record, 'image', 'dharma_image');
        if (empty($inputs['image'])) {
            unset($inputs['image']);
        }
        $record->update($inputs);

        Session::flash('info', $this->data['title'] . ' updated successfully.');
        return redirect()->route($this->data['route'] . 'index');
    }
    public function destroy($id) {
        abort_if(env('APP_ENV')=="demo",403);
        //abort_unless(Auth::guard('admin')->user()->hasAnyPermission(['festival_image_category delete']), 403);
        $record = DharmaImage::findOrFail($id);
        $this->deleteFile($record,'image');
        $record->delete();
        return \Illuminate\Support\Facades\Response::json([
            'result' => 'success',
            'message' => 'Deleted Data successfully!']);
    }
}

?>