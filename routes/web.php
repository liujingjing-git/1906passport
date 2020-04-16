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

Route::get('/', function () {
    return view('welcome');
});

Route::get('github','GithubController@index'); //github视图
Route::get('github/callback','GithubController@callback'); //github回调
Route::get('github/center','GithubController@center');  //个人中心

Route::get('reg','LoginController@reg'); //注册视图
Route::post('regdo','LoginController@regdo'); //执行注册
Route::get('login','LoginController@login'); //登陆视图
Route::post('logindo','LoginController@logindo'); //执行登录



//处理API登录
Route::prefix('/api')->group(function(){
    Route::post('/login','LoginController@apiLogin'); 
    Route::post('/reg','LoginController@apiReg'); 
});