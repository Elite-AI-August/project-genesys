<?php

namespace App\Http;

use Exception;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        'App\Http\Middleware\Language' ,
//        'localize' => 'Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes',
//        'localizationRedirect' => 'Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter',
//        'localeSessionRedirect' => 'Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect',
//
        'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode' ,
        'Illuminate\Cookie\Middleware\EncryptCookies' ,
        'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse' ,
        'Illuminate\Session\Middleware\StartSession' ,
        'Illuminate\View\Middleware\ShareErrorsFromSession' ,
        'App\Http\Middleware\VerifyCsrfToken' ,
        'Clockwork\Support\Laravel\ClockworkMiddleware' ,
        'Illuminate\View\Middleware\ShareErrorsFromSession' ,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'       => 'App\Http\Middleware\Authenticate' ,
        'auth.basic' => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth' ,
        'guest'      => 'App\Http\Middleware\RedirectIfAuthenticated' ,
        'permission' => 'App\Http\Middleware\VerifyPermission' ,
    ];

}
