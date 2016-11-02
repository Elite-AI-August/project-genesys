<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\AppSettings;
use Illuminate\Support\Facades\Request;
use Sessions;
use Config;
use Zizpic\Admin\Models\ZizpicOrder;

class AuthController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Registration & Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users, as well as the
      | authentication of existing users. By default, this controller uses
      | a simple trait to add these behaviors. Why don't you explore it?
      |
     */

use AuthenticatesAndRegistersUsers;

    protected $redirectAfterLogout = 'auth/login';

    /**
     * Create a new authentication controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard  $auth
     * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
     * @return void
     */
    public function __construct( Guard $auth , Registrar $registrar ) {
        parent::__construct();
        $this->auth = $auth;
        $this->registrar = $registrar;
        $this->middleware( 'guest' , ['except' => 'getLogout' ] );
    }

    public function getLogin() {

        $locale = Request::segment( 1 );
        return view( 'auth.login' , compact( 'locale' ) );
    }

    public function getZizpicOrder() {

        $zizpicOrder = new ZizpicOrder;
        $locale = Request::segment( 1 );
        $page_title = 'Create Zizpic';
        $prices = [
            'en' => [
                'package_1' => 22.00 ,
                'package_3' => 45.00 ,
                'shippment' => 5.00 ,
                'currency'  => 'USD' ] ,
            'he' => [
                'package_1' => 85.00 ,
                'package_3' => 180.00 ,
                'shippment' => 5.00 ,
                'currency'  => 'ILS' ] ,
        ];

        $prices_details = $prices[ $locale ];
        $zizpic_price[ 'zizpic_order_1' ] = Config::get( 'app.zizpic_order_1' );
        $zizpic_price[ 'zizpic_order_3' ] = Config::get( 'app.zizpic_order_3' );
        $zizpic_price[ 'zizpic_delivery' ] = Config::get( 'app.zizpic_delivery' );
        $zizpic_price[ 'total_amount' ] = Config::get( 'app.zizpic_order_1' ) - Config::get( 'app.zizpic_delivery' );

        return view( 'packages::zizpic.create' , compact( 'zizpicOrder' , 'page_title' , 'zizpic_price' , 'package' , 'prices_details' ) );
    }

}
