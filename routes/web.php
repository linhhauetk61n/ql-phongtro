<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\User;
use App\Notifi;
use App\District;
use App\Categories;
use App\Motelroom;
use App\Review;
Route::get('/', function () {
	$district = District::all();
    $categories = Categories::all();
    $notification = Notifi::all();
    $hot_motelroom = Motelroom::where('approve',1)->limit(6)->orderBy('count_view','desc')->get();
    $map_motelroom = Motelroom::where('approve',1)->get();
	$listmotelroom = Motelroom::where('approve',1)->orderBy('yeuthich','desc')->paginate(4);
    return view('home.index',[
    	'district'=>$district,
        'categories'=>$categories,
        'notification'=>$notification,
        'hot_motelroom'=>$hot_motelroom,
    	'map_motelroom'=>$map_motelroom,
        'listmotelroom'=>$listmotelroom
    ]);
});
Route::get('category/{id}','MotelController@getMotelByCategoryId');
/* Admin */
Route::get('admin/login','AdminController@getLogin');
Route::post('admin/login','AdminController@postLogin')->name('admin.login');
Route::group(['prefix'=>'admin','middleware'=>'adminmiddleware'], function () {
    Route::get('logout','AdminController@logout');
    Route::get('','AdminController@getIndex');
    Route::get('thongke','AdminController@getThongke');
    Route::get('report','AdminController@getReport');
    Route::group(['prefix'=>'users'],function(){
        Route::get('list','AdminController@getListUser');
        Route::get('edit/{id}','AdminController@getUpdateUser');
        Route::post('edit/{id}','AdminController@postUpdateUser')->name('admin.user.edit');
        Route::get('del/{id}','AdminController@DeleteUser');
    });
    Route::group(['prefix'=>'motelrooms'],function(){
        Route::get('list','AdminController@getListMotel');
        Route::get('approve/{id}','AdminController@ApproveMotelroom');
        Route::get('unapprove/{id}','AdminController@UnApproveMotelroom');
        Route::get('del/{id}','AdminController@DelMotelroom');
        // Route::get('edit/{id}','AdminController@getUpdateUser');
        // Route::post('edit/{id}','AdminController@postUpdateUser')->name('admin.user.edit');
        // Route::get('del/{id}','AdminController@DeleteUser');
    });
     Route::group(['prefix'=>'owners'],function(){
        Route::get('list','AdminController@getListOwners');
        Route::get('right/{id}','AdminController@RightUser');
        Route::get('unright/{id}','AdminController@UnRightUser');
        Route::get('del/{id}','AdminController@DelRightUser');
        // Route::get('edit/{id}','AdminController@getUpdateUser');
        // Route::post('edit/{id}','AdminController@postUpdateUser')->name('admin.user.edit');
        // Route::get('del/{id}','AdminController@DeleteUser');
    });

     Route::group(['prefix'=>'reviews'],function(){
        Route::get('list','AdminController@getListReview');
        Route::get('duyet/{id}','AdminController@duyetReview');
        Route::get('boduyet/{id}','AdminController@boDuyetReview');
        Route::get('del/{id}','AdminController@delReview');
        // Route::get('edit/{id}','AdminController@getUpdateUser');
        // Route::post('edit/{id}','AdminController@postUpdateUser')->name('admin.user.edit');
        // Route::get('del/{id}','AdminController@DeleteUser');
    });
});
/* End Admin */
Route::get('/phongtro/{slug}',function($slug){
    $room = Motelroom::findBySlug($slug);
    $room->count_view = $room->count_view +1;
    $room->save();
    $categories = Categories::all();
    $notification = Notifi::all();
    $review = Review::where([['id_motel',$room->id], ['tinhtrang',0]])->get();
    $count = 0;
    $usercmt = array();
    foreach ($review as $value) {
       $count +=1;
    }
    for ($i=0; $i < $count ; $i++) { 
        $usercmt[$i] = User::find($review[$i]->id_users);
    }

     return view('home.detail',['motelroom'=>$room, 'categories'=>$categories,'notification'=>$notification,'review'=>$review,'usercmt'=>$usercmt]);
});
Route::get('/report/{id}','MotelController@userReport')->name('user.report');
Route::get('/review/{id}','MotelController@userReview')->name('user.review');
Route::get('/motelroom/del/{id}','MotelController@user_del_motel');
/* User */
Route::group(['prefix'=>'user'], function () {
    Route::get('register','UserController@get_register');
    Route::post('register','UserController@post_register')->name('user.register');

    Route::get('register-owner','UserController@get_register_owner');
    Route::post('register-owner','UserController@post_register_owner')->name('user.register-owner');

    Route::get('login','UserController@get_login');
    Route::post('login','UserController@post_login')->name('user.login');
    Route::get('logout','UserController@logout');

    Route::get('dangtin','UserController@get_dangtin')->middleware('dangtinmiddleware');
    Route::post('dangtin','UserController@post_dangtin')->name('user.dangtin')->middleware('dangtinmiddleware');

    Route::get('profile','UserController@getprofile')->middleware('dangtinmiddleware');
    Route::get('profile/edit','UserController@getEditprofile')->middleware('dangtinmiddleware');
    Route::post('profile/edit','UserController@postEditprofile')->name('user.edit')->middleware('dangtinmiddleware');

    Route::get('notifi/{id}','UserController@viewedNotifi');
    Route::get('dsphongtro','UserController@get_dsphongtro');
    Route::get('dsyeuthich','UserController@get_dsyeuthich');

    Route::get('conphong/{id}','UserController@conphong');
    Route::get('dachothue/{id}','UserController@dachothue');

    Route::get('comment','UserController@get_comment');

    Route::get('yeuthich/{id}','UserController@yeuthich');
    Route::get('delyeuthich/{id}','UserController@delyeuthich');

});
/* ----*/

Route::post('searchmotel','MotelController@SearchMotelAjax');
