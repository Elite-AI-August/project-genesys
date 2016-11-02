<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;

// Get our languages (previously described in this post)
// Get the first segment of our route, which should be our locale..
$locale = Request::segment( 1 );

Route::group( [ 'prefix' => $locale ] , function () {

    Route::resource( 'zizpicorders/coupon' , 'Zizpic\Admin\Http\Controllers\ZizpicCopounCodesController@coupon' );
    Route::resource( 'zizpic/coupon/code' , 'Zizpic\Admin\Http\Controllers\ZizpicCopounCodesController@getCode' );

    Route::get( 'zizpic/changeOrderStatus' , 'Zizpic\Admin\Http\Controllers\ZizpicTransactionController@changeOrderStatus' );
    Route::resource( 'zizpic/transactions' , 'Zizpic\Admin\Http\Controllers\ZizpicCopounCodesController@getTransactionDetails' );
    Route::resource( 'zizpic/zizpicOrder' , 'Zizpic\Admin\Http\Controllers\ZizpicCopounCodesController@getOrderDetails' );
    Route::resource( 'zizpic/success' , 'Zizpic\Admin\Http\Controllers\ZizpicCopounCodesController@getOrderDetails' );
    Route::resource( 'zizpic/getUploadedImage' , 'Zizpic\Admin\Http\Controllers\ZizpicTransactionController@getUploadedImage' );

// Route::get( 'zizpic/zizpictransactions' , 'Zizpic\Admin\Http\Controllers\ZizpicTransactionController@index' );

    Route::bind( 'zizpicorders' , function($value , $route) {
        return Zizpic\Admin\Models\ZizpicOrder::find( $value );
    } );

    Route::resource( 'zizpicorders' , 'Zizpic\Admin\Http\Controllers\ZizpicCopounCodesController' , [
        'names' => [
            'edit'    => 'zizpicorders.edit' ,
            'show'    => 'zizpicorders.show' ,
            'destroy' => 'zizpicorders.destroy' ,
            'update'  => 'zizpicorders.update' ,
            'store'   => 'zizpicorders.store' ,
            'index'   => 'zizpicorders' ,
            'create'  => 'zizpicorders.create' ,
        ]
            ]
    );

    Route::bind( 'zizpictransactions' , function($value , $route) {
        return Zizpic\Admin\Models\ZizpicOrder::find( $value );
    } );

    Route::resource( 'zizpic/zizpictransactions' , 'Zizpic\Admin\Http\Controllers\ZizpicTransactionController' , [
        'names' => [
            'edit'    => 'zizpictransactions.edit' ,
            'show'    => 'zizpictransactions.show' ,
            'destroy' => 'zizpictransactions.destroy' ,
            'update'  => 'zizpictransactions.update' ,
            'store'   => 'zizpictransactions.store' ,
            'index'   => 'zizpictransactions' ,
            'create'  => 'zizpictransactions.create' ,
        ]
            ]
    );
// coupans creaitions

    Route::bind( 'coupons' , function($value , $route) {
        return Zizpic\Admin\Models\Coupon::find( $value );
    } );

    Route::resource( 'zizpic/coupons' , 'Zizpic\Admin\Http\Controllers\CopounsController' , [
        'names' => [
            'edit'    => 'coupons.edit' ,
            'show'    => 'coupons.show' ,
            'destroy' => 'coupons.destroy' ,
            'update'  => 'coupons.update' ,
            'store'   => 'coupons.store' ,
            'index'   => 'coupons' ,
            'create'  => 'coupons.create' ,
        ]
            ]
    );




    Route::get( 'zizpic/payment' , array(
        'as'   => 'payment' ,
        'uses' => 'Zizpic\Admin\Http\Controllers\ZizpicCopounCodesController@postPayment' ,
    ) );

// this is after make the payment, PayPal redirect back to your site
    Route::get( 'payment/status' , array(
        'as'   => 'payment.status' ,
        'uses' => 'Zizpic\Admin\Http\Controllers\ZizpicCopounCodesController@getPaymentStatus' ,
    ) );
} );
