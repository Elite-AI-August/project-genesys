<?php

namespace zizpic\Admin\Providers;

use Menu;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider {

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot() {
        $dropdown_arrow = '<i class="fa fa-angle-left pull-right"></i>';
        $menu = Menu::get( 'sidebar' );
        $menu_items = [
            [
                'title' => 'Inventory Management' ,
                'icon'  => 'tachometer' ,
                'route' => 'inventories' ,
                'data'  => ['order' => 20 ] ,
            ] ,
            [
                'title'     => 'Reports' ,
                'icon'      => 'bar-chart' ,
                'route'     => 'home' ,
                'data'      => ['order' => 30 ] ,
                'childrens' => [
                    [
                        'title' => 'Inventory Stock' ,
                        'icon'  => 'tachometer' ,
                        'route' => 'inventoryStock' ,
                    ] ,
                    [
                        'title' => 'Transactions' ,
                        'icon'  => 'tachometer' ,
                        'route' => 'transactions' ,
                    ] ,
                ]
            ] ,
            [
                'title'     => 'System Settings' ,
                'icon'      => 'gears' ,
                'route'     => 'users' ,
                'data'      => ['order' => 80 ] ,
                'childrens' => [
                    /* [
                      'title' => 'Metrics' ,
                      'icon'  => 'tachometer' ,
                      'route' => 'metrics' ,
                      ] , */
                    [
                        'title' => 'Locations' ,
                        'icon'  => 'tachometer' ,
                        'route' => 'locations' ,
                    ] ,
                /* [
                  'title' => 'Suppliers' ,
                  'icon'  => 'tachometer' ,
                  'route' => 'suppliers' ,
                  ] , */
                /*  [
                  'title' => 'Transaction States' ,
                  'icon'  => 'tachometer' ,
                  'route' => 'transactionstates' ,
                  ] , */
                ]
            ]
        ];
        if ( count( $menu_items ) > 0 ) :
            foreach ( $menu_items as $menu_item ):
                if ( !isset( $menu_item[ 'childrens' ] ) ):
                    $parent = $menu->add( '<span>' . $menu_item[ 'title' ] . '</span>' , route( $menu_item[ 'route' ] ) )->icon( $menu_item[ 'icon' ] )->active( route( $menu_item[ 'route' ] ) . '/*' )->data( 'order' , $menu_item[ 'data' ][ 'order' ] );
                else:
                    $parent = $menu->add( '<span>' . $menu_item[ 'title' ] . '</span>' , route( $menu_item[ 'route' ] ) )->attribute( 'class' , 'treeview' )->icon( $menu_item[ 'icon' ] )->append( $dropdown_arrow )->active( route( $menu_item[ 'route' ] ) . '/*' )->data( 'order' , $menu_item[ 'data' ][ 'order' ] );
                    foreach ( $menu_item[ 'childrens' ] as $child ):
                        $menu->{$parent->slug}->add( $child[ 'title' ] , route( $child[ 'route' ] ) );
                    endforeach;
                endif;
            endforeach;
        endif;
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        //
    }

}
