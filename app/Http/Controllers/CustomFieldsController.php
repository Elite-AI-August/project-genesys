<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\View;
use Input;
use App\CustomFields;
use Validator;
use Inventory\Admin\Http\Requests\CustomFieldRequest;
use App\AppSettings;
use Auth;
use Paginate;
use Menu;
use App\Helpers\Helper as Helper;
use Grids;
use HTML;
use Form;
use Nayjest\Grids\SelectFilterConfig;
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

class CustomFieldsController extends Controller {

    public function __construct() {
        $this->middleware( 'auth' );
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index( AppSettings $app_setting , CustomFields $custom_field ) {
        //$custom_fields = \DB::table( 'custom_fields' )->join( 'app_setting' , 'custom_fields.fieldable' , '=' , 'app_setting.id' )->select( ['custom_fields.id' , 'app_setting.option_value' , 'custom_fields.field_rules' , 'custom_fields.field_placeholder' , 'custom_fields.field_type' , 'custom_fields.field_name' , 'custom_fields.updated_at' ] );

        $page_action_title = 'Custom Fields';
        $page_title = 'Custom Fields';
        $grid = $this->generateGrid( $page_action_title );


        $grid->setDataProvider(
                new EloquentDataProvider( CustomFields::query() )
        );
        $grid->setColumns( [
                    (new FieldConfig )
                    ->setName( 'id' )
                    ->setLabel( 'ID' )
                    ->setSortable( true )
                    ->setSorting( Grid::SORT_ASC )
            ,
                    (new FieldConfig )
                    ->setName( 'field_name' )
                    ->setLabel( 'Name' )
                    ->setCallback( function ($val) {
                                return $val;
                            } )
                    ->setSortable( true )
                    ->addFilter(
                            (new FilterConfig )
                            ->setOperator( FilterConfig::OPERATOR_LIKE )
                    )
            ,
                    (new FieldConfig )
                    ->setName( 'field_type' )
                    ->setLabel( 'Field Type' )
                    ->setSortable( true )
                    ->setSorting( Grid::SORT_ASC )
            ,
                    (new FieldConfig )
                    ->setName( 'field_placeholder' )
                    ->setLabel( 'Field Placeholder' )
                    ->setSortable( true )
            ,
                    (new FieldConfig )
                    ->setName( 'actions' )
                    ->setLabel( 'Actions' )
                    ->setCallback( function ($val , $row ) {
                                $attr = $row->getSrc();
                                $btn = Form::button( '' , array( 'class' => 'no-style fa fa-pencil-square-o' ) );

                                $html = '<a class="pull-left" href="' . route( 'customFields.edit' , $attr->id ) . '" >' . $btn . '</a>';
                                $html .= Form::open( array( 'class' => 'form-inline pull-left deletion-form' , 'method' => 'DELETE' , 'route' => array( 'customFields.destroy' , $attr->id ) ) );
                                $html .= Form::button( '' , array( 'class' => 'no-style fa fa-trash-o delete-Btn' , 'type' => 'submit' ) );
                                $html .= Form::close();
                                return $html;
                            } )
                ] );
                $grid = new Grid( $grid );
                $grid = $grid->render();
                $routes = ['create' => 'customFields.create' ];
                return $this->view( 'packages::customfields.index' , compact( 'routes' , 'grid' , 'page_action_title' , 'page_title' ) );
            }

            /**
             * Show the form for creating a new resource.
             *
             * @return Response
             */
            public function create( CustomFields $custom_field ) {
                //

                $fildable_lists = AppSettings::where( 'option_name' , 'fieldable_type' )->lists( 'option_value' , 'id' )->all();
                $page_action_title = 'Create Custom Field';
                $page_title = 'Create Custom Field';

                return view( 'packages::customfields.create' , compact( 'custom_field' , 'fildable_lists' , 'page_action_title' , 'page_title' ) );
            }

            /**
             * Store a newly created resource in storage.
             *
             * @param  Request  $request
             * @return Response
             */
            public function store( CustomFieldRequest $request , CustomFields $custom_field ) {

                $custom_field->fill( Input::all() );
                $custom_field->save();
                return Redirect::to( route( 'customFields' ) )
                                ->with( 'flash_alert_notice' , 'custom fields was successfully created !' )->with( 'alert_class' , 'alert-success alert-dismissable' );
            }

            /**
             * Display the specified resource.
             *
             * @param  int  $id
             * @return Response
             */
            public function show( $id ) {
//
            }

            /**
             * Show the form for editing the specified resource.
             *
             * @param  int  $id
             * @return Response
             */
            public function edit( CustomFields $custom_field ) {

                $page_action_title = 'Edit Custom Field';
                $page_title = 'Edit Custom field - ' . $custom_field->field_name;

                $fildable_lists = AppSettings::where( 'option_name' , 'fieldable_type' )->lists( 'option_value' , 'id' )->all();
                $page_action_title = 'Create custom field';
                return view( 'packages::customfields.edit' , compact( 'custom_field' , 'fildable_lists' , 'page_action_title' , 'page_title' ) );
            }

            /**
             * Update the specified resource in storage.
             *
             * @param  Request  $request
             * @param  int  $id
             * @return Response
             */
            public function update( CustomFieldRequest $request , CustomFields $custom_field ) {

                $custom_field->fill( Input::all() );
                $custom_field->save();
                return Redirect::to( route( 'customFields' ) )
                                ->with( 'flash_alert_notice' , 'Custom field was successfully updated !' )->with( 'alert_class' , 'alert-success alert-dismissable' );
            }

            /**
             * Remove the specified resource from storage.
             *
             * @param  int  $id
             * @return Response
             */
            public function destroy( CustomFields $customf_field ) {
                // dd( $customf_field->id );
                CustomFields::destroy( $customf_field->id );
                return Redirect::to( route( 'customFields' ) )
                                ->with( 'flash_alert_title' , 'OK' )->with( 'flash_alert_notice' , 'Custom field was successfully deleted!' )->with( 'alert_class' , 'alert-success alert-dismissable' );
            }

        }
