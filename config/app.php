<?php

return [

    /*
      |--------------------------------------------------------------------------
      | Application Debug Mode
      |--------------------------------------------------------------------------
      |
      | When your application is in debug mode, detailed error messages with
      | stack traces will be shown on every error that occurs within your
      | application. If disabled, a simple generic error page is shown.
      |
     */

    'debug'                                 => env( 'APP_DEBUG' , true ) ,
    /*
      |--------------------------------------------------------------------------
      | Application URL
      |--------------------------------------------------------------------------
      |
      | This URL is used by the console to properly generate URLs when using
      | the Artisan command line tool. You should set this to the root of
      | your application so that it is used when running Artisan tasks.
      |
     */
    'url'                                   => 'http://localhost/laravel5/' ,
    /*
      |--------------------------------------------------------------------------
      | Application Timezone
      |--------------------------------------------------------------------------
      |
      | Here you may specify the default timezone for your application, which
      | will be used by the PHP date and date-time functions. We have gone
      | ahead and set this to a sensible default for you out of the box.
      |
     */
    'timezone'                              => 'Asia/Jerusalem' ,
    /*
      |--------------------------------------------------------------------------
      | Application Locale Configuration
      |--------------------------------------------------------------------------
      |
      | The application locale determines the default locale that will be used
      | by the translation service provider. You are free to set this value
      | to any of the locales which will be supported by the application.
      |
     */
    'locale'                                => 'en' ,
    'locales'                               => ['en' => 'English' , 'he' => 'Hebrew' ] ,
    /*
      |--------------------------------------------------------------------------
      | Application Fallback Locale
      |--------------------------------------------------------------------------
      |
      | The fallback locale determines the locale to use when the current one
      | is not available. You may change the value to correspond to any of
      | the language folders that are provided through your application.
      |
     */
    'fallback_locale'                       => 'en' ,
    /*
      |--------------------------------------------------------------------------
      | Encryption Key
      |--------------------------------------------------------------------------
      |
      | This key is used by the Illuminate encrypter service and should be set
      | to a random, 32 character string, otherwise these encrypted strings
      | will not be safe. Please do this before deploying an application!
      |
     */
    'key'                                   => env( 'APP_KEY' , '1iQszg1NOoT1hXHbX9a0rFArd4dyZCE3' ) ,
    'cipher'                                => MCRYPT_RIJNDAEL_128 ,
    /*
      |--------------------------------------------------------------------------
      | Custom Configuration setting
      |--------------------------------------------------------------------------
      |
      | Here you may configure the log settings for your application. Out of
      | the box, Laravel uses the Monolog PHP logging library. This gives
      | you a variety of powerful log handlers / formatters to utilize.
      |
      | Available Settings: "single", "daily", "syslog", "errorlog"
      |
     */
    'log'                                   => 'daily' ,
    'NumberOfPerPage'                       => 10 ,
    /* -----------------Delivery zizpic price----- */
    'zizpic_delivery'                       => 5 ,
    'zizpic_order_1'                        => 10 ,
    'zizpic_order_1'                        => 25 ,
    /* -------- Inventorory Title ----------- */
    'pageActionTitleInventoryIndex'         => 'Inventory Management' ,
    'pageActionTitleInventoryCreate'        => 'Create New Item' ,
    'pageActionTitleEdit'                   => 'Edit' ,
    /* -------- Metrics Title ----------- */
    'pageActionTitleMetricIndex'            => 'Metrics Management' ,
    'pageActionTitleMetricCreate'           => 'Create New Metric' ,
    /* -------- Location Title ----------- */
    'pageActionTitleLocationIndex'          => 'Location Management' ,
    'pageActionTitleLocationCreate'         => 'Create New Location' ,
    /* ---------Suppliers -------- */
    'pageActionTitleSupplierIndex'          => 'Suppliers Management' ,
    'pageActionTitleSupplierCreate'         => 'Create New Supplier' ,
    /* ----------Stocks---------- */
    'pageActionTitleStockIndex'             => 'Stocks Management' ,
    'pageActionTitleStockCreate'            => 'Create New Stock' ,
    /* ----------Kits---------- */
    'pageActionTitleKitIndex'               => 'Kits Management' ,
    'pageActionTitleKitCreate'              => 'Create New Kit' ,
    /* ----------Transaction State---------- */
    'pageActionTitleTransactionStateIndex'  => 'TransactionState Management' ,
    'pageActionTitleTransactionStateCreate' => 'Create New Transaction State' ,
    /* ----------KitStock State---------- */
    'pageActionTitleKitStockStateIndex'     => 'KitStock Management' ,
    'pageActionTitleKitStockCreate'         => 'Create New KitStock' ,
    /*
      |--------------------------------------------------------------------------
      | Autoloaded Service Providers
      |--------------------------------------------------------------------------
      |
      | The service providers listed here will be automatically loaded on the
      | request to your application. Feel free to add your own services to
      | this array to grant expanded functionality to your applications.
      |
     */
    'providers'                             => [

        /*
         * Laravel Framework Service Providers...
         */
        'Illuminate\Foundation\Providers\ArtisanServiceProvider' ,
        'Illuminate\Auth\AuthServiceProvider' ,
        'Illuminate\Bus\BusServiceProvider' ,
        'Illuminate\Cache\CacheServiceProvider' ,
        'Illuminate\Foundation\Providers\ConsoleSupportServiceProvider' ,
        'Illuminate\Routing\ControllerServiceProvider' ,
        'Illuminate\Cookie\CookieServiceProvider' ,
        'Illuminate\Database\DatabaseServiceProvider' ,
        'Illuminate\Encryption\EncryptionServiceProvider' ,
        'Illuminate\Filesystem\FilesystemServiceProvider' ,
        'Illuminate\Foundation\Providers\FoundationServiceProvider' ,
        'Illuminate\Hashing\HashServiceProvider' ,
        'Illuminate\Mail\MailServiceProvider' ,
        'Illuminate\Pagination\PaginationServiceProvider' ,
        'Illuminate\Pipeline\PipelineServiceProvider' ,
        'Illuminate\Queue\QueueServiceProvider' ,
        'Illuminate\Redis\RedisServiceProvider' ,
        'Illuminate\Auth\Passwords\PasswordResetServiceProvider' ,
        'Illuminate\Session\SessionServiceProvider' ,
        'Illuminate\Translation\TranslationServiceProvider' ,
        'Illuminate\Validation\ValidationServiceProvider' ,
        'Illuminate\View\ViewServiceProvider' ,
        'Collective\Html\HtmlServiceProvider' ,
        /*
         * Application Service Providers...
         */
        'App\Providers\AppServiceProvider' ,
        'App\Providers\BusServiceProvider' ,
        'App\Providers\ConfigServiceProvider' ,
        'App\Providers\EventServiceProvider' ,
        'App\Providers\RouteServiceProvider' ,
        'Caffeinated\Shinobi\ShinobiServiceProvider' ,
        //'App\Providers\InventoryServiceProvider' ,
        //'Inventory\Admin\InventoryServiceProvider' ,
        'Caffeinated\Menus\MenusServiceProvider' ,
        'Proengsoft\JsValidation\JsValidationServiceProvider' ,
        // Datatables
        'yajra\Datatables\DatatablesServiceProvider' ,
        // Grid
        'Nayjest\Grids\ServiceProvider' ,
        // Clockwork
        'Clockwork\Support\Laravel\ClockworkServiceProvider' ,
        'Barryvdh\DomPDF\ServiceProvider' ,
        'Laracasts\Utilities\JavaScript\JavascriptServiceProvider' ,
        // Excel package
        'Maatwebsite\Excel\ExcelServiceProvider' ,
        // Backup
        'Spatie\Backup\BackupServiceProvider' ,
        'Phoenix\EloquentMeta\ServiceProvider' ,
        'Zizpic\Admin\ZizpicServiceProvider' 
    ] ,
    /*
      |--------------------------------------------------------------------------
      | Class Aliases
      |--------------------------------------------------------------------------
      |
      | This array of class aliases will be registered when this application
      | is started. However, feel free to register as many as you wish as
      | the aliases are "lazy" loaded so they don't hinder performance.
      |
     */
    'aliases'                               => [

        'App'         => 'Illuminate\Support\Facades\App' ,
        'Artisan'     => 'Illuminate\Support\Facades\Artisan' ,
        'Auth'        => 'Illuminate\Support\Facades\Auth' ,
        'Blade'       => 'Illuminate\Support\Facades\Blade' ,
        'Bus'         => 'Illuminate\Support\Facades\Bus' ,
        'Cache'       => 'Illuminate\Support\Facades\Cache' ,
        'Config'      => 'Illuminate\Support\Facades\Config' ,
        'Cookie'      => 'Illuminate\Support\Facades\Cookie' ,
        'Crypt'       => 'Illuminate\Support\Facades\Crypt' ,
        'DB'          => 'Illuminate\Support\Facades\DB' ,
        'Eloquent'    => 'Illuminate\Database\Eloquent\Model' ,
        'Event'       => 'Illuminate\Support\Facades\Event' ,
        'File'        => 'Illuminate\Support\Facades\File' ,
        'Hash'        => 'Illuminate\Support\Facades\Hash' ,
        'Input'       => 'Illuminate\Support\Facades\Input' ,
        'Inspiring'   => 'Illuminate\Foundation\Inspiring' ,
        'Lang'        => 'Illuminate\Support\Facades\Lang' ,
        'Log'         => 'Illuminate\Support\Facades\Log' ,
        'Mail'        => 'Illuminate\Support\Facades\Mail' ,
        'Password'    => 'Illuminate\Support\Facades\Password' ,
        'Queue'       => 'Illuminate\Support\Facades\Queue' ,
        'Redirect'    => 'Illuminate\Support\Facades\Redirect' ,
        'Redis'       => 'Illuminate\Support\Facades\Redis' ,
        'Request'     => 'Illuminate\Support\Facades\Request' ,
        'Response'    => 'Illuminate\Support\Facades\Response' ,
        'Route'       => 'Illuminate\Support\Facades\Route' ,
        'Schema'      => 'Illuminate\Support\Facades\Schema' ,
        'Session'     => 'Illuminate\Support\Facades\Session' ,
        'Storage'     => 'Illuminate\Support\Facades\Storage' ,
        'URL'         => 'Illuminate\Support\Facades\URL' ,
        'Validator'   => 'Illuminate\Support\Facades\Validator' ,
        'View'        => 'Illuminate\Support\Facades\View' ,
        'Menu'        => 'Caffeinated\Menus\Facades\Menu' ,
        'Form'        => 'Collective\Html\FormFacade' ,
        'HTML'        => 'Collective\Html\HtmlFacade' ,
        // Grid
        'Grids'       => 'Nayjest\Grids\Grids' ,
        'JsValidator' => 'Proengsoft\JsValidation\Facades\JsValidatorFacade' ,
        // Clockwork
        'Clockwork'   => 'Clockwork\Support\Laravel\Facade' ,
        'PDF'         => 'Barryvdh\DomPDF\Facade' ,
        // Excel
        'Excel'       => 'Maatwebsite\Excel\Facades\Excel' ,
        // Datatables
        'Datatables'  => 'yajra\Datatables\Datatables' ,
    ] ,
];
