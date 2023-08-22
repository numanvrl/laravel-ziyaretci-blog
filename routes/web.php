<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

//BACKEND
Route::namespace('App\Http\Controllers\Backend')->group(function() {
    Route::prefix('nedmin')->group(function(){

        Route::get('/dashboard', 'DefaultController@index')->name('nedmin.index')->middleware('admin');
        Route::get('/', 'DefaultController@login')->name('nedmin.Login')->middleware('CheckLogin');
        Route::post('/login', 'DefaultController@authenticate')->name('nedmin.Authenticate');
        Route::get('/logout', 'DefaultController@logout')->name('nedmin.Logout');

        //BLOG
        Route::resource('blog', 'BlogController')->middleware(['CheckPermission','admin']);

        //USER
        Route::resource('user', 'UserController')->middleware(['CheckPermission','admin']);

        //COMMENT
        Route::resource('comment', 'CommentController')->middleware(['CheckPermission','admin']);

        //RATE
        Route::resource('rate', 'RatingController')->middleware(['CheckPermission','admin']);

    Route::middleware(['admin'])->group(function(){
    //BLOG
    Route::post('/blog/sortable','BlogController@sortable')->name('blog.Sortable');
    Route::post('/blog/updateStatus/{id}','BlogController@updateStatus')->name('blog.updateStatus');

    //USER
    Route::post('/user/updateStatus/{id}','UserController@updateStatus')->name('user.updateStatus');

    //COMMENT
    Route::post('/comment/sortable','CommentController@sortable')->name('comment.Sortable');
    Route::post('/comment/updateStatus/{id}','CommentController@updateStatus')->name('comment.updateStatus');

    //RATE
    Route::post('/rate/updateStatus/{id}','RatingController@updateStatus')->name('rate.updateStatus');

        });
    });
});

//FRONTEND
Route::namespace('App\Http\Controllers\Frontend')->group(function() {

    Route::get('/', 'DefaultController@index')->name('default.index');
    Route::get('/login', 'DefaultController@login')->name('default.Login')->middleware('CheckLoginFrontend');
    Route::post('/auth', 'DefaultController@authenticate')->name('default.Authenticate');
    Route::get('/logout', 'DefaultController@logout')->name('default.Logout');

    Route::get('/register', 'RegisterController@index')->name('default.Register')->middleware('CheckLoginFrontend');
    Route::post('/register/create', 'RegisterController@register')->name('register.Create')->middleware('CheckLoginFrontend');


    //BLOG
    Route::resource('blogf', 'BlogController')->middleware('CheckPermissionFrontend');
    Route::get('/{slug}','BlogController@detail')->name('blog.Detail');

    //COMMENT
    Route::resource('commentf', 'CommentController');

    //RATE
     Route::resource('ratef','RatingController');

});

// Auth::routes();

