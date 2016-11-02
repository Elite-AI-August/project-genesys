<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\View;
use Input;
use Validator;
use App\Http\Requests\RoleRequest;
use Caffeinated\Shinobi\Models\Role;
use Caffeinated\Shinobi\Models\Permission;
use Auth;
use Paginate;
use Grids;
use HTML;
use Form;
use Nayjest\Grids\Components\Base\RenderableRegistry;
use Nayjest\Grids\Components\ColumnHeadersRow;
use Nayjest\Grids\Components\ColumnsHider;
use Nayjest\Grids\Components\CsvExport;
use Nayjest\Grids\Components\ExcelExport;
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

/**
 * Class MetricController
 */
class RoleController extends Controller {

    public function __construct() {
        $this->middleware( 'auth' );
        parent::__construct();
    }

    /**
     * @var MetricRepository
     */
    protected $role;

    /**
     * Displays all metrics.
     *
     * @return \Illuminate\View\View
     */
    public function index() {

        $page_action_title = 'Roles';
        $page_title = 'Roles Management';
        $grid = $this->generateGrid( $page_action_title );
        $grid->setDataProvider(
                new EloquentDataProvider( Role::query() )
        );
        $grid->setColumns( [
                    (new FieldConfig )
                    ->setName( 'id' )
                    ->setLabel( 'ID' )
                    ->setSortable( true )
                    ->setSorting( Grid::SORT_ASC ) ,
                    (new FieldConfig )
                    ->setName( 'name' )
                    ->setLabel( 'Name' )
                    ->setCallback( function ($val) {
                                return $val;
                            } )
                    ->setSortable( true )
                    ->addFilter(
                            (new FilterConfig )
                            ->setOperator( FilterConfig::OPERATOR_LIKE )
                    ) ,
                    (new FieldConfig )
                    ->setName( 'slug' )
                    ->setLabel( 'Slug' )
                    ->setCallback( function ($val) {
                                return $val;
                            } )
                    ->setSortable( true )
                    ->addFilter(
                            (new FilterConfig )
                            ->setOperator( FilterConfig::OPERATOR_LIKE )
                    ) ,
                    (new FieldConfig )
                    ->setName( 'description' )
                    ->setLabel( 'Description' )
                    ->setCallback( function ($val) {
                                return $val;
                            } )
                    ->setSortable( true )
                    ->addFilter(
                            (new FilterConfig )
                            ->setOperator( FilterConfig::OPERATOR_LIKE )
                    ) ,
                    (new FieldConfig )
                    ->setName( 'actions' )
                    ->setLabel( 'Actions' )
                    ->setCallback( function ($val , $row ) {
                                $attr = $row->getSrc();
                                $btn = Form::button( '' , array( 'class' => 'no-style fa fa-pencil-square-o' ) );
                                $html = '<a class="pull-left" href="' . route( 'roles.edit' , $attr->id ) . '" >' . $btn . '</a>';
                                $html .= Form::open( array( 'class' => 'form-inline pull-left deletion-form' , 'method' => 'DELETE' , 'route' => array( 'roles.destroy' , $attr->id ) ) );
                                $html .= Form::button( '' , array( 'class' => 'no-style fa fa-trash-o delete-Btn' , 'type' => 'submit' ) );
                                $html .= Form::close();
                                return $html;
                            } )
                ] );
                $grid = new Grid( $grid );
                $grid = $grid->render();
                $routes = ['create' => 'roles.create' ];
                return $this->view( 'roles.index' , compact( 'routes' , 'grid' , 'page_action_title' , 'page_title' ) );
            }

            /**
             * Displays the form to create a metric.
             *
             * @return \Illuminate\View\View
             */
            public function create( Role $role ) {
                $role_permissions = [ ];
                $permissions = Permission::get();
                $page_action_title = 'Create Role';
                $page_title = 'Create Role';
                return view( 'roles.create' , compact( 'permissions' , 'role_permissions' , 'role' , 'page_action_title' , 'page_title' ) );
            }

            /**
             * Creates a metric.
             *
             * @param RoleRequest $request
             *
             * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
             */
            public function store( RoleRequest $request , Role $role ) {
                $role->fill( Input::all() );
                $syncPermissions = Input::get( 'permissions' );
                if ( count( $syncPermissions ) == 0 ):
                    $syncPermissions = [ ];
                else:
                    foreach ( $syncPermissions as $key => $syncPermission ):
                        $syncPermissions[ $key ] = ( int ) $syncPermission;
                    endforeach;
                endif;
                $role->save();
                $role->syncPermissions( $syncPermissions );
                $role->save();
                return Redirect::to( route( 'roles' ) )
                                ->with( 'flash_alert_notice' , 'Role was successfully created !' )->with( 'alert_class' , 'alert-success alert-dismissable' );
            }

            /**
             * Displays the form for editing the specified metric.
             *
             * @param int|string $id
             *
             * @return \Illuminate\View\View
             */
            public function edit( Role $role ) {
                $role_permissions = $role->getPermissions();
                $permissions = Permission::get();
                $page_action_title = 'Edit Role';
                $page_title = 'Edit Role - ' . $role->name;
                $this->avaiable_permissions();
                return view( 'roles.edit' , compact( 'permissions' , 'role_permissions' , 'role' , 'page_action_title' , 'page_title' ) );
            }

            /**
             * Updates the specified metric.
             *
             * @param RoleRequest $request
             * @param int|string    $id
             *
             * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
             */
            public function update( RoleRequest $request , Role $role ) {
                $role->fill( Input::all() );
                $syncPermissions = Input::get( 'permission' );
                if ( count( $syncPermissions ) == 0 ):
                    $syncPermissions = [ ];
                else:
                    foreach ( $syncPermissions as $key => $syncPermission ):
                        $syncPermissions[ $key ] = ( int ) $syncPermission;
                    endforeach;
                endif;
                $role->syncPermissions( $syncPermissions );
                $role->save();
                return Redirect::to( route( 'roles' ) )
                                ->with( 'flash_alert_notice' , 'Role was successfully updated!' )->with( 'alert_class' , 'alert-success alert-dismissable' );
            }

            /**
             * Remove the specified resource from storage.
             *
             * @param  int $id
             * @return Response
             */
            public function destroy( Role $role ) {
                Role::destroy( $role->id );
                return Redirect::to( route( 'roles' ) )
                                ->with( 'flash_alert_title' , 'OK' )->with( 'flash_alert_notice' , 'Metric was successfully deleted!' )->with( 'alert_class' , 'alert-success alert-dismissable' );
            }

            public function avaiable_permissions() {
                $array = \Config::get( 'app.permissions' );
            }

        }
