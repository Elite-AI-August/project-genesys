<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Caffeinated\Shinobi\Traits\ShinobiTrait;

class AppServiceProvider extends ServiceProvider {

    use ShinobiTrait;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        $generic_list = [
            'App\Http\Controllers\UserController'                              => 'users' ,
            'App\Http\Controllers\RoleController'                              => 'roles' ,
            'Inventory\Admin\Http\Controllers\InventoryController'             => 'inventories' ,
            'App\Http\Controllers\CustomFieldsController'                      => 'customFields' ,
            'Inventory\Admin\Http\Controllers\InventoryStockController'        => 'stock' ,
            'Inventory\Admin\Http\Controllers\LocationController'              => 'locations' ,
            'Inventory\Admin\Http\Controllers\MetricController'                => 'metrics' ,
            'Inventory\Admin\Http\Controllers\SupplierController'              => 'suppliers' ,
            'Inventory\Admin\Http\Controllers\InventoryTransactionsController' => 'transactions' ,
        ];

        $generic_actions = ['index' , 'show' , 'create' , 'store' , 'edit' , 'update' , 'destroy' ];
        //$role = \Caffeinated\Shinobi\Models\Role::find( 1 );
        $permissions = [ ];
        foreach ( $generic_list as $key => $value ):
            foreach ( $generic_actions as $action ):
                $permissions[ $key . '@' . $action ] = [
                    'slug' => $action . '_' . $value ,
                    'name' => ucfirst( $action ) . ' ' . $value
                ];
                /* $role->assignPermission( $aa->id ); */
            endforeach;
        endforeach;
        $list = [
            'Inventory\Admin\Http\Controllers\InventoryStockController@kit_edit'            => [
                'name' => 'Edit Kit Content' ,
                'slug' => 'edit_kit'
            ] ,
            'Inventory\Admin\Http\Controllers\InventoryStockController@kit_update'          => [
                'name' => 'Edit Kit Content' ,
                'slug' => 'edit_kit'
            ] ,
            'Inventory\Admin\Http\Controllers\InventoryTransactionsController@download_pdf' => [
                'name' => 'Download Move Location PDF' ,
                'slug' => 'download_move_location_pdf'
            ]
        ];
        foreach ( $list as $key => $value ):
            $permissions[ $key ] = $value;
        endforeach;
        $permissions = array_merge( $permissions , $list );
        foreach ( $permissions as $permission ):
            $permission_ext = \Caffeinated\Shinobi\Models\Permission::get()->where( 'slug' , $permission[ 'slug' ] );
            if ( count( $permission_ext ) == 0 ):
                \Caffeinated\Shinobi\Models\Permission::create( $permission );
            endif;
        endforeach;
        \Config::set( 'app.permissions' , $permissions );
    }

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register() {
        $this->app->bind(
                'Illuminate\Contracts\Auth\Registrar' , 'App\Services\Registrar'
        );

        $this->app->bind(PostRepositoryContract::class, PostRepository::class);
    }

}
