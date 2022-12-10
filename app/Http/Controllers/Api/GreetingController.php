<?php

namespace App\Http\Controllers\Api;

use App\Model\About;
use App\Model\BusinessImageCategory;
use App\Model\BusinessImage;
use App\Model\BusinessVideo;
use App\Model\Company;
use App\Model\FestivalVideo;
use App\Model\GreetingCategory;
use App\Model\GeneralVideo;
use App\Model\GeneralImage;
use App\Model\GeneralImageCategory;
use App\Model\GeneralVideoCategory;
use App\Model\GreetingImage;
use App\Model\FestivalImage;
use App\Model\Slider;
use App\Model\Video;
use App\Model\VideoCategory;
use App\Model\VideoUpload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\FestivalImageCategory;
use Illuminate\Support\Facades\Response;


class GreetingController extends Controller
{


    //Greeting festival_image_category
    // list all festival_image_category
    public function greeting_category_list(Request $request)
    {

        //$auth = \App\User::where('api_token',$request['api_token'])->first();
        //  if(!empty($auth)){

        $query = GreetingCategory::query();
//        if (!empty($request['language'])) {
//            $query->where('language', $request['language']);
//        }

        if (!empty($request['language']) && $request['language'] == 'Gujarati') {
            $query->where('language', $request['language']);
        }
        if (!empty($request['language']) && $request['language'] == 'Hindi') {
            $query->where('language', $request['language']);
        }
        if (!empty($request['language']) && $request['language'] == 'English') {
            $query->where('language', $request['language']);
        }

        $query->where('status' ,'Active');
        $query->orderBy('id', 'DESC');

        $records = $query->paginate();

        $response['result'] = '1';
        $response['message'] = 'success';
        $response['records'] = $records;

//        }else{
//            $response['result'] = '0';
//            $response['message'] = 'Invalid Token';
//        }
        return Response::json($response);
    }

    // list all festival_image_category images
    public function greeting_images_list(Request $request)
    {

//        $auth = \App\User::where('api_token',$request['api_token'])->first();
//        if(!empty($auth)){


        $query = GreetingImage::query();
        if (!empty($request['language']) && $request['language'] == 'Gujarati') {
            $query->where('language', $request['language']);
        }
        if (!empty($request['language']) && $request['language'] == 'Hindi') {
            $query->where('language', $request['language']);
        }
        if (!empty($request['language']) && $request['language'] == 'English') {
            $query->where('language', $request['language']);
        }

        if (!empty($request['greeting_id'])) {
            $query->where('greeting_id', $request['greeting_id']);
        }

        $query->where('status' ,'Active');
        $query->orderBy('id','DESC');
        $records = $query->paginate();
        $response['result'] = '1';
        $response['message'] = 'success';
        $response['records'] = $records;

//        }else{
//            $response['result'] = '0';
//            $response['message'] = 'Invalid Token';
//        }
        return Response::json($response);
    }

    //General category
    // list all category
    public function general_image_category_list(Request $request)
    {

        $query = GeneralImageCategory::query();

        if (!empty($request['language']) && $request['language'] == 'Gujarati') {
            $query->where('language', $request['language']);
        }
        if (!empty($request['language']) && $request['language'] == 'Hindi') {
            $query->where('language', $request['language']);
        }
        if (!empty($request['language']) && $request['language'] == 'English') {
            $query->where('language', $request['language']);
        }

        $query->where('status' ,'Active');
        $query->orderBy('id', 'DESC');

        $records = $query->paginate();

        $response['result'] = '1';
        $response['message'] = 'success';
        $response['records'] = $records;

        return Response::json($response);
    }

    public function general_video_category_list(Request $request)
    {

       
        $query = GeneralVideoCategory::query();


        if (!empty($request['language']) && $request['language'] == 'Gujarati') {
            $query->where('language', $request['language']);
        }
        if (!empty($request['language']) && $request['language'] == 'Hindi') {
            $query->where('language', $request['language']);
        }
        if (!empty($request['language']) && $request['language'] == 'English') {
            $query->where('language', $request['language']);
        }

        $query->where('status' ,'Active');
        $query->orderBy('id', 'DESC');

        $records = $query->paginate();
        
        foreach ($records as $key => $record) {
            $today = Carbon::now();

            $records[$key]['festival_date'] = !empty($record['festival_date'])?Carbon::parse($record['festival_date'])->format('d-m-Y'):"";
            if (!empty($record['active_from']) && ($today->format('Y-m-d') < Carbon::parse($record['active_from'])->format('Y-m-d'))) {

                $records[$key]['detail_display'] = 'No';
                $records[$key]['detail_message'] = 'This festival available after ' . Carbon::parse($record['active_from'])->format('d-m-Y');

            } else {
                $records[$key]['detail_display'] = 'Yes';
                $records[$key]['detail_message'] = '';

            }
        }

        $response['result'] = '1';
        $response['message'] = 'success';
        $response['records'] = $records;

        return Response::json($response);
    }

    // list all category images
    public function general_images_list(Request $request)
    {

        $query = GeneralImage::query();
        if (!empty($request['language']) && $request['language'] == 'Gujarati') {
            $query->where('language', $request['language']);
        }
        if (!empty($request['language']) && $request['language'] == 'Hindi') {
            $query->where('language', $request['language']);
        }
        if (!empty($request['language']) && $request['language'] == 'English') {
            $query->where('language', $request['language']);
        }

        if (!empty($request['general_image_category_id'])) {
            $query->where('general_image_category_id', $request['general_image_category_id']);
        }

        $query->where('status' ,'Active');
        $query->orderBy('id','DESC');
        $records = $query->paginate();
        $response['result'] = '1';
        $response['message'] = 'success';
        $response['records'] = $records;

        return Response::json($response);
    }


    // list all category videos
    public function general_videos_list(Request $request)
    {


        $query = GeneralVideo::query();
        if (!empty($request['language']) && $request['language'] == 'Gujarati') {
            $query->where('language', $request['language']);
        }
        if (!empty($request['language']) && $request['language'] == 'Hindi') {
            $query->where('language', $request['language']);
        }
        if (!empty($request['language']) && $request['language'] == 'English') {
            $query->where('language', $request['language']);
        }

        if (!empty($request['general_video_category_id'])) {
            $query->where('general_video_category_id', $request['general_video_category_id']);
        }

        $query->where('status' ,'Active');

        $records = $query->paginate();
        $response['result'] = '1';
        $response['message'] = 'success';
        $response['records'] = $records;

        return Response::json($response);
    }



}
