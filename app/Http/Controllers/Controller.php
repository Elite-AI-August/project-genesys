<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\AppSettings;
use Config;
use Nayjest\Grids\Components\Base\RenderableRegistry;
use Nayjest\Grids\Components\ColumnHeadersRow;
use Nayjest\Grids\Components\ColumnsHider;
use Nayjest\Grids\Components\CsvExport;
use Nayjest\Grids\Components\Filters\DateRangePicker;
use Nayjest\Grids\Components\FiltersRow;
use Nayjest\Grids\Components\HtmlTag;
use Nayjest\Grids\Components\Laravel5\Pager;
use Nayjest\Grids\Components\OneCellRow;
use Nayjest\Grids\Components\RecordsPerPage;
use Nayjest\Grids\Components\RenderFunc;
use Nayjest\Grids\Components\ShowingRecords;
use Nayjest\Grids\Components\TFoot;
use Nayjest\Grids\Components\THead;
use Nayjest\Grids\Components\TotalsRow;
use Nayjest\Grids\DbalDataProvider;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;
use App\Http\Controllers\Controller;
use Nayjest\Grids\Components\ExcelExport;
use Auth;
use Route;
use App\Menu as MenuDB;
use Menu;

abstract class Controller extends BaseController {

    use DispatchesCommands ,
        ValidatesRequests;

    public $global_settings = [ ];

    public function __construct() {
        $this->global_settings = AppSettings::lists( 'option_value' , 'option_name' )->all();
        foreach ( $this->global_settings as $key => $value ) {
            Config::set( 'app.' . $key , $value );
        }
        $this->middleware( 'permission' );
        $this->registerAdminMenu();
    }

    public function checkPer( $action ) {
        if ( \Auth::check() ):
            if ( Auth::user()->id != 1 ):
                $permissions = Config::get( 'app.permissions' );
                if ( isset( $permissions[ $action ] ) && count( $permissions[ $action ] ) > 0 ):
                    foreach ( $permissions[ $action ] as $permission ):
                        if ( !Auth::user()->can( $permissions[ $action ][ 'slug' ] ) ) :
                            return false;
                        endif;
                    endforeach;
                endif;
                return true;
            else:
                return true;
            endif;
        endif;
        return false;
    }

    public function registerAdminMenu() {
        Menu::make( 'sidebar' , function($menu) {
            // If as children
            $dropdown_arrow = '<i class="fa fa-angle-left pull-right"></i>';
            $menu_items = MenuDB::find( 1 )->items()->orderBy( 'sort' , 'ASC' )->get();
            $items = [ ];
            if ( count( $menu_items ) > 0 ) :
                foreach ( $menu_items as $item ):
                    if ( $item->parent_id != 0 ):
                        if ( !isset( $items[ $item->parent_id ][ 'childrens' ] ) ):
                            $items[ $item->parent_id ][ 'childrens' ] = [ ];
                        endif;
                        $items[ $item->parent_id ][ 'childrens' ] = array_merge( [ $item ] , $items[ $item->parent_id ][ 'childrens' ] );
                    else:
                        if ( !isset( $items[ $item->id ] ) ):
                            $items[ $item->id ] = [ ];
                        endif;
                        $items[ $item->id ] = array_merge( $item->toArray() , $items[ $item->id ] );
                    endif;
                endforeach;
            endif;
            if ( count( $items ) > 0 ) :
                foreach ( $items as $menu_item ):
                    if ( $this->checkPer( $menu_item[ 'action' ] ) ):
                        $action = action( "\\" . $menu_item[ 'action' ] );
                        $parent = $menu->add( '<span>' . $menu_item[ 'title' ] . '</span>' , $action );
                        $parent->icon( $menu_item[ 'icon' ] );
                        $parent->active( $action . '/* ' );
                        $parent->data( 'order' , $menu_item[ 'sort' ] );
                        if ( isset( $menu_item[ 'childrens' ] ) ):
                            $parent->attribute( 'class' , 'treeview' );
                            $parent->append( $dropdown_arrow );
                            foreach ( $menu_item[ 'childrens' ] as $child ):
                                if ( $this->checkPer( $child->action ) ):
                                    $menu->{$parent->slug}->add( $child->title , action( "\\" . $child->action ) )->active( action( "\\" . $child->action ) . '/*' )->data( 'order' , $child[ 'sort' ] );
                                endif;
                            endforeach;
                        endif;
                    endif;
                endforeach;
            endif;
        } )->sortBy( 'order' );
    }

    public function view( $view = null , $data = array() , $mergeData = array() ) {
        if ( !view()->exists( $view ) ):
            $view = explode( '.' , $view );
            $view = 'partials.' . $view[ count( $view ) - 1 ];
        endif;
        return view( $view , $data , $mergeData );
    }

    public function generateGrid( $grid_name = '' , $gridConfigData = [ ] ) {
        $gridConfig = new GridConfig;
        $gridConfig->setName( str_slug( $grid_name ) );
        $gridConfig->setPageSize( Config::get( 'app.NumberOfPerPage' ) );
        $gridTHead = new THead;
        $gridFilterRow = new FiltersRow;
        if ( count( $gridConfigData ) > 0 ):
            foreach ( $gridConfigData as $key => $val ):
                $gridFilterRow->addComponents( [
                            (new RenderFunc( function () {
                                return "<style>
                                                                .daterangepicker td.available.active,
                                                                .daterangepicker li.active,
                                                                .daterangepicker li:hover {
                                                                    color:black !important;
                                                                    font-weight: bold;
                                                                }
                                                           </style>";
                            } ) )
                            ->setRenderSection( 'filters_row_column_' . $key ) ,
                            (new DateRangePicker )
                            ->setName( $val )
                            ->setRenderSection( 'filters_row_column_' . $key )
                            ->setDefaultValue( [ '2000-01-01' , date( "Y-m-d" , strtotime( "+ 1 day" ) ) ] )
                ] );
            endforeach;
        endif;
        $gridTHead->setComponents( [
                    (new OneCellRow )
                    ->setComponents( [
                        new ColumnsHider ,
                        (new ExcelExport )
                        ->setFileName( str_slug( $grid_name ) . '_' . date( 'Y-m-d-H-m-s' ) . '_' . time() )->setIgnoredColumns( [ 'actions' ] ) ,
                        (new HtmlTag )
                        ->setContent( '<span class="glyphicon glyphicon-refresh"></span> Filter' )
                        ->setTagName( 'button' )
                        ->setRenderSection( RenderableRegistry::SECTION_END )
                        ->setAttributes( [
                            'class' => 'btn btn-success btn-sm'
                        ] )
                    ] ) ,
            $gridFilterRow ,
            new RenderFunc( function() {
                return '</form>';
            } ) ,
            (new ColumnHeadersRow) ,
        ] );
        $gridComponents = [
            $gridTHead
            ,
                    (new TFoot )
                    ->setComponents( [
                        (new OneCellRow )
                        ->setComponents( [
                            new Pager ,
                            (new HtmlTag )
                            ->setAttributes( [ 'class' => 'pull-right' ] )
                            ->addComponent( new ShowingRecords ) ,
                        ] )
                    ] ) ,
        ];
        $gridConfig->setComponents( $gridComponents );
        return $gridConfig;
    }

}
