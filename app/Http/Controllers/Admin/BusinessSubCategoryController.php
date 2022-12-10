<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\BusinessCategory;
use App\Models\BusinessSubCategory;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;


class BusinessSubCategoryController extends Controller
{
    private $data = array(
        'route' => 'admin.business-sub-category.',
        'title' => 'Business Sub Category ',
        'menu' => 'business',
        'submenu' => 'business-sub-category',
    );
   
    public function index(Request $request) {

        if ($request->ajax()) {
            $records = BusinessSubCategory::select('*')->with('business_category')->orderBy('id','ASC');
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
                    return '<a target="_blank" href="'.$record['image_url'].'"><img src="'.$record['image_url'].'" width="150"></a>';
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

        return view('admin.business_sub_category.index', $this->data);

    }
    public function create(Request $request) {
        if ($request->ajax()) {
            return $records = BusinessCategory::select('*')->where('app_id',$request->app_id)->orderBy('id','ASC')->pluck('name','id');
        }
        
        //abort_unless(Auth::guard('admin')->user()->hasAnyPermission(['festival_image_category add']), 403);
        return view('admin.business_sub_category.create', $this->data);
    }
    public function store(Request $request) {
        abort_if(env('APP_ENV')=="demo",403);
        
        $request->validate([
            'name' => 'required|max:255',
            'app_id'=> 'required',
            'business_category_id'=>'required',
            'image'=>'required',
        ]);
        
        $input = $request->all();
        $input['status'] = 'Active';
        $input = $request->all();
        if (isset($input["image"])) {
	        $upload_dir_path = public_path()."/storage/business-sub-category-images";
	        $file = $input["image"];
	        $filename = 'IMG_'.date('Y-m-d-h-i-s').'.'.$file->guessClientExtension();
	        $file->move($upload_dir_path, $filename );
	        $input['image'] = $filename;
		}

        $record = BusinessSubCategory::create($input);
        return redirect()->route($this->data['route'].'index')->with('success', $this->data['title'].' inserted successfully.');
    }
    public function show($id) {
        $this->data['record'] = BusinessSubCategory::findOrFail($id);
        return view('admin.business_sub_category.show', $this->data);
    }

    public function edit($id) {
        //abort_unless(Auth::guard('admin')->user()->hasAnyPermission(['festival_image_category edit']), 403);
        $this->data['record'] = BusinessSubCategory::findOrFail($id);
        return view('admin.business_sub_category.create', $this->data);
    }

    public function update(Request $request, $id) {
        abort_if(env('APP_ENV')=="demo",403);
        //abort_unless(Auth::guard('admin')->user()->hasAnyPermission(['festival_image_category edit']), 403);
        $record = BusinessSubCategory::findOrFail($id);
        /* Change Status Block */
        if ($request->ajax()) {
            $record->update($request->all());
            return \Illuminate\Support\Facades\Response::json(['result' => 'success']);
        }
       // $this->_validate($request);

        $input = $request->all();
        if (isset($input["image"])) {
	        $upload_dir_path = public_path()."/storage/business-sub-category-images";
	        $file = $input["image"];
	        $filename = 'IMG_'.date('Y-m-d-h-i-s').'.'.$file->guessClientExtension();
	        $file->move($upload_dir_path, $filename );
	        $input['image'] = $filename;
		}

        $record->update($input);

        return redirect()->route($this->data['route'].'index')->with('info', $this->data['title'].' updated successfully.');

    }
    public function destroy($id) {
        abort_if(env('APP_ENV')=="demo",403);
        //abort_unless(Auth::guard('admin')->user()->hasAnyPermission(['festival_image_category delete']), 403);
        $record = BusinessSubCategory::findOrFail($id);
        // $this->deleteFile($record,'image');
        $record->delete();
        return \Illuminate\Support\Facades\Response::json([
            'result' => 'success',
            'message' => 'Deleted Data successfully!']);
    }

}
