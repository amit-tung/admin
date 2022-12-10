<?php

namespace App\Http\Controllers\Admin;

use App\Models\BusinessImage;
use App\Models\BusinessVideo;
use App\Models\FestivalVideo;
use App\Models\GreetingImage;
use App\Models\FestivalImage;
use App\Models\VideoUpload;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    private $data = array(
        'route' => 'admin.home.',
        'title' => 'Dashboard',
        'menu' => 'home',
        'submenu' => '',
    );

    public function home(){


            $this->data['business_image'] = BusinessImage::count();
            $this->data['business_video'] = BusinessVideo::count();
            $this->data['festival_image'] = FestivalImage::count();
            $this->data['festival_video'] = FestivalVideo::count();
            $this->data['greeting_image'] = GreetingImage::count();
         //   $this->data['greeting_video'] = FestivalImage::count();
        return view('admin.dashboard', $this->data);

    }

    public function profile(){
        $this->data['record'] = auth()->guard('admin')->user();
        $this->data['title'] = "Profile";
        $this->data['submenu'] = "profile";
        return view('admin.profile.profile',$this->data);
    }

    public function profile_post(Request $request){
        $auth = auth()->guard('admin')->user();
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admins,email'.(!empty($auth->id)?','.$auth->id:''),
            //'password' => ($id == null)?'required|required_with:password_confirmation|max:255':'required_with:password_confirmation|max:255',
            //'password_confirmation' => 'required_with:password|max:255|same:password',
        ]);

        $inputs = $request->all();
        if(!empty($request['password'])){
            $inputs['password'] = bcrypt($request['password']);
        }else{
            unset($inputs['password']);
        }

        $auth->update($inputs);
        Session::flash('success','Profile updated successfully.');
        return redirect()->back();
        //return $inputs;
    }


}
