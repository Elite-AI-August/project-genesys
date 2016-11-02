<?php

namespace App\Http\Middleware;

use Closure;
use Route;
use Config;
use Auth;
use Response;

class VerifyPermission {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle( $request , Closure $next ) {
        if ( !\Auth::check() ):
            return $next( $request );

        endif;
        if ( Auth::user()->id != 1 ):
            $permissions = Config::get( 'app.permissions' );
            if ( isset( $permissions[ Route::currentRouteAction() ] ) && count( $permissions[ Route::currentRouteAction() ] ) > 0 ):
                foreach ( $permissions[ Route::currentRouteAction() ] as $permission ):
                    if ( !Auth::user()->can( $permissions[ Route::currentRouteAction() ][ 'slug' ] ) ) :
                        $error_message = 'You are not authorized to view this page.<br />
You do not have permission to view this directory or page using the credentials you supplied.';
                        return Response::view( 'partials.error' , ['page_title' => 'Unauthorized Action' , 'error_message' => $error_message , 'color' => 'red' , 'error_code' => '401' , 'error_title' => 'Oops! Unauthorized Action' ] );
                    endif;
                endforeach;
            endif;
        endif;
        return $next( $request );
    }

}
