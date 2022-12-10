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
use Illuminate\Support\Str;
class AppController extends Controller
{
    private $data = array(
        'route' => 'admin.apps.',
        'title' => 'App',
        'menu' => 'app',
        'submenu' => '',
    );
    public function __construct()
    {
        // $this->middleware('auth');
    }
  

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $records = App::select('*');
            return DataTables::of($records)
                ->editColumn('created_at', function ($record) {
                    return $record->created_at->format(config('setting.DATE_FORMAT'));
                })
                ->addColumn('action', function ($record) {
                    return '<a href="' . route($this->data['route'] . 'show', [$record->id]) . '" class="btn btn-primary btn-sm" title="" data-toggle="tooltip" data-original-title="View"><i class="fa fa-eye-slash"></i></a>' .
                        '&nbsp;<a href="' . route($this->data['route'] . 'edit', [$record->id]) . '" class="btn btn-info btn-sm" title="" data-toggle="tooltip" data-original-title="Edit"><i class="fas fa-edit"></i></a>' .
                        '&nbsp;<button class="btn btn-danger btn-sm data-delete " data-id="' . $record->id . '" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash"></i></button>';
                })
                
                ->make(true);
        }
        return view('admin.apps.index',$this->data);
    }

    public function create()
    {
        return view('admin.apps.create',$this->data);
    }


    public function store(Request $request)
    {

        $input = $request->all();
        $request->validate([
            // 'route'=>'required',
            'name'=>'required',
        ]);
        // $input['route'] = Str::slug($input['route']);

        $user =  App::create($input);
        return redirect()->route($this->data['route'].'index')->with('success', $this->data['title'].' inserted successfully.');
    }


    public function show($id)
    {
        $this->data['record'] = App::findOrFail($id);

        return view('admin.apps.show',$this->data);
    }


    public function edit($id)
    {
        $this->data['record'] = App::findOrFail($id);
        return view('admin.apps.create',$this->data);
    }


    public function update(Request $request, $id)
    {
        $record = App::findOrFail($id);
        /* Change Status Block */


        $request->validate([
            'name'=>'required',
            // 'route'=>'required',
        ]);
        $input = $request->all();
        // $input['route'] = Str::slug($input['route']);
        unset($input['_method']);
        unset($input['_token']);

        $user =  App::where('id',$id)->update($input);

        return redirect()->route($this->data['route'].'index')->with('success','updated successfully.');
    }


    public function destroy($id)
    {
        abort_if(env('APP_ENV')=="demo",403);
        $record = App::findOrFail($id);
        $record->delete();
        return \Illuminate\Support\Facades\Response::json(['result'=>'success','message'=>'Deleted Data successfully!']);
    }

}
