<?php

namespace App\Http\Controllers\Admin;

use App\Models\BusinessPost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\BusinessCategory;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;


class BusinessPostController extends Controller
{
    private $data = array(
        'route' => 'admin.business-post.',
        'title' => 'Business Image ',
        'menu' => 'business',
        'submenu' => 'business-post',
    );
   
    public function index(Request $request) {

        if ($request->ajax()) {
            $records = BusinessPost::select('*')->with('business_category')->orderBy('id','ASC');
            if ($request->appId) {
                $records->where('app_id',$request->get('appId'));
            }
            return DataTables::of($records)
                ->editColumn('sequence', function ($record) {
                    return '<input style="width:100px" type="text" class="form-control txt_inline_edit inline_update" name="" value="'.$record['sequence'].'" row_id="'.$record['id'].'" field="sequence" ajax_url="'. route($this->data['route'] . 'update',$record['id']).'" />';
                })
                ->editColumn('title', function ($record) {
                    return $record->title;
                })
                ->editColumn('image', function ($record) {
                    return '<a target="_blank" href="'.$record['media_url'].'"><img src="'.$record['media_url'].'" width="150"></a>';
                })
                ->addColumn('status', function ($record) {
                    return '<input id="toggle-demo" value="' . $record->id . '" class="chk_status" data-toggle="toggle" data-on=" Active " data-off="Inactive &nbsp;" data-size="small" data-onstyle="success" data-offstyle="info"  type="checkbox" ' . ($record->status == "Active" ? " checked" : "" ) . ' >';
                })
                ->addColumn('action', function ($record) {
                    return '<a href="' . route($this->data['route'] . 'show',  $record->id) . '" class="btn btn-primary btn-sm" title="" data-toggle="tooltip" data-original-title="View"><i class="fa fa-eye-slash"></i></a>' .
                        '&nbsp;<a href="' . route($this->data['route'] . 'edit',  $record->id) . '" class="btn btn-info btn-sm" title="" data-toggle="tooltip" data-original-title="Edit"><i class="fas fa-edit"></i></a>' .
                        '&nbsp;<button class="btn btn-danger btn-sm data-delete " data-id="' . $record->id . '" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash"></i></button>';
                })
                ->rawColumns(['status', 'action','image','sequence'])
                ->make(true);
        }
        $this->data['apps'] = App::query()->pluck('name','id');

        return view('admin.business_post.index', $this->data);

    }
    public function create(Request $request) {
        if ($request->ajax()) {
            return $records = BusinessCategory::select('*')->where('app_id',$request->app_id)->orderBy('id','ASC')->pluck('name','id');
        }
        
        //abort_unless(Auth::guard('admin')->user()->hasAnyPermission(['festival_image_category add']), 403);
        return view('admin.business_post.create', $this->data);
    }
    public function store(Request $request) {
        abort_if(env('APP_ENV')=="demo",403);
        
        $request->validate([
            'title' => 'required|max:255',
            'media'=> 'required',
            'media_type'=> 'required',
            'business_category_id'=>'required',
            'description'=>'required',
            'language'=>'required',
        ]);
        
        $input = $request->all();
        $input['status'] = 'Active';
        $input = $request->all();
        if (isset($input["media"])) {
	        $upload_dir_path = public_path()."/storage/business-".$input['media_type'];
	        $file = $input["media"];
	        $filename = 'IMG_'.date('Y-m-d-h-i-s').'.'.$file->guessClientExtension();
	        $file->move($upload_dir_path, $filename );
	        $input['media'] = $filename;
		}

        $record = BusinessPost::create($input);
        return redirect()->route($this->data['route'].'index')->with('success', $this->data['title'].' inserted successfully.');
    }
    public function show($id) {
        $this->data['record'] = BusinessPost::findOrFail($id);
        return view('admin.business_post.show', $this->data);
    }

    public function edit($id) {
        //abort_unless(Auth::guard('admin')->user()->hasAnyPermission(['festival_image_category edit']), 403);
        $this->data['record'] = BusinessPost::findOrFail($id);
        return view('admin.business_post.create', $this->data);
    }

    public function update(Request $request, $id) {
        abort_if(env('APP_ENV')=="demo",403);
        //abort_unless(Auth::guard('admin')->user()->hasAnyPermission(['festival_image_category edit']), 403);
        $record = BusinessPost::findOrFail($id);
        /* Change Status Block */
        if ($request->ajax()) {
            $record->update($request->all());
            return \Illuminate\Support\Facades\Response::json(['result' => 'success']);
        }
       // $this->_validate($request);

        $input = $request->all();
        if (isset($input["media"])) {
	        $upload_dir_path = public_path()."/storage/business-".$input['media_type'];
	        $file = $input["media"];
	        $filename = 'IMG_'.date('Y-m-d-h-i-s').'.'.$file->guessClientExtension();
	        $file->move($upload_dir_path, $filename );
	        $input['media'] = $filename;
		}
        $record->update($input);

        return redirect()->route($this->data['route'].'index')->with('info', $this->data['title'].' updated successfully.');

    }
    public function destroy($id) {
        abort_if(env('APP_ENV')=="demo",403);
        //abort_unless(Auth::guard('admin')->user()->hasAnyPermission(['festival_image_category delete']), 403);
        $record = BusinessPost::findOrFail($id);
        // $this->deleteFile($record,'image');
        $record->delete();
        return \Illuminate\Support\Facades\Response::json([
            'result' => 'success',
            'message' => 'Deleted Data successfully!']);
    }

}
