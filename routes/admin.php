<?php
use Illuminate\Support\Facades\Route;

//Route::get('/home', function () {
//    $users[] = Auth::user();
//    $users[] = Auth::guard()->user();
//    $users[] = Auth::guard('admin')->user();
//
//    //dd($users);
//
//    return view('admin.home');
//})->name('home');
//

Route::get('home','Admin\HomeController@home');
Route::resource('user','Admin\UserController');

Route::resource('festival-category','Admin\FestivalCategoryController');
Route::resource('festival-sub-category','Admin\FestivalSubCategoryController');
Route::resource('festival-peta-category','Admin\FestivalPetaCategoryController');
Route::resource('festival-post','Admin\FestivalPostController');




Route::resource('festival_video_category','Admin\FestivalVideoCategoryController');
Route::resource('festival_video','Admin\FestivalVideoController');







Route::resource('business','Admin\BusinessController');
Route::resource('business-category','Admin\BusinessCategoryController');
Route::resource('business-post','Admin\BusinessPostController');
Route::resource('business-sub-category','Admin\BusinessSubCategoryController');
Route::resource('business_video','Admin\BusinessVideoController');




Route::resource('dharma','Admin\DharmaController');
Route::resource('dharma_image_category','Admin\DharmaImageCategoryController');
Route::resource('dharma_image','Admin\DharmaImageController');
Route::resource('dharma_video_category','Admin\DharmaVideoCategoryController');
Route::resource('dharma_video','Admin\DharmaVideoController');




Route::resource('apps','Admin\AppController');


Route::resource('greeting_category','Admin\GreetingCategoryController');
Route::resource('greeting_image','Admin\GreetingImageController');

Route::resource('general_image_category','Admin\GeneralImageCategoryController');
Route::resource('general_image','Admin\GeneralImageController');
Route::resource('general_video_category','Admin\GeneralVideoCategoryController');
Route::resource('general_video','Admin\GeneralVideoController');


Route::resource('video_upload','Admin\VideoUploadController');
Route::resource('video_category','Admin\VideoCategoryController');

Route::resource('banner_upload','Admin\BannerUploadController');
Route::resource('slider','Admin\SliderUploadController');
Route::resource('feedback','Admin\FeedbackController');
Route::resource('pages','Admin\PagesController');
Route::resource('contactus','Admin\ContactUsController');
Route::resource('plan','Admin\PlanController');


Route::get('profile','Admin\HomeController@profile')->name('profile');
Route::post('profile_post','Admin\HomeController@profile_post')->name('profile_post');
Route::patch('user_update_company','Admin\UserController@user_update_company')->name('user_update_company');
Route::post('add_custom_frame','Admin\UserController@add_custom_frame')->name('add_custom_frame');
Route::get('delete_custom_frame/{id}','Admin\UserController@delete_custom_frame')->name('delete_custom_frame');





