<?php

namespace App\Http\Controllers\Api;

use App\Model\About;
use App\Model\BusinessImageCategory;
use App\Model\BusinessImage;
use App\Model\BusinessVideo;
use App\Model\BusinessVideoCategory;

use App\Model\DharmaImageCategory;
use App\Model\DharmaImage;
use App\Model\DharmaVideo;
use App\Model\DharmaVideoCategory;
use App\Model\Company;
use App\Model\FestivalVideo;
use App\Model\FestivalImage;
use App\Model\FestivalVideoCategory;
use App\Model\Slider;
use App\Model\Video;
use App\Model\VideoCategory;
use App\Model\VideoUpload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\FestivalImageCategory;
use Illuminate\Support\Facades\Response;
use Validator;


class CategoryController extends Controller
{
    //add Images festival_image_category data
   /* public function category_add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:1024',
            'language' => 'required',
        ]);
        if ($validator->fails()) {
            $response['result'] = '0';
            $response['message'] = $errors = $validator->errors()->first();
            $response['errors'] = $errors = $validator->errors();
        } else {
            $auth = \App\User::where('api_token', $request['api_token'])->first();
            if (!empty($auth)) {
                $category = FestivalImageCategory::create([
                    'status' => 'Active',
                    'image' => $this->uploadFile($request, null, 'image', 'festival_image_category'),
                    'name' => $request['name'],
                    'language' => $request['language']

                ]);
                $response['result'] = '1';
                $response['message'] = 'FestivalImageCategory Added successfully';
                $response['record'] = FestivalImageCategory::find($category->id);

            } else {
                $response['result'] = '0';
                $response['message'] = 'Invalid token. Please login again!';
            }
        }
        return Response::json($response);
    }*/


    // list all festival_image_category
    public function festival_image_category_list(Request $request)
    {

        //$auth = \App\User::where('api_token',$request['api_token'])->first();
        //  if(!empty($auth)){


        $query = FestivalImageCategory::query();
//        if (!empty($request['language'])) {
//            $query->where('language', $request['language']);
//        }
        $query->where("status", "Active");
        $query->where("festival_date", ">=",Carbon::now()->format('Y-m-d'));
        // $query->where("active_from", "<=",Carbon::now()->format('Y-m-d'));

        $query->orderBy('festival_date', 'ASC');

        $records = $query->paginate(20);

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
//            $records[$key]['created_at'] = $record['created_at']->format('d-m-Y');
        }

        $previous_query = FestivalImageCategory::query();
        $previous_query->where("status", "Active");
        $previous_query->where("festival_date", "<",Carbon::now()->format('Y-m-d'));
        $previous_query->orderBy('festival_date', 'DESC');

        $previous_records = $previous_query->paginate();
        $previous_records->appends($request->all());

        foreach ($previous_records as $key => $previous_record) {
            $previous_records[$key]['detail_display'] = 'Yes';
            $previous_records[$key]['detail_message'] = '';
        }


        $response['result'] = '1';
        $response['message'] = 'success';
        $response['records'] = $records;
        $response['previous_records'] = $previous_records;


//        }else{
//            $response['result'] = '0';
//            $response['message'] = 'Invalid Token';
//        }
        return Response::json($response);
    }

    // delete festival_image_category
/*    public function category_delete(Request $request)
    {

        $auth = \App\User::where('api_token', $request['api_token'])->first();
        if (!empty($auth)) {
            $record = FestivalImageCategory::findOrFail($request['id']);
            $this->deleteFile($record, 'image', pathinfo('festival_image_category'));
            $record->delete();
            $response['result'] = '1';
            $response['message'] = 'Delete FestivalImageCategory successfully';

        } else {
            $response['result'] = '0';
            $response['message'] = 'Invalid token. Please login again!';
        }
        return Response::json($response);
    }*/

    //festival_image_category images upload
/*    public function category_images_add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:1024',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            $response['result'] = '0';
            $response['message'] = $errors = $validator->errors()->first();
            $response['errors'] = $errors = $validator->errors();
        } else {
            $auth = \App\User::where('api_token', $request['api_token'])->first();
            if (!empty($auth)) {
                $category_image = FestivalImage::create([
                    'status' => 'Active',
                    'image' => $this->uploadFile($request, null, 'image', 'category_image'),
                    'title' => $request['title'],
                    'description' => $request['description'],
                    'category_id' => $request['category_id']

                ]);
                $response['result'] = '1';
                $response['message'] = 'FestivalImageCategory image Added successfully';
                $response['record'] = FestivalImage::find($category_image->id);

            } else {
                $response['result'] = '0';
                $response['message'] = 'Invalid token. Please login again!';
            }
        }
        return Response::json($response);
    }*/

    //festival_image_category images delete
    /*public function category_images_delete(Request $request)
    {

        $auth = \App\User::where('api_token', $request['api_token'])->first();
        if (!empty($auth)) {
            $record = FestivalImage::findOrFail($request['id']);
            $this->deleteFile($record, 'image', pathinfo('festival_image_category'));
            $record->delete();
            $response['result'] = '1';
            $response['message'] = 'Delete FestivalImageCategory image successfully';

        } else {
            $response['result'] = '0';
            $response['message'] = 'Invalid token. Please login again!';
        }
        return Response::json($response);
    }*/

    //about us description add
    public function about(Request $request)
    {

        $auth = \App\User::where('api_token', $request['api_token'])->first();
        if (!empty($auth)) {
            $record = About::create([
                'description' => $request['description']

            ]);
            $response['result'] = '1';
            $response['message'] = 'About description Added successfully';
            $response['record'] = About::find($record->id);

        } else {
            $response['result'] = '0';
            $response['message'] = 'Invalid token. Please login again!';
        }
        return Response::json($response);
    }

    // list all festival_image_category images
    public function festival_images_list(Request $request)
    {

//        $auth = \App\User::where('api_token',$request['api_token'])->first();
//        if(!empty($auth)){

        $query = FestivalImage::query();
        if (!empty($request['language']) && $request['language'] == 'Gujarati') {
            $query->where('language', $request['language']);
        }
        if (!empty($request['language']) && $request['language'] == 'Hindi') {
            $query->where('language', $request['language']);
        }
        if (!empty($request['language']) && $request['language'] == 'English') {
            $query->where('language', $request['language']);
        }

        if (!empty($request['festival_image_category_id'])) {
            $query->where('festival_image_category_id', $request['festival_image_category_id']);
        }

        $query->where("status", "Active");
        $query->orderBy('id', 'DESC');

        $records = $query->paginate();
        $records->appends($request->all());

        $response['result'] = '1';
        $response['message'] = 'success';
        $response['records'] = $records;

//        }else{
//            $response['result'] = '0';
//            $response['message'] = 'Invalid Token';
//        }
        return Response::json($response);
    }

    //Company detail add
    public function company_detail_add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:1024',
            'email' => 'required',
            'contact' => 'required',
        ]);
        if ($validator->fails()) {
            $response['result'] = '0';
            $response['message'] = $errors = $validator->errors()->first();
            $response['errors'] = $errors = $validator->errors();
        } else {
            $auth = \App\User::where('api_token', $request['api_token'])->first();
            if (!empty($auth)) {
                // check it's user company or not ?
                if (!empty($request['company_id'])) {
                    $company_check = Company::find($request['company_id']);
                    if (!empty($company_check) && $company_check['user_id'] != $auth['id']) {
                        $response['result'] = '0';
                        $response['message'] = 'unauthorized access';
                        return Response::json($response);
                    }
                }

                $company_add = Company::where('user_id', $auth->id)->first();
                if (!empty($company_add) && empty($request['company_id'])) {
                    $response['result'] = '0';
                    $response['message'] = 'Company Already added';
                } else {
                    $company = Company::updateOrCreate(['id' => $request['company_id']], [
                        'name' => $request['name'],
                        'logo' => $this->uploadFile($request, null, 'logo', 'company'),
                        'email' => $request['email'],
                        'address' => $request['address'],
                        'user_id' => $auth['id'],
                        'contact' => $request['contact'],
                        'website' => $request['website']
                    ]);
                    $response['result'] = '1';
                    $response['message'] = 'success';
                    $response['record'] = Company::find($company->id);
                }

//            if(empty($company_add) && empty($company_add['company_id'])){
//
//
//            }else{
//                $response['result'] = '0';
//                $response['message'] = 'Company Already added';
//            }

            } else {
                $response['result'] = '0';
                $response['message'] = 'Invalid token. Please login again!';
            }
        }
        return Response::json($response);
    }

    // festival_image_category video upload api

    //festival_image_category images upload
/*    public function category_video_add(Request $request)
    {

        $auth = \App\User::where('api_token', $request['api_token'])->first();
        if (!empty($auth)) {
            $category_image = VideoUpload::create([
                'status' => 'Active',
                'video' => $this->uploadFile($request, null, 'video', 'video_category'),
                'title' => $request['title'],
                'description' => $request['description'],
                'video_category_id' => $request['video_category_id']

            ]);
            $response['result'] = '1';
            $response['message'] = 'FestivalImageCategory video Added successfully';
            $response['record'] = VideoUpload::find($category_image->id);

        } else {
            $response['result'] = '0';
            $response['message'] = 'Invalid token. Please login again!';
        }
        return Response::json($response);
    }*/

    public function category_video_list(Request $request)
    {

//        $auth = \App\User::where('api_token',$request['api_token'])->first();
//        if(!empty($auth)){

        $query = VideoUpload::query();
        if (!empty($request['language']) && $request['language'] == 'Gujarati') {
            $query->where('language', $request['language']);
        }
        if (!empty($request['language']) && $request['language'] == 'Hindi') {
            $query->where('language', $request['language']);
        }
        if (!empty($request['language']) && $request['language'] == 'English') {
            $query->where('language', $request['language']);
        }

        if (!empty($request['category_id'])) {
            $query->where('category_id', $request['category_id']);
        }

        $query->where("status", "Active");
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

/*    public function video_category_add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:1024',
            'language' => 'required',
        ]);
        if ($validator->fails()) {
            $response['result'] = '0';
            $response['message'] = $errors = $validator->errors()->first();
            $response['errors'] = $errors = $validator->errors();
        } else {
            $auth = \App\User::where('api_token', $request['api_token'])->first();
            if (!empty($auth)) {
                $category = VideoCategory::create([
                    'status' => 'Active',
                    'image' => $this->uploadFile($request, null, 'video', 'video_category'),
                    'name' => $request['name'],
                    'language' => $request['language']

                ]);
                $response['result'] = '1';
                $response['message'] = 'VideoCategory Added successfully';
                $response['record'] = VideoCategory::find($category->id);

            } else {
                $response['result'] = '0';
                $response['message'] = 'Invalid token. Please login again!';
            }
        }
        return Response::json($response);
    }*/

    public function video_category_list(Request $request)
    {

//        $auth = \App\User::where('api_token',$request['api_token'])->first();
//        if(!empty($auth)){

        $query = VideoCategory::query();
        if (!empty($request['language'])) {
            $query->where('language', $request['language']);
        }
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

    //slider add ,list api

/*    public function slider_add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:1024',

        ]);
        if ($validator->fails()) {
            $response['result'] = '0';
            $response['message'] = $errors = $validator->errors()->first();
            $response['errors'] = $errors = $validator->errors();
        } else {
            $auth = \App\User::where('api_token', $request['api_token'])->first();
            if (!empty($auth)) {
                $records = Slider::create([
                    'status' => 'Active',
                    'image' => $this->uploadFile($request, null, 'slider', 'slider_image'),
                    'name' => $request['name']


                ]);
                $response['result'] = '1';
                $response['message'] = 'Slider Added successfully';
                $response['record'] = Slider::find($records->id);

            } else {
                $response['result'] = '0';
                $response['message'] = 'Invalid token. Please login again!';
            }
        }
        return Response::json($response);
    }*/

    public function slider_list(Request $request)
    {

//        $auth = \App\User::where('api_token',$request['api_token'])->first();
//        if(!empty($auth)){

        $query = Slider::query();
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


    //Business festival_image_category
    // list all festival_image_category
    public function business_image_category_list(Request $request)
    {

        //$auth = \App\User::where('api_token',$request['api_token'])->first();
        //  if(!empty($auth)){

        $query = BusinessImageCategory::query();
//        if (!empty($request['language'])) {
//            $query->where('language', $request['language']);
//        }
//
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
        $query->orderBy('name', 'ASC');

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
    public function business_images_list(Request $request)
    {

//        $auth = \App\User::where('api_token',$request['api_token'])->first();
//        if(!empty($auth)){


        $query = BusinessImage::query();
        if (!empty($request['language']) && $request['language'] == 'Gujarati') {
            $query->where('language', $request['language']);
        }
        if (!empty($request['language']) && $request['language'] == 'Hindi') {
            $query->where('language', $request['language']);
        }
        if (!empty($request['language']) && $request['language'] == 'English') {
            $query->where('language', $request['language']);
        }

        if (!empty($request['business_image_category_id'])) {
            $query->where('business_image_category_id', $request['business_image_category_id']);
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
    
    
    
    
    // Dharma Image Category
    public function dharma_image_category_list(Request $reques){


        $query = DharmaImageCategory::query();

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
        $query->orderBy('name', 'ASC');

        $records = $query->paginate();

        $response['result'] = '1';
        $response['message'] = 'success';
        $response['records'] = $records;

        return Response::json($response);
    }

    // list all Dharma Image List
    public function dharma_images_list(Request $request)
    {

        $query = DharmaImage::query();
        if (!empty($request['language']) && $request['language'] == 'Gujarati') {
            $query->where('language', $request['language']);
        }
        if (!empty($request['language']) && $request['language'] == 'Hindi') {
            $query->where('language', $request['language']);
        }
        if (!empty($request['language']) && $request['language'] == 'English') {
            $query->where('language', $request['language']);
        }

        if (!empty($request['dharma_image_category_id'])) {
            $query->where('dharma_image_category_id', $request['dharma_image_category_id']);
        }

        $query->where('status' ,'Active');
        $query->orderBy('id','DESC');
        $records = $query->paginate();
        $response['result'] = '1';
        $response['message'] = 'success';
        $response['records'] = $records;

        return Response::json($response);
    }



    // list all festival_video_category

    public function festival_video_category_list(Request $request)
    {

        //$auth = \App\User::where('api_token',$request['api_token'])->first();
        //  if(!empty($auth)){


        $query = FestivalVideoCategory::query();
//        if (!empty($request['language'])) {
//            $query->where('language', $request['language']);
//        }
        $query->where("status", "Active");
        $query->where("festival_date", ">=",Carbon::now()->format('Y-m-d'));
        // $query->where("active_from", "<=",Carbon::now()->format('Y-m-d'));

        $query->orderBy('festival_date', 'ASC');

        $records = $query->paginate(20);

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
//            $records[$key]['created_at'] = $record['created_at']->format('d-m-Y');
        }

        $previous_query = FestivalVideoCategory::query();
        $previous_query->where("status", "Active");
        $previous_query->where("festival_date", "<",Carbon::now()->format('Y-m-d'));
        $previous_query->orderBy('festival_date', 'DESC');

        $previous_records = $previous_query->paginate();
        $previous_records->appends($request->all());



        $response['result'] = '1';
        $response['message'] = 'success';
        $response['records'] = $records;
        $response['previous_records'] = $previous_records;


//        }else{
//            $response['result'] = '0';
//            $response['message'] = 'Invalid Token';
//        }
        return Response::json($response);
    }


    public function festival_video_list(Request $request)
    {

//        $auth = \App\User::where('api_token',$request['api_token'])->first();
//        if(!empty($auth)){

        $query = FestivalVideo::query();
//        if (!empty($request['language']) && $request['language'] != 'All') {
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


        if (!empty($request['festival_video_category_id'])) {
            $query->where('festival_video_category_id', $request['festival_video_category_id']);
        }
        $query->where('status' ,'Active');
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


    // list all Business_video_category

    public function business_video_category_list(Request $request)
    {

        //$auth = \App\User::where('api_token',$request['api_token'])->first();
        //  if(!empty($auth)){


        $query = BusinessVideoCategory::query();
//        if (!empty($request['language'])) {
//            $query->where('language', $request['language']);
//        }
        $query->where("status", "Active");
    //    $query->where("festival_date", ">=",Carbon::now()->format('Y-m-d'));
        // $query->where("active_from", "<=",Carbon::now()->format('Y-m-d'));

      //  $query->orderBy('festival_date', 'ASC');

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


    public function business_video_list(Request $request)
    {

//        $auth = \App\User::where('api_token',$request['api_token'])->first();
//        if(!empty($auth)){

        $query = BusinessVideo::query();
//        if (!empty($request['language']) && $request['language'] != 'All') {
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


        if (!empty($request['business_video_category_id'])) {
            $query->where('business_video_category_id', $request['business_video_category_id']);
        }

        $query->where('status' ,'Active');
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
    
    
    // Dharma Video Category List
     public function dharma_video_category_list(Request $request)
    {
        $query = DharmaVideoCategory::query();
        $query->where("status", "Active");

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
    
    
    //Dharma Video List
    public function dharma_video_list(Request $request)
    {

        $query = DharmaVideo::query();

        if (!empty($request['language']) && $request['language'] == 'Gujarati') {
            $query->where('language', $request['language']);
        }
        if (!empty($request['language']) && $request['language'] == 'Hindi') {
            $query->where('language', $request['language']);
        }
        if (!empty($request['language']) && $request['language'] == 'English') {
            $query->where('language', $request['language']);
        }


        if (!empty($request['dharm_video_category_id'])) {
            $query->where('dharma_video_category_id', $request['dharma_video_category_id']);
        }

        $query->where('status' ,'Active');
        $records = $query->paginate();

        $response['result'] = '1';
        $response['message'] = 'success';
        $response['records'] = $records;

        return Response::json($response);
    }



}
