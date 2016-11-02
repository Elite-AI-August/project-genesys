<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Html\FormFacade;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Inventory\Admin\Models\CustomFields;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use DB;
use move;
use Auth;
use Menu;
use App\Helpers\Helper as Helper;
use Grids;
use HTML;
use Form;
use App\AppSettings;
use App\RoleUsers;
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
use Nayjest\Grids\Components\ExcelExport;
use Caffeinated\Shinobi\Models\Role;
use Caffeinated\Shinobi\Models\Permission;

class UserController extends Controller {

    protected $name = [
        'singular' => 'user' ,
        'plural'   => 'users' ,
    ];

    public function __construct() {
        $this->middleware( 'auth' );
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {

        $page_title = "User Management";
        $page_action_title = "View users";
        $grid = $this->generateGrid( $page_action_title , [ 'created_at' => 'created_at' ] );
        $grid->setDataProvider(
                new EloquentDataProvider( User::query()->where( 'id' , '!=' , 1 ) )
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
                    ->setName( 'email' )
                    ->setLabel( 'Email' )
                    ->setSortable( true )
                    ->addFilter(
                            (new FilterConfig )
                            ->setOperator( FilterConfig::OPERATOR_LIKE )
                    ) ,
                    (new FieldConfig )
                    ->setName( 'created_at' )
                    ->setLabel( 'Created At' )
                    ->setCallback( function ($val) {
                                return $val;
                            } )
                    ->setSortable( true ) ,
                    (new FieldConfig )
                    ->setName( 'actions' )
                    ->setLabel( 'Actions' )
                    ->setCallback( function ($val , $row ) {
                                $attr = $row->getSrc();
                                $btn = Form::button( '' , array( 'class' => 'no-style fa fa-pencil-square-o' ) );
                                $html = '<a class="pull-left" href="' . route( 'users.edit' , $attr->id ) . '" >' . $btn . '</a>';
                                $html .= Form::open( array( 'class' => 'form-inline pull-left deletion-form' , 'method' => 'DELETE' , 'route' => array( 'users.destroy' , $attr->id ) ) );
                                $html .= Form::button( '' , array( 'class' => 'no-style fa fa-trash-o delete-Btn' , 'type' => 'submit' ) );
                                $html .= Form::close();
                                return $html;
                            } )
                ] );
                $grid = new Grid( $grid );
                $grid = $grid->render();
                $routes = ['create' => 'users.create' ];
                $page_settings = ['page_title' => 'All ' . $this->name[ 'plural' ] , 'create_link' => route( 'users.create' ) , 'create_name' => 'New ' . $this->name[ 'singular' ] ];
                return $this->view( 'users.index' , compact( 'routes' , 'grid' , 'page_settings' , 'page_action_title' , 'page_title' ) );
            }

            /**
             * Show the form for creating a new resource.
             *
             * @return Response
             */
            public function create() {

                $roles = Role::lists( 'name' , 'id' )->all();
                $page_title = "Create User";
                $page_action_title = "Create User";
                $page_settings = ['page_title' => 'Create ' . $this->name[ 'plural' ] ];
                $helper = new Helper;
                $data = $helper->getCustomFields( 'Users' );
                //dd( $data );
                return view( 'users.create' , compact( 'data' , 'roles' , 'page_settings' , 'get_custom_field' , 'page_title' , 'get_custom_field' ) );
            }

            /**
             * Store a newly created resource in storage.
             *
             * @return Response
             */
            public function store( StoreUserRequest $request , User $user ) {
                $user->password = bcrypt( $request->password );
                $user->name = $request->name;
                $user->email = $request->email;
                $user->save();
                $helper = new Helper;
                $input = Input::except( '_token' , 'name' , 'email' , 'password' , 'roles' , 'image' , 'password_confirmation' );
                $helper->addMetaData( $input , $user );

                if ( Input::hasFile( 'user_image' ) ) {
                    $request->file( 'user_image' )->move( public_path() . '/user_files/' , $user->id . '.' . $request->file( 'user_image' )->getClientOriginalName() );
                    @unlink( public_path() . '/user_files/' , $user->id . '.' . $request->file( 'user_image' )->getClientOriginalExtension() );
                    $user->image = '/user_files/' . $user->id . '.' . $request->file( 'image' )->getClientOriginalExtension();
                    // $user->save();
                }

                if ( Input::hasFile( 'file_name' ) ) {
                    $helper->addFileToMeta( $user , 'add' );
                }



                foreach ( Input::get( 'roles' ) as $role_id ) {
                    $user->assignRole( array( $role_id ) );
                }
                return Redirect::to( route( 'users' ) )
                                ->with( 'flash_alert_title' , 'OK' )->with( 'flash_alert_notice' , 'User was successfully created!' )->with( 'alert_class' , 'alert-success alert-dismissable' );
            }

            /**
             * Display the specified resource.
             *
             * @param  int $id
             * @return Response
             */
            public function show( User $user ) {
                $roles = Role::lists( 'name' , 'id' )->all();
                $user_roles = $user->roles();
                return view( 'users.edit' , ['user' => $user , 'roles' => $roles ] );
            }

            /**
             * Show the form for editing the specified resource.
             *
             * @param  int $id
             * @return Response
             */
            public function edit( User $user ) {
                if ( $user->id == 1 ):
                    return false;
                endif;
                //$user = User::find( $id );
                $page_title = 'Edit user';
                $roles = Role::lists( 'name' , 'id' )->all();
                $page_settings = ['page_title' => 'Edit ' . $this->name[ 'plural' ] ];
                $user_role = $user->roles;
                foreach ( $user_role as $key => $value ) {
                    $user_roles[] = $value->id;
                }
                $helper = new Helper;
                $data = $helper->getCustomFields( 'Users' );
                $model = $user::find( $user->id );
                $custom_record = $model->getAllMeta();

                //dd( $custom_record );
                return view( 'users.edit' , compact( 'user' , 'data' , 'custom_record' , 'roles' , 'user_roles' , 'page_settings' , 'page_title' ) );
            }

            /**
             * Update the specified resource in storage.
             *
             * @param  int $id
             * @return Response
             */
            public function update( UpdateUserRequest $request , User $user ) {
                if ( $user->id == 1 ):
                    return false;
                endif;
                $user->password = bcrypt( $request->password );
                $user->name = $request->name;
                $user->email = $request->email;
                $user->save();
                /* updateMetaData Helper use to update meta data of user custom fieled */
                $helper = new Helper;
                $input = Input::except( '_token' , 'name' , 'email' , 'password' , 'roles' , 'image' , 'password_confirmation' );
                $helper->updateMetaData( $input , $user );

                if ( Input::hasFile( 'image' ) ) {
                    $request->file( 'image' )->move( public_path() . '/user_files/' , $user->id . '.' . $request->file( 'image' )->getClientOriginalName() );
                    @unlink( public_path() . '/user_files/' , $user->id . '.' . $request->file( 'image' )->getClientOriginalExtension() );
                    $user->image = '/user_files/' . $user->id . '.' . $request->file( 'image' )->getClientOriginalExtension();
                    // $user->save();
                }

                $helper->addFileToMeta( $user , 'update' );
                foreach ( Input::get( 'roles' ) as $role_id ) {
                    $user->assignRole( array( $role_id ) );
                }
                return Redirect::to( route( 'users' ) )
                                ->with( 'flash_alert_title' , 'OK' )->with( 'flash_alert_notice' , 'User was successfully created!' )->with( 'alert_class' , 'alert-success alert-dismissable' );
            }

            /**
             * Remove the specified resource from storage.
             *
             * @param  int $id
             * @return Response
             */
            public function destroy( User $user ) {
                if ( $user->id == 1 ):
                    return false;
                endif;
                User::destroy( $user->id );
                return Redirect::to( route( 'users' ) )
                                ->with( 'flash_alert_title' , 'OK' )->with( 'flash_alert_notice' , 'User was successfully deleted!' )->with( 'alert_class' , 'alert-success alert-dismissable' );
            }

        }
