<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserFrame;
use App\Models\User;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    private $data = array(
        'route' => 'admin.user.',
        'title' => 'User',
        'menu' => 'user',
        'submenu' => '',
    );
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $records = User::select('*');
            return DataTables::of($records)
                ->editColumn('created_at', function ($record) {
                    return $record->created_at->format(config('setting.DATE_FORMAT'));
                })
                ->editColumn('plan_start', function ($record) {
                    return !empty($record->plan_start)?$record->plan_start:'<button class="btn btn-success add_date" data-id="' . $record->id.'"> Purchase</button>';
                })
                ->addColumn('status', function ($record) {
                    return '<input id="toggle-demo" value="' . $record->id . '" class="chk_status" data-toggle="toggle" data-on="Active" data-off="Inactive" data-size="small" data-onstyle="success" data-offstyle="info"  type="checkbox" ' . ($record->status == "Active" ? " checked" : "" ) . ' >';
                })
                ->addColumn('app', function ($record) {
                    return  $record->app->name;
                })
                ->addColumn('action', function ($record) {
                    return '<a href="' . route($this->data['route'] . 'show', [$record->id]) . '" class="btn btn-primary btn-sm" title="" data-toggle="tooltip" data-original-title="View"><i class="fa fa-eye-slash"></i></a>' .
                        '&nbsp;<a href="' . route($this->data['route'] . 'edit', [$record->id]) . '" class="btn btn-info btn-sm" title="" data-toggle="tooltip" data-original-title="Edit"><i class="fas fa-edit"></i></a>' .
                        '&nbsp;<button class="btn btn-danger btn-sm data-delete " data-id="' . $record->id . '" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash"></i></button>';
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('appId')) {
                        $instance->where('app_id', $request->get('appId'));
                    }
                    if (!empty($request->get('search'))) {
                         $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->where(function($q) use($search){
                                $q->orWhere('name', 'LIKE', "%$search%")
                                ->orWhere('contact', 'LIKE', "%$search%")
                                ->orWhere('email', 'LIKE', "%$search%");
                            });

                        });
                    }
                })
                ->rawColumns(['status', 'action','plan_start'])
                ->make(true);
        }
        
        $this->data['apps'] = App::query()->pluck('name','id');
        return view('admin.user.index',$this->data);
    }

    public function create()
    {
        return view('admin.user.create',$this->data);
    }


    public function store(Request $request)
    {

        $input = $request->all();
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'username'=>'required',
            'email' => 'required|email|unique:users,email',
            'contact' => 'required|unique:users,contact',
            'username'=>'required|unique:users,username',
            'password'=>'required',
            'gender'=>'required',
            'country'=>'required',
            'state'=>'required',
            'city'=>'required',
            'business'=>'required',
        ]);

        $input['password'] = bcrypt($request['password']);
        $input['status'] = 'Active';
        $input['name'] = $request->first_name.' ' .$request->last_name ;

        if (isset($input["image"])) {
	        $upload_dir_path = public_path()."/storage/profile-images";
	        $file = $input["image"];
            // $ext = $file->guessClientExtension();
	        $filename = 'IMG_'.date('Y-m-d-h-i-s').'.'.$file->guessClientExtension();
	        $file->move($upload_dir_path, $filename );
	        $input['image'] = $filename;
		}
        $user =  User::create($input);
        return redirect()->route($this->data['route'].'index')->with('success', $this->data['title'].' inserted successfully.');
    }


    public function show($id)
    {
        $this->data['record'] = User::findOrFail($id);
        $this->data['business'] = Company::where('user_id',$id)->get();
        $this->data['user_frames'] = UserFrame::where('user_id',$id)->get();

        return view('admin.user.show',$this->data);
    }


    public function edit($id)
    {
        $this->data['record'] = User::findOrFail($id);
        return view('admin.user.create',$this->data);
    }


    public function update(Request $request, $id)
    {
        $record = User::findOrFail($id);
        if ($request->ajax() && !empty($request['date'])) {
            $date = Carbon::now()->format('Y-m-d');
            $record->plan_start = $date;
            $record->plan_end = Carbon::now()->addYear()->format('Y-m-d');
            $record->save();
            return \Illuminate\Support\Facades\Response::json([
                'result'=>'success',
                'date'=>$date
            ]);
        }

        /* Change Status Block */

        if ($request->ajax()) {

            $record->update($request->only(['status']));
            return \Illuminate\Support\Facades\Response::json(['result'=>'success']);
        }

        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'username'=>'required',
            'email'=>'required|email',
            'contact'=>'required',
            'gender'=>'required',
            'country'=>'required',
            'state'=>'required',
            'city'=>'required',
            'business'=>'required',
        ]);
        $input = $request->all();
        if (isset($input["image"])) {
	        $upload_dir_path = public_path()."/storage/profile-images";
	        $file = $input["image"];
            // $ext = $file->guessClientExtension();
	        $filename = 'IMG_'.date('Y-m-d-h-i-s').'.'.$file->guessClientExtension();
	        $file->move($upload_dir_path, $filename );
	        $input['image'] = $filename;
		}

        if($input['password']){
            $input['password'] = bcrypt($input['password']);
        }
        if(empty($input['password'])){
            unset($input['password']);
        }
        unset($input['_method']);
        unset($input['_token']);

        $user =  User::where('id',$id)->update($input);

        return redirect()->route($this->data['route'].'index')->with('success','updated successfully.');
    }


    public function destroy($id)
    {
        abort_if(env('APP_ENV')=="demo",403);
        $record = User::findOrFail($id);
        $record->delete();
        return \Illuminate\Support\Facades\Response::json(['result'=>'success','message'=>'Deleted Data successfully!']);
    }

    public function user_update_company(Request $request){
        abort_if(env('APP_ENV')=="demo",403);
        $company = Company::find($request['company_id']);
        $inputs = $request->all();
        $inputs['logo'] = $this->uploadFile($request, $company, 'logo', 'company');
        if (empty($inputs['logo'])) {
            unset($inputs['logo']);
        }
        if (!empty($company)){
            $company->update($inputs);
        }

        Session::flash('success','Company updated successfully.');
        return redirect()->back();
    }

    public function add_custom_frame(Request $request){


        abort_if(env('APP_ENV')=="demo",403);
        $inputs = $request->all();
        $inputs['user_id'] = $inputs['user_id'];
        $inputs['status'] = 'Active';
        $inputs['image'] = $this->uploadFile($request, null, 'image', 'user_frame');
        $record =  new UserFrame($inputs);
        $record->save();

        Session::flash('success', $this->data['title'].' inserted successfully.');

        //return view('admin.user.show');

        return redirect()->back();
    }
    public function delete_custom_frame($id){
        abort_if(env('APP_ENV')=="demo",403);
        $record = UserFrame::findOrFail($id);
        $record->delete();
        Session::flash('danger', $this->data['title'].' Deleted Data successfully.');

        return redirect()->back();

        // return \Illuminate\Support\Facades\Response::json(['result'=>'success','message'=>'Deleted Data successfully!']);
    }


}
