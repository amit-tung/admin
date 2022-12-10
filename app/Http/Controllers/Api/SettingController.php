<?php

namespace App\Http\Controllers\Api;

use App\Model\About;
use App\Model\BusinessImageCategory;
use App\Model\BusinessImage;
use App\Model\BusinessVideo;
use App\Model\Company;
use App\Model\ContactUs;
use App\Model\FestivalVideo;
use App\Model\GreetingCategory;
use App\Model\GreetingImage;
use App\Model\FestivalImage;
use App\Model\Plan;
use App\Model\Purchase;
use App\Model\Slider;
use App\Model\Video;
use App\Model\VideoCategory;
use App\Model\VideoUpload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\FestivalImageCategory;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Validator;


class SettingController extends Controller
{


    //ContactUs detail add
    public function contactus_add(Request $request)
    {
//        $validator = Validator::make($request->all(), [
//            'email' => 'required',
//            'contact' => 'required',
//        ]);
//        if ($validator->fails()) {
//            $response['result'] = '0';
//            $response['message'] = $errors = $validator->errors()->first();
//            $response['errors'] = $errors = $validator->errors();
//        } else {
            $auth = \App\User::where('api_token', $request['api_token'])->first();
            if (!empty($auth)) {
                $record = ContactUs::create([
                    'contact' => $request['description'],
                    'email' => $request['email'],
                    'website' => $request['website']

                ]);
                $response['result'] = '1';
                $response['message'] = 'Added successfully';
                $response['record'] = About::find($record->id);

            } else {
                $response['result'] = '0';
                $response['message'] = 'Invalid Token';
            }
     //   }
        return Response::json($response);
    }

    public function plan(Request $request)
    {
        $auth = \App\User::where('api_token', $request['api_token'])->first();
       // if (!empty($auth)) {
            $query = Plan::query();
//            if (!empty($request['search'])) {
//                $query->where('name', 'LIKE', '%' . $request['search'] . '%');
//            }
            $records = $query->paginate();

            $response['result'] = '1';
            $response['message'] = 'success';
            $response['records'] = $records;

      //  } else {
//            $response['result'] = '0';
//            $response['message'] = 'Error';
     //   }
        return Response::json($response);
    }

    public function contactus(Request $request)
    {
       // $auth = \App\User::where('api_token', $request['api_token'])->first();
      //  if (!empty($auth)) {
            $query = ContactUs::query();
//            if (!empty($request['search'])) {
//                $query->where('name', 'LIKE', '%' . $request['search'] . '%');
//            }
            $records = $query->paginate();

            $response['result'] = '1';
            $response['message'] = 'success';
            $response['records'] = $records;

       // } else {
//            $response['result'] = '0';
//            $response['message'] = 'Error';
      //  }
        return Response::json($response);

    }

    public function planList(Request $request){
      $auth = \App\User::where('api_token', $request['api_token'])->first();
      if (!empty($auth)) {
          $planPurchase = Purchase::where('user_id',$auth['id'])->orderBy('created_at','desc')->first();
         
            $records = Plan::all();
            $data = [];
            foreach($records as $record){
                $record['is_active'] = 0;
                if($planPurchase['plan_id'] == $record['id']){
                    $record['start_date'] = $auth['plan_start'];
                    $record['end_date'] = $auth['plan_end'];
                    $record['is_active'] = 1;
                }
                $data[] = $record;
            }
            
            $response['result'] = '1';
            $response['message'] = 'success';
            $response['records'] = $data;
        } else {
            $response['result'] = '0';
            $response['message'] = 'Invalid Token';
        }
        return Response::json($response);
    }
    
    public function planSubscribe(Request $request){
        $auth = \App\User::where('api_token', $request['api_token'])->first();
         if (!empty($auth)) {
            $record = Purchase ::create([
                'user_id' => $auth['id'],
                'plan_id' => $request['plan_id'],
                'company_id' => $request['company_id'] != '' ? $request['company_id'] : Null ,
                'amount' => $request['amount'],
                'status' => $request['status'],
                'payment_data' => serialize($request['payment_data'])
            ]);
           
            $getPlanDetails = Plan::find($request['plan_id']);
            $currentDate = date('Y-m-d');
            $endDate = date('Y-m-d', strtotime($currentDate. ' + '.$getPlanDetails->days.' days'));
            // $user = \App\User::find($request['user_id']);
        
            $auth->plan_start = $currentDate;
            $auth->plan_end = $endDate;
            $auth->save();
            
            $response['result'] = '1';
            $response['message'] = 'Added successfully';
            $response['record'] = Purchase::find($record->id);
        } else {
            $response['result'] = '0';
            $response['message'] = 'Invalid Token';
        }
        return Response::json($response);
    }


}
