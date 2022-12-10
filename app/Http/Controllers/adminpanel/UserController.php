<?php
namespace App\Http\Controllers\adminpanel;
use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\File;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Validator;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    private $pagination = 10;
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
                ->addColumn('action', function ($record) {
                    return '<a href="' . route($this->data['route'] . 'show', ['id' => $record->id]) . '" class="btn btn-primary btn-sm" title="" data-toggle="tooltip" data-original-title="View"><i class="fa fa-eye-slash"></i></a>' .
                        '&nbsp;<a href="' . route($this->data['route'] . 'edit', ['id' => $record->id]) . '" class="btn btn-info btn-sm" title="" data-toggle="tooltip" data-original-title="Edit"><i class="fas fa-edit"></i></a>' .
                        '&nbsp;<button class="btn btn-danger btn-sm data-delete " data-id="' . $record->id . '" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash"></i></button>';
                })
                ->rawColumns(['status', 'action','plan_start'])
                ->make(true);
        }


        $data = User::query()->orderBy('created_at','desc')->paginate($this->pagination);
        return view('adminpanel.users.index', compact('data'));
    }
    public function create()
	{
        
		$data = array('type'=>'add');
        return view('adminpanel.users.create', compact('data'));
    }
    public function save(Request $request)
	{
        $input = $request->all();
		$agent = Agent::select( DB::raw("CONCAT(first_name,' ',last_name) AS name"),'id')->pluck('name','id');
		
        $validator = Validator::make( $input, $this->getRules('Add', $input), $this->messages());
        if ($validator->fails())
		{
            $data = array('type'=>'add', 'input'=>$input,'agent'=>$agent, 'error'=>$validator->messages());
            return view('adminpanel.adduser', compact('data'));
            exit();            
        }

        $input['password'] = bcrypt($input['password']);
        $input['user_type'] = 2;
        $input['description'] = $input['cdescription']??null;

		
		
        $user = User::create($input);
        if (isset($input["profilePicture"])) {  
          
            $path = Storage::disk('public')->put('media', $input["profilePicture"]);
            File::create([
                'user_id' => $user->id,
                'file_name' => $input["profilePicture"]->getClientOriginalName(),
                'path' => $path,
                'extension' => $input["profilePicture"]->guessClientExtension() ?? '',
                'mime' => $input["profilePicture"]->getClientMimeType(),
                'size' => $input["profilePicture"]->getSize(),
            ]);    
        } 
        if($user->id>0) {
            return redirect()->route('adminpanel.user.manage')->with('success', 'Customer Created successfully.');
        } else {
            return redirect()->route('adminpanel.user.add')->withErrors(['Error creating record. Please try again.']);
        }
    }
	public function edit($id)
	{
        $input = User::where('id', '=', $id)->first();
        $agent = Agent::select( DB::raw("CONCAT(first_name,' ',last_name) AS name"),'id')->pluck('name','id');
        $data = array('type'=>'edit', 'input'=>$input,'agent'=>$agent);

	    return view('adminpanel.adduser', compact('data'));
	}
	public function update(Request $request)
	{
		$input = $request->all();
        $id = $input['id'];
		$agent = Agent::select( DB::raw("CONCAT(first_name,' ',last_name) AS name"),'id')->pluck('name','id');
		
        $validator = Validator::make( $input, $this->getRules('Edit', $input), $this->messages()); 
        if ($validator->fails())
		{ 
            $agent = Agent::select( DB::raw("CONCAT(first_name,' ',last_name) AS name"),'id')->pluck('name','id');
            $data = array('type'=>'Edit', 'input'=>$input,'agent'=>$agent, 'error'=>$validator->messages());
            return view('adminpanel.adduser', compact('data','agent'));
            exit();
        }

        $update = array();
        $update["nick_name"] = $input['nick_name']??null;
        $update["bio"] = $input['bio']??null;
        $update["name"] = $input['name'];
        $update["number"] = $input['number'];
        $update["agent_id"] = $input['agent_id'];
        $update["dob"] = $input['dob'];
        $update["email"] = $input['email'];
        $update["activities"] = $input['activities']??null;
        $update["food_pregense"] = $input['food_pregense']??null;
        $update["height"] = $input['height']??null;
        $update["nationality"] = $input['nationality']??null;
        $update["availablity"] = $input['availablity']??null;
        $update["description"] = $input['cdescription']??null;
		
        $update["meet_up_rate"] = $input['meet_up_rate']??null;
        $update["meet_up_duration"] = $input['meet_up_duration']??null;
        $update["drinks"] = $input['drinks']??null;
        
		$update["is_promoted"] = $input['is_promoted']??0;
        $update["is_verified"] = $input['is_verified']??0;
        $update["is_featured"] = $input['is_featured']??0;
        $update["is_active"] = $input['is_active']??0;
		
		if(isset($input['password']))
		{
            $update["password"] = bcrypt($input['password']);
        }
		
		// if(isset($input["profilePicture"]))
		// {
		// 	$upload_dir_path = public_path()."/uploads/User";
        //     $imagePath = $input["profilePicture"];
        //     $filename = rand(0000,9999).$imagePath->getClientOriginalName();

        //     $result = $this->removeimage($upload_dir_path, $id);			
        //     $imagePath->move($upload_dir_path, $filename);

        //     $update['profilePicture'] = $filename;
        // }
        if (isset($input["profilePicture"])) {  
           
            $file = File::where('user_id','=',$id)->first();
            if($file)
            {
                Storage::disk('public')->delete( $file->path);
                $path = Storage::disk('public')->put('media', $input["profilePicture"]);
                $file->update([
                    'file_name' => $input["profilePicture"]->getClientOriginalName(),
                    'path' => $path,
                    'extension' => $input["profilePicture"]->guessClientExtension() ?? '',
                    'mime' => $input["profilePicture"]->getClientMimeType(),
                    'size' => $input["profilePicture"]->getSize(),
                ]); 
            }
            else
            {
                $path = Storage::disk('public')->put('media', $input["profilePicture"]);
                File::create([
                    'user_id' => $id,
                    'file_name' => $input["profilePicture"]->getClientOriginalName(),
                    'path' => $path,
                    'extension' => $input["profilePicture"]->guessClientExtension() ?? '',
                    'mime' => $input["profilePicture"]->getClientMimeType(),
                    'size' => $input["profilePicture"]->getSize(),
                ]);    
        
            } 
        }
        $user = User::where('id', '=', $id)->update($update);
        return redirect()->route('adminpanel.user.manage')->with('success', 'Customer Updated successfully.');
	}
	public function delete($id)
	{
		$upload_dir_path = public_path()."/uploads/User";
        $result = $this->removeimage($upload_dir_path, $id);
		
		User::where('id','=',$id)->delete();
        return redirect()->route('adminpanel.user.manage')->with('success', 'Deleted successfully.');
    }
    private function removeimage($imagepath, $id)
	{
        $user = User::where('id', '=', $id)->get();
        if($user[0]->profilePicture!=null && $user[0]->profilePicture!="")
		{
            if(file_exists($imagepath.'\\'.$user[0]->profilePicture))
			{
                unlink($imagepath.'\\'.$user[0]->profilePicture);
            }
        }
        return true;
    }
	public function search(Request $request)
	{
        $input = $request->all();
        $qry = User::query(); 

        if(trim($input["search"])!="")
		{
            $search = $input["search"];
            $qry->where([
                ["name", "like", "%{$search}%"],
            ]);
			$qry->orwhere([
                ["first_name", "like", "%{$search}%"],
            ]);
            $qry->orwhere([
                ["last_name", "like", "%{$search}%"],
            ]);
            $qry->orwhere([
                ["email", "like", "%{$search}%"],
            ]);
        }
        $data = $qry->paginate($this->pagination);
        $data->appends($input);
        return view('adminpanel.manageuser', compact('data'));

    }
	private function getRules($type, $input)
	{
        $return = array();
        $return['name'] = 'required|max:60';
        $return['agent_id'] = 'required';
		if($type=="Edit")
		{
            $return['email'] = 'required|email|max:100';
        }
		else
		{
            $return['email'] = 'required|email|unique:users,email|max:100';
            $return['password'] = 'required|min:6|max:20';
        }
		$return['number'] = 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:13';
		$return['dob'] = 'required|date_format:Y-m-d';        
        return $return;
    }
    private function messages() {
        return [
            'first_name.required'  => $this->getRequiredMessage('first name'),
            'first_name.max'  => $this->getGreaterMessage('first name', 30),
            'last_name.required'  => $this->getRequiredMessage('last name'),
            'last_name.max'  => $this->getGreaterMessage('last name', 30),
            'number.required'  => $this->getRequiredMessage('Enter Phone No.'),
            'number.max'  => $this->getGreaterMessage('Enter Phone No.', 20),
            'email.required'  => $this->getRequiredMessage('email'),
            'email.max'  => $this->getGreaterMessage('email ', 100),
        ];
    }
    private function getRequiredMessage($string) {
        return 'The ' . $string . ' field is required.';
    }
    private function getGreaterMessage($string, $maxchar) {
        return 'The ' . $string . ' may not be greater than ' . $maxchar . ' characters.';
    }
}
?>