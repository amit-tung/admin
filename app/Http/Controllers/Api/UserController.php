<?php

namespace App\Http\Controllers\Api;

use App\Models\Business;
use App\Models\Company;
use App\Models\FestivalImage;
use App\Models\Plan;
use App\Models\Purchase;
use App\Models\UserFrame;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    
    public function register(Request $request)
    {

        $input = $request->all();
        $app_id = $request->header('app-id');
        if (!$app_id) {
            $response['status'] = '0';
            $response['message'] = 'app-id field required in header';
            return response()->json($response,401);
        }
        $validator = Validator::make($request->all(), [
            'first_name'=>'required',
            'last_name'=>'required',
            'username'=>'required|unique:users,username',
            'password'=>'required',
            'gender'=>'required',
            'country'=>'required',
            'state'=>'required',
            'taluka'=>'required',
            'city'=>'required',
            'business'=>'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'contact' => 'required|unique:users,contact',
        ]);
        if ($validator->fails()) {
            $response['status'] = '0';
            $response['message'] = $errors = $validator->errors()->first();
            $response['errors'] = $errors = $validator->errors();
            return response()->json($response,401);
        } else {
          
            $input['password'] =bcrypt($request['password']);
            $input['status'] ="Active";
            $input['name'] =$request->first_name.' '. $request->last_name;
            $input['app_id'] =$app_id;

            if (isset($input["image"])) {
                $upload_dir_path = public_path()."/storage/profile-images";
                $file = $input["image"];
                // $ext = $file->guessClientExtension();
                $filename = 'IMG_'.date('Y-m-d-h-i-s').'.'.$file->guessClientExtension();
                $file->move($upload_dir_path, $filename );
                $input['image'] = $filename;
            }

            $user = User::create($input);
            $this->sms_otp_send($user, 'sms_otp');
        
            $response['status'] = '1';
            $response['api_token'] = $user->createToken('API Token')->accessToken;
            $response['message'] = 'User registered successfully';
            $response['result'] = $user;
            return response()->json($response,200);
        }
    }

    public function register_sms(Request $request)
    {
        $app_id = $request->header('app-id');
        if (!$app_id) {
            $response['status'] = '0';
            $response['message'] = 'app-id field required in header';
            return response()->json($response,401);
        }


        $validator = Validator::make($request->all(), [
            'name' => 'required',
        //    'email' => 'required|email|unique:users,email',
        //    'password' => 'required',
            'contact' => 'required|unique:users,contact',
        ]);
        if ($validator->fails()) {
            $response['result'] = '0';
            $response['message'] = $errors = $validator->errors()->first();
            $response['errors'] = $errors = $validator->errors();
        } else {
            $user = User::create([
                'name' => $request['name'],
            //    'email' => $request['email'],
            //    'password' => bcrypt($request['password']),
                // 'image' => $this->uploadFile($request, null, 'image', 'user'),
                'city' => $request['city'],
                'business' => $request['business'],
                'contact' => $request['contact'],
                'status'=> 'Active',
            ]);

            $this->sms_otp_send($user, 'sms_otp');

            $status_code = 200;
            $response['result'] = '1';
            $response['message'] = 'User registered successfully';
            $response['record'] = User::find($user->id);
        }
        return response()->json($response,200);
    }

    public function login(Request $request)
    {

        $app_id = $request->header('app-id');
        if (!$app_id) {
            $response['status'] = '0';
            $response['message'] = 'app-id field required in header';
            return response()->json($response,401);
        }
        if(is_numeric($request['email'])){
            $validator = Validator::make($request->all(), [
            'email' => 'required|numeric',
            'password' => 'required',
        ]);
        }else{
              $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        }
      
        if ($validator->fails()) {
            $response['status'] = '0';
            $response['message'] = $errors = $validator->errors()->first();
            $response['errors'] = $errors = $validator->errors();
            $status_code = 422;
            return response()->json($response,422);
        } else {
            $status_code = 200;
            $checkValue = is_numeric($request['email']) ? 'contact':'email';
           
            $data = [
                $checkValue=>$request->email,
                'password'=>$request->password,
                'app_id'=>$app_id
            ];
           
           

            // if(!empty($auth) && $auth['status']== 'Inactive'){

            //     $response['status'] = '0';
            //     $response['message'] = 'User is inactive';
            //     return response()->json($response,401);
            // }
            if (auth()->attempt($data)) {
                $auth = auth()->user();
                // if ($auth['contact_verify'] == 0) {
                //     $this->sms_otp_send($auth, 'sms_otp');
                // }

                $response['status'] = '1';
                $response['message'] = 'login successfully';
                $response['api_token'] = auth()->user()->createToken('API Token')->accessToken;
                if (!empty($auth['plan_end']) && $auth['plan_end'] >= Carbon::now()->format('Y-m-d')){
                    $auth['plan_type'] = "Premium";
                }else{
                    if ($auth['created_at']->addDays(7)->format('Y-m-d') >= Carbon::now()->format('Y-m-d')){
                        $auth['plan_type'] = "Demo";
                    }else{
                        $auth['plan_type'] = "Expired";
                    }
                }
                $response['resutl'] = $auth;
                return response()->json($response,200);

            } else {
                $response['status'] = '0';
                $response['message'] = 'Invalid email or password';
                return response()->json($response,401);

            }
        }
    }

    public function login_sms(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact' => 'required',
        ]);
        if ($validator->fails()) {
            $response['result'] = '0';
            $response['message'] = $errors = $validator->errors()->first();
            $response['errors'] = $errors = $validator->errors();
            $status_code = 422;
        } else {
            $status_code = 200;
            $auth = User::where('contact', $request['contact'])->first();

            if(!empty($auth) && $auth['status']== 'Inactive'){

                $response['result'] = '0';
                $response['message'] = 'User is inactive';

                return Response::json($response);
            }
            if (!empty($auth)) {

                $this->sms_otp_send($auth, 'sms_otp');

                $random = Str::random(100);
                $auth->update(['api_token' => $random]);


                $response['result'] = '1';
                $response['message'] = 'login successfully';
                $response['api_token'] = $auth->api_token;
                if (!empty($auth['plan_end']) && $auth['plan_end'] >= Carbon::now()->format('Y-m-d')){
                    $auth['plan_type'] = "Premium";
                }else{
                    if ($auth['created_at']->addDays(7)->format('Y-m-d') >= Carbon::now()->format('Y-m-d')){
                        $auth['plan_type'] = "Demo";
                    }else{
                        $auth['plan_type'] = "Expired";
                    }
                }
                $response['record'] = $auth;
            } else {
                $response['result'] = '0';
                $response['message'] = 'Invalid contact number';
            }
        }
        return Response::json($response);
    }

    public function forget_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact' => 'required',
        ]);
        if ($validator->fails()) {
            $response['result'] = '0';
            $response['message'] = $errors = $validator->errors()->first();
            $response['errors'] = $errors = $validator->errors();
            $status_code = 422;
        } else {
            $status_code = 200;
            $auth = User::where('contact', $request['contact'])->first();
            if(!empty($auth)){
                $this->sms_otp_send($auth, 'reset_otp');
                $response['result'] = '1';
                $response['message'] = 'otp sent successfully';
            }else{
                $response['result'] = '0';
                $response['message'] = 'invalid contact ';
            }

        }
        return Response::json($response);
    }

    public function reset_password(Request $request){

        $validator = Validator::make($request->all(), [
            'contact' => 'required',
        ]);
        if ($validator->fails()) {
            $response['result']='0';
            $response['message']=$errors = $validator->errors()->first();
            $response['errors']=$errors = $validator->errors();
            $status_code = 422;
        }else{
            $status_code = 200;
            $auth = User::where('contact', $request['contact'])->where('reset_otp',$request['reset_otp'])->first();
            if (!empty($auth)) {

                $auth->update(['password' => bcrypt($request['password'])]);
                $response['result'] = '1';
                $response['message'] = 'password changed successfully';
                $response['record'] = $auth;
            } else {
                $response['result'] = '0';
                $response['message'] = 'Invalid contact or reset_otp';
            }


            }
        return Response::json($response);
    }

    public function check_otp(Request $request)
    {
        $input = $request->all();
        $contact = $input['contact'];
        $user = User::where('contact', $contact)->first();

        if (!empty($user) || $user != '') {
            if (!empty($input['sms_otp']) && $user['sms_otp'] == $input['sms_otp']) {

                $random = Str::random(100);
                $contact_verify = 1;
                $user->update(['api_token' => $random, 'contact_verify' => $contact_verify]);
                $response['result'] = '1';
                $response['message'] = 'sms otp match';
                $response['api_token'] = $user->api_token;
                $response['contact_verify'] = 1;
                $response['record'] = $user;

            } else {
                //$user->update(['contact_verify'=>0]);
                $response['result'] = '0';
                $response['contact_verify'] = 0;
                $response['message'] = 'sms otp not match';

                //$this->sms_otp_send($user);

            }
            return Response::json($response);
        }

    }

    public function profile(Request $request)
    {

        $user = auth()->user();
        $response['status'] = '1';
        $response['message'] = 'Profile details';
        $response['result'] = $user;
        return response()->json($response,200);
    }
    public function profileUpdate(Request $request)
    {

        $input = $request->all();
        $user = auth()->user();

        if (!empty($input['password'])) {
            $input['password'] = bcrypt($input['password']);
        }
        if (!empty($request['email'])) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users,email,' . auth()->id(),
            ]);
            if ($validator->fails()) {
                $response['status'] = '0';
                $response['message'] = $errors = $validator->errors()->first();
                $response['errors'] = $errors = $validator->errors();
                return response()->json($response,401);
            }
        }

        if (isset($input["image"])) {
            $upload_dir_path = public_path()."/storage/profile-images";
            $file = $input["image"];
            $filename = 'IMG_'.date('Y-m-d-h-i-s').'.'.$file->guessClientExtension();
            $file->move($upload_dir_path, $filename );
            $input['image'] = $filename;
        }

        if(User::where('id',auth()->id())->update($input))
        {
            $user = User::find(auth()->id());
            $response['status'] = '1';
            $response['message'] = 'Profile Updated';
            $response['result'] = $user;
            return response()->json($response,200);
        }
        else
        {
            $response['status'] = '0';
            $response['message'] = 'Somting went wrong';
            return response()->json($response,401);
        }

    }

    public function user_list(Request $request)
    {
        $auth = User::where('api_token', $request['api_token'])->first();
        if (!empty($auth)) {
            $query = User::query();
            if (!empty($request['search'])) {
                $query->where('name', 'LIKE', '%' . $request['search'] . '%');
            }
            $users = $query->paginate();

            $response['result'] = '1';
            $response['message'] = 'success';
            $response['records'] = $users;

        } else {
            $response['result'] = '0';
            $response['is_expired'] = '1';
            $response['message'] = 'Invalid token. Please login again!';
        }
        return Response::json($response);
    }

    // add category images
    public function category_images_add(Request $request)
    {

        $auth = User::where('api_token', $request['api_token'])->first();
        if (!empty($auth)) {
            $category = FestivalImage::create([
                'status' => 'Active',
                'image' => $this->uploadFile($request, null, 'image', 'category'),
                'title' => $request['title'],
                'description' => $request['description']

            ]);
            $response['result'] = '1';
            $response['message'] = 'FestivalImageCategory Image Added successfully';
            $response['record'] = Category::find($category->id);

        } else {
            $response['result'] = '0';
            $response['is_expired'] = '1';
            $response['message'] = 'Invalid token. Please login again!';
        }
        return Response::json($response);
    }

    public function sms_otp_send($auth, $field)
    {
        // START SMS

        $sms_code = random_int(111111, 999999);
        // save otp to db
        $auth->$field = $sms_code;
        $auth->save();
        //END SMS
        
        // $url = 'http://thenextwebs.com';
        // $data = array(
        //     'apikey' => env('SMS_APIKEY'),
        //     'route' => 'trans_dnd',
        //     'sender' => env('SMS_SENDERNAME'),
        //     'mobileno' => $auth->contact,
        //     'text' => urldecode('Welcome%20Thank%20you.')
        //  );
         
       
        //  'message' => 'limitededitionfloors '.PHP_EOL.' your otp is '.$sms_code .PHP_EOL.' - BJP Digital Poster '.PHP_EOL.' - UNLTED',
         $url = 'http://136.243.145.204/sendSMS';
         $data = array(
            'username' => 's147',
            'message' => 'Dear User '.PHP_EOL.' your Otp is '.$sms_code .PHP_EOL.' Wish you - UNITED',
            
            'sendername' => 'UNLTED',
            'smstype' => 'TRANS',
            'numbers' => $auth->contact,
            'apikey' => 'e01cdc09-1797-411f-a374-afdf37a6a97d',
         );

        $query_string = http_build_query($data);
         $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url . '?' . $query_string); //Url together with parameters
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Return data instead printing directly in Browser
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 7); //Timeout after 7 seconds
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $result = curl_exec($ch);
        curl_close($ch);


        // send sms stop
    }

    public function feedback(Request $request)
    {
        //        return $request->all();
        $auth = User::where('api_token', $request['api_token'])->first();

        $validator = Validator::make($request->all(), [
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            $response['result'] = '0';
            $response['message'] = $errors = $validator->errors()->first();
            $response['errors'] = $errors = $validator->errors();
        } else {
            if (!empty($auth)) {
                $feedback = Model\Feedback::create([
                    'user_id' => $auth['id'],
                    'name' => $request['name'],
                    'contact' => $request['contact'],
                    'description' => $request['description'],

                ]);
                $status_code = 200;
                $response['result'] = '1';
                $response['message'] = 'feedback successfully';
                $response['record'] = Model\Feedback::find($feedback->id);

            } else {
                $response['result'] = '0';
                $response['is_expired'] = '1';
                $response['message'] = 'Invalid token. Please login again!';

            }
        }
        return Response::json($response);
    }

    public function business_list(Request $request)
    {

        $records = Business::select(['id','name'])->where('status','Active')->orderBy('name', 'ASC')->get();
        $response['result'] = '1';
        $response['message'] = 'success';
        $response['records'] = $records;
        return Response::json($response);

    }

    public function purchase(Request $request){
        $auth = User::where('api_token', $request['api_token'])->first();
        if (!empty($auth)) {
            $plan = Plan::find($request['plan_id']);
            if(!empty($plan)){
                $auth->plan_start = Carbon::now()->format('Y-m-d');
                $auth->plan_end = Carbon::now()->addDays($plan['days'])->format('Y-m-d');
                $auth->save();

                Purchase::create([
                    'user_id' => $auth->id,
                    'plan_id' => $plan['id'],
                    'amount' => $request['amount'],
                    'status' => $request['status'],
                    'payment_data' => $request['payment_data'],
                ]);


                $response['result'] = '1';
                $response['message'] = 'Purchased successfully';

            }else{
                $response['result'] = '0';
                $response['message'] = 'Invalid plan!';
            }

        } else {
            $response['result'] = '0';
            $response['message'] = 'Invalid token. Please login again!';
        }
        return Response::json($response);
    }


}
