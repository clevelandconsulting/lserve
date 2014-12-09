<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');



Route::get('license/fetch/{key?}', 'LicenseController@fetch');
Route::post('license/register','LicenseController@register');

Route::get('user/create/{email}/{password}', function($email,$password) {
	$db = LaravelFlintstone::load('user');
	$db->set(uniqid(), array('email'=>$email,'password'=>Hash::make($password)));
});



Route::get('/login', array('as' => 'login', 'uses' => 'LoginController@index'));

Route::post('/dologin', function() {
	$email = Input::get('email');
	$password = Input::get('password');
	
	if (Auth::attempt(array('email' => $email, 'password' => $password))) {
    return Redirect::intended('/admin');
 }
 else {
	  return Redirect::route('login')->with('message', 'Login Failed');
 }
 
	
});

Route::group(array('before' => 'auth'), function() 
{
	 Route::get('/test', 'HomeController@index');
	 Route::get('/admin', array("as"=>'admin','uses'=>'AdminController@showAccounts'));
	 
	 Route::get('/account/{id?}','AccountController@index');
	 Route::post('/account', 'AccountController@add');
	 Route::put('/account/{id}', 'AccountController@update');
	 Route::delete('/account/{id}', 'AccountController@remove');
	 
	 Route::get('/account/{accountId}/payment/{id?}','AccountPaymentController@index');
	 Route::post('/account/{accountId}/payment', 'AccountPaymentController@add');
	 Route::put('/payment/{id}', 'AccountPaymentController@update');
	 Route::delete('/payment/{id}', 'AccountPaymentController@remove');
	 
	 Route::get('/user/{id?}','UserController@index');
	 Route::post('/user', 'UserController@add');
	 Route::put('/user/{id}', 'UserController@update');
	 Route::delete('/user/{id}', 'UserController@remove');
	 
	 Route::get('/private/{path}', [ 'as' => 'private-asset', 'uses' => 'AssetController@getPrivateAsset' ])->where('path', '(.*)');
	 
	 Route::get('/logout', function() {
		 Auth::logout();
	 });
});

//Catch-All

Route::get('{slug?}', function() {
	return Response::json(array('error'=>array('message'=>'Path not recognized')),404);
});
