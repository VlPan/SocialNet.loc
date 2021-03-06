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

Route::group(['middleware' => ['web']], function () {

    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    Route::post('/signup', [
        'uses' => 'UserController@postSignUp',
        'as' => 'signup'
    ]);

    Route::post('/signin', [
        'uses' => 'UserController@postSignIn',
        'as' => 'signIn'
    ]);

    Route::get('/dashboard', [
        'uses' => 'PostController@getDashboard',
        'as' => 'dashboard',
        'middleware' => 'auth' //Only accessable when we logged in!!!
    ]);

    Route::post('/createpost', [
        'uses' => 'PostController@postCreatePost',
        'as' => 'post.create',
        'middleware' => 'auth'
    ]);

    Route::get('/logout', [
        'uses' => 'UserController@getLogout',
        'as' => 'logout'
    ]);

    Route::get('/deletepost/{post_id}', [
        'uses' => 'PostController@getDeletePost',
        'as' => 'post.delete',
        'middleware' => 'auth'  //Only accessable when we logged in!!!
    ]);

    Route::post('/edit', [
        'uses' => 'PostController@postEditPost',
        'as' => 'edit'
    ]);

    Route::get('/account', [
        'uses' => 'UserController@getAccount',
        'as' => 'account'
    ]);

    Route::post('/updateaccount', [
        'uses' => 'UserController@postSaveAccount',
        'as' => 'account.save'
    ]);

    Route::get('/userimage/{filename}', [
        'uses' => 'UserController@getUserImage',
        'as' => 'account.image'
    ]);


    Route::post('/like', [
        'uses' => 'PostController@postLikePost',
        'as' => 'like'
    ]);

    Route::get('/mypage/{id}', [
        'uses' => 'UserController@getPage',
        'as' => 'page',
        'middleware' => 'auth'  //Only accessable when we logged in!!!
    ]);

    Route::get('/add_friend/{id}', [
        'uses' => 'UserController@addFriend',
        'as' => 'add.friend',
        'middleware' => 'auth'  //Only accessable when we logged in!!!
    ]);

    Route::get('/make_message/{id}', [
        'uses' => 'MessageController@makeMessage',
        'as' => 'make.message',
        'middleware' => 'auth'  //Only accessable when we logged in!!!
    ]);

    Route::post('/get_message/{id}', [
        'uses' => 'MessageController@getMessage',
        'as' => 'get.message',
        'middleware' => 'auth'  //Only accessable when we logged in!!!
    ]);

    Route::get('/get_panel_message', [
        'uses' => 'MessageController@getPanel',
        'as' => 'get.panel',
        'middleware' => 'auth'  //Only accessable when we logged in!!!
    ]);

    Route::get('/deltemessage/{id}', [
        'uses' => 'MessageController@deleteMessage',
        'as' => 'delete.message',
        'middleware' => 'auth'  //Only accessable when we logged in!!!
    ]);



});


