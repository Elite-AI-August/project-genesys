<?php

use Sessions;
/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

$locale = Request::segment( 1 );


Route::group( array( 'prefix' => $locale ) , function() {

    Route::get( 'logout' , function() {
        Auth::logout();
        return Redirect::to( '/login' );
    } );
    Route::get( '/' , 'Auth\AuthController@getZizpicOrder' );

    Route::get( '/login' , 'Auth\AuthController@getLogin' );


    Route::post( '/login' , function() {
        $credentials = array( 'email' => Input::get( 'email' ) , 'password' => Input::get( 'password' ) );

        if ( Auth::attempt( $credentials , true ) ) {

            return Redirect::to( 'dashboard' );
        }

        return Redirect::to( '/login' )->with( 'flash_alert_notice' , 'Wrong Email or Password. Try again !' );
    } );

    Route::controllers( [
        'auth'     => 'Auth\AuthController' ,
        'password' => 'Auth\PasswordController' ,
    ] );
    //  Route::get( 'home' , 'Auth\AuthController@getZizpicOrder' );
} );


Route::group( ['prefix' => $locale ] , function () {


    Route::get( 'admin' , 'Auth\AuthController@getLogin' );
    Route::get( 'dashboard' , ['as' => 'admin.dashboard' , 'uses' => 'AdminController@dashboard' ] );

    Route::bind( 'customFields' , function($value , $route) {
        return App\Customfields::find( $value );
    } );

    Route::resource( 'customFields' , 'CustomFieldsController' , [
        'names' => [
            'edit'    => 'customFields.edit' ,
            'show'    => 'customFields.show' ,
            'destroy' => 'customFields.destroy' ,
            'update'  => 'customFields.update' ,
            'store'   => 'customFields.store' ,
            'index'   => 'customFields' ,
            'create'  => 'customFields.create' ,
        ]
            ]
    );


    Route::bind( 'users' , function($value , $route) {
        return App\User::find( $value );
    } );

    Route::resource( 'users' , 'UserController' , [
        'names' => [
            'edit'    => 'users.edit' ,
            'show'    => 'users.show' ,
            'destroy' => 'users.destroy' ,
            'update'  => 'users.update' ,
            'store'   => 'users.store' ,
            'index'   => 'users' ,
            'create'  => 'users.create' ,
        ]
    ] );

    /*
     * roles Route
     * */

    Route::bind( 'roles' , function($value , $route) {
        return Caffeinated\Shinobi\Models\Role::find( $value );
    } );

    Route::resource( 'roles' , 'RoleController' , [
        'names' => [
            'edit'    => 'roles.edit' ,
            'show'    => 'roles.show' ,
            'destroy' => 'roles.destroy' ,
            'update'  => 'roles.update' ,
            'store'   => 'roles.store' ,
            'index'   => 'roles' ,
            'create'  => 'roles.create' ,
        ]
            ]
    );
} );
