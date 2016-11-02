<?php

namespace Zizpic\Admin\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\View;
use Input;
use Validator;
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
use Zizpic\Admin\Models\ZizpicOrder;
use Zizpic\Admin\Models\CouponCode;
use Zizpic\Admin\Models\Coupon;
use Zizpic\Admin\Http\Requests\ZizpicCouponsRequest;
use Omnipay\Omnipay;
use Illuminate\Support\Facades\Session;
use App\Helpers\Helper as Helper;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\App;
use DB;

//use Inventory\Admin\Http\Requests\MetricRequest;

/**
 * Class MetricController
 */
class CopounsController extends Controller {

    public function __construct( Request $request ) {
        //  $this->middleware( 'auth' );
        parent::__construct();

        $ln = $request->segment( 1 );
        $this->ln = $ln;
    }

    /**
     * @var copoun_codes Repository
     */
    protected $copoun_codes;

    /**
     * Displays all metrics.
     *
     * @return \Illuminate\View\View
     */
    public function index( Coupon $zizpicCoupons , Request $request ) {

        $page_title = 'Coupons Management';
        $grid = $this->generateGrid( $page_title );
        $grid->setDataProvider(
                new EloquentDataProvider( Coupon::query() )
        );

        $grid->setColumns( [
                    (new FieldConfig )
                    ->setName( 'id' )
                    ->setLabel( 'ID' )
                    ->setSortable( true )
                    ->setSorting( Grid::SORT_ASC )
            ,
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
                    )
            ,
                    (new FieldConfig )
                    ->setName( 'exp_date' )
                    ->setLabel( 'Expiry' )
                    ->setSortable( true )
                    ->setCallback( function ($val) {
                        return $val;
                    } )
            ,
                    (new FieldConfig )
                    ->setName( 'used_limit' )
                    ->setLabel( 'Use Limit' )
            ,
                    (new FieldConfig )
                    ->setName( 'usage' )
                    ->setLabel( 'Usage' )
                    ->setCallback( function ($val) {
                        return $val;
                    } )
            ,
                    (new FieldConfig )
                    ->setName( 'amount_usd' )
                    ->setLabel( 'Amount usd' )
                    ->setSortable( true )
                    ->setCallback( function ($val) {
                        return $val;
                    } )
            ,
                    (new FieldConfig )
                    ->setName( 'amount_nis' )
                    ->setLabel( 'Amount nis' )
                    ->setSortable( true )
                    ->setCallback( function ($val) {
                        return $val;
                    } )
            ,
                    (new FieldConfig )
                    ->setName( 'package' )
                    ->setLabel( 'Package' )
                    ->setSortable( true )
                    ->setCallback( function ($val) {
                        return $val;
                    } )
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

                        $html = '<a class="pull-left" href="' . route( 'coupons.edit' , $attr->id ) . '" >' . $btn . '</a>';
                        $html .= '<a class="pull-left btn-default btn" href="' . route( 'coupons.show' , $attr->id ) . '" >view zizcode</a>';
                        return $html;
                    } )
        ] );
        $grid = new Grid( $grid );
        $grid = $grid->render();
        $routes = ['create' => 'coupons.create' ];
        return $this->view( 'packages::coupons.index' , compact( 'routes' , 'grid' , 'page_title' ) );
    }

    /**
     * Displays the form to create a metric.
     *
     * @return \Illuminate\View\View
     */
    public function create( Coupon $zizpicCoupons ) {

        $package = array( 'package-1' => 'Package-1' , 'package-3' => 'Package-3' , 'for_all_package' => 'For all Packages' );
        $page_title = 'Create Zizcode';
        return view( 'packages::coupons.create' , compact( 'zizpicCoupons' , 'page_title' , 'package' ) );
    }

    /**
     * Creates a metric.
     *
     * @param MetricRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store( ZizpicCouponsRequest $request , Coupon $zizpicCoupons ) {

        $zizpicCoupons->fill( Input::all() );
        $zizpicCoupons->save();
        $coupon_id = $zizpicCoupons->id;
        $total_coupon = Input::get( 'total_coupon' );
        $coupon_usesObj = Coupon::find( $coupon_id );
        $coupon_usesObj->usage = '0/' . $total_coupon;
        $coupon_usesObj->save();
        $i = 0;
        $helper = new Helper;

        for ( $i = 0; $i < $total_coupon; $i++ ) {
            $couponCodeObj = new CouponCode;
            $couponCodeObj->copoun_id = $coupon_id;
            $couponCodeObj->code = strtoupper( $helper->generateRandomString() );
            $couponCodeObj->save();
        }


        return Redirect::to( $this->ln . '/zizpic/coupons/' . $coupon_id )
                        ->with( 'flash_alert_notice' , 'Zizpic order coupons was successfully created !' )->with( 'alert_class' , 'alert-success alert-dismissable' );
    }

    /**
     * Displays the form for editing the specified metric.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function edit( Coupon $zizpicCoupons ) {
        $package = array( 'package-1' => 'Package-1' , 'package-3' => 'Package-3' , 'for_all_package' => 'For all Packages' );
        $page_action_title = 'Edit Zizcode';
        $page_title = 'Edit Coupon - ' . $zizpicCoupons->name;

        return view( 'packages::coupons.edit' , compact( 'zizpicCoupons' , 'page_title' , 'package' ) );
    }

    /**
     * Updates the specified metric.
     *
     * @param MetricRequest $request
     * @param int|string    $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update( ZizpicCouponsRequest $zizpicCouponsRequest , Coupon $zizpicCoupons ) {

        $zizpicCoupons->fill( Input::all() );
        $zizpicCoupons->save();
        return Redirect::to( $this->ln . '/zizpic/coupons' )
                        ->with( 'flash_alert_notice' , 'Zizpic order coupons was successfully updated !' )->with( 'alert_class' , 'alert-success alert-dismissable' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy( Coupon $coupon ) {

        Coupon::destroy( $coupon->id );
        return Redirect::to( $this->ln . '/zizpic/coupons' )
                        ->with( 'flash_alert_title' , 'OK' )->with( 'flash_alert_notice' , 'Coupons was successfully deleted!' )->with( 'alert_class' , 'alert-success alert-dismissable' );
    }

    public function show( Coupon $coupon ) {

        $query = (new CouponCode )
                ->newQuery()
                ->join( 'copouns' , 'copouns.id' , '=' , 'copoun_codes.copoun_id' )
                ->select( 'copouns.id' , 'copouns.package' , 'copoun_codes.code' , 'copouns.exp_date' , 'amount_usd' , 'amount_nis' )
                ->where( 'copouns.id' , $coupon->id );


        $page_title = 'Zizcode name : ' . $coupon->name;
        $grid = $this->generateGrid( $page_title );
        $grid->setDataProvider(
                new EloquentDataProvider( $query )
        );
        $grid->setColumns( [
                    (new FieldConfig )
                    ->setName( 'id' )
                    ->setLabel( 'Coupon ID' )
                    ->setSortable( true )
                    ->setSorting( Grid::SORT_ASC )
            ,
                    (new FieldConfig )
                    ->setName( 'exp_date' )
                    ->setLabel( 'Expiration Date' )
                    ->setSortable( true )
                    ->setSorting( Grid::SORT_ASC )
            ,
                    (new FieldConfig )
                    ->setName( 'package' )
                    ->setLabel( 'Package' )
                    ->setSortable( true )
                    ->setSorting( Grid::SORT_ASC )
            ,
                    (new FieldConfig )
                    ->setName( 'amount_usd' )
                    ->setLabel( 'Amount(USD)' )
            ,
                    (new FieldConfig )
                    ->setName( 'amount_nis' )
                    ->setLabel( 'Amount(NIS)' )
            ,
                    (new FieldConfig )
                    ->setName( 'code' )
                    ->setLabel( 'Zizcode ' )
                    ->setCallback( function ($val) {
                        return $val;
                    } )
                    ->setSortable( true )
                    ->addFilter(
                            (new FilterConfig )
                            ->setOperator( FilterConfig::OPERATOR_LIKE )
                    )
        ] );
        $grid = new Grid( $grid );
        $grid = $grid->render();
        return $this->view( 'packages::coupons.index' , compact( 'routes' , 'grid' , 'page_title' ) );
    }

}
