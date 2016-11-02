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
use Nayjest\Grids\SelectFilterConfig;

//use Inventory\Admin\Http\Requests\MetricRequest;

/**
 * Class MetricController
 */
class ZizpicTransactionController extends Controller {

    public function __construct( Request $request ) {
        //   $this->middleware( 'auth' );
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
    public function index( ZizpicOrder $zizpicOrders , Request $request ) {
        $page_title = 'Orders  Management';
        $grid = $this->generateGrid( $page_title , ['created_at' ] );
        $grid->setDataProvider(
                new EloquentDataProvider( ZizpicOrder::query()->orderBy( 'id' , 'desc' ) )
        );
        $random_string = md5( microtime() );


        $grid->setColumns( [


                    (new FieldConfig )
                    ->setName( 'full_name' )
                    ->setLabel( 'Name' )
                    ->setCallback( function ($val) {
                        return $val;
                    } )
                    ->setSortable( true )
                    ->addFilter(
                            (new FilterConfig )
                            ->setOperator( FilterConfig::OPERATOR_LIKE )
                    )
            , (new FieldConfig )
                    ->setName( 'package' )
                    ->setLabel( 'Package' )
                    ->setCallback( function ($val) {
                        return $val;
                    } )
                    ->addFilter(
                            (new SelectFilterConfig )
                            ->setName( 'package' )
                            ->setOptions( [ 'Package-1' => 'Package-1' , 'Package-3' => 'Package-3' ] )
                    ) ,
                    (new FieldConfig )
                    ->setName( 'email' )
                    ->setLabel( 'Email' )
                    ->setSortable( true )
                    ->setCallback( function ($val) {
                        return $val;
                    } )
                    ->addFilter(
                            (new FilterConfig )
                            ->setOperator( FilterConfig::OPERATOR_LIKE )
                    )
            ,
                    (new FieldConfig )
                    ->setName( 'phone_order' )
                    ->setLabel( 'Phone' )
                    ->setCallback( function ($val) {
                        return $val;
                    } )
                    ->addFilter(
                            (new FilterConfig )
                            ->setOperator( FilterConfig::OPERATOR_LIKE )
                    )
            ,
                    (new FieldConfig )
                    ->setName( 'order_price' )
                    ->setLabel( 'Price' )
            ,
                    (new FieldConfig )
                    ->setName( 'currency' )
                    ->setLabel( 'Currency' )
                    ->addFilter(
                            (new SelectFilterConfig )
                            ->setName( 'currency' )
                            ->setOptions( [ 'USD' => 'USD' , 'ILS' => 'ILS' ] )
                    )
            ,
                    (new FieldConfig )
                    ->setName( 'status' )
                    ->setLabel( 'Zizpic Status' )
                    ->setCallback( function ($val) {
                        return $val;
                    } )
                    ->addFilter(
                            (new SelectFilterConfig )
                            ->setName( 'status' )
                            ->setOptions( [ 'Pending payment' => 'Pending payment' , 'Payment complete' => 'Payment complete' , 'Graphics' => 'Graphics' , 'Shipped' => 'Shipped' ] )
                    ) ,
                    (new FieldConfig )
                    ->setName( 'payment_method' )
                    ->setLabel( 'Payment Method' )
                    ->setCallback( function ($val) {
                        return $val;
                    } )
                    ->addFilter(
                            (new SelectFilterConfig )
                            ->setName( 'payment_method' )
                            ->setOptions( [ 'paypal' => 'Paypal' , 'phone' => 'Phone' ] )
                    )
            ,
                    (new FieldConfig )
                    ->setName( 'created_at' )
                    ->setLabel( 'Date' )
                    ->setCallback( function ($val) {
                        return $val;
                    } )
                    ->addFilter(
                            (new FilterConfig )
                            ->setOperator( FilterConfig::OPERATOR_LIKE )
                    )
            ,
                    (new FieldConfig )
                    ->setName( 'actions' )
                    ->setLabel( 'Actions' )
                    ->setCallback( function ($val , $row ) {
                        $attr = $row->getSrc();
                        $btn = Form::button( '' , array( 'class' => 'no-style fa fa-pencil-square-o' ) );

                        $html = '<a class="pull-left btn-default btn" href="' . route( 'zizpictransactions.show' , $attr->id ) . '" >Show Transaction</a>';

                        return $html;
                    } )
        ] );



        $grid = new Grid( $grid );
        $grid = $grid->render();
        return $this->view( 'packages::coupons.index' , compact( 'routes' , 'grid' , 'page_title' ) );
    }

    /**
     * Displays the form to create a metric.
     *
     * @return \Illuminate\View\View
     */
    public function create( Coupon $zizpicCoupons ) {

        $package = array( 'package-1' => 'package-1' , 'package-3' => 'package-3' );
        $page_title = 'Create Coupon';
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
        $i = 0;
        $helper = new Helper;

        for ( $i = 0; $i < $total_coupon; $i++ ) {
            $couponCodeObj = new CouponCode;
            $couponCodeObj->copoun_id = $coupon_id;
            $couponCodeObj->code = strtoupper( $helper->generateRandomString() );
            $couponCodeObj->save();
        }


        return Redirect::to( $this->ln . '/zizpic/coupons' )
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
        $package = array( 'package-1' => 'package-1' , 'package-3' => 'package-3' );
        $page_action_title = 'Edit Coupon';
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
    public function update() {

    }

    public function changeOrderStatus( Request $request ) {
        if ( $request->ajax() ) {
            $status = Input::get( 'status' );
            $status_id = Input::get( 'id' );
            $statusObj = ZizpicOrder::find( $status_id );
            $statusObj->status = $status;
            $statusObj->save();
            return $status;
        }
        else {
            return false;
        }
    }

    /**
     * View uploaded image of the specified resource from transaction.
     *
     * @param  int $id
     * @return Response
     */
    public function getUploadedImage( $id = 0 ) {

        $page_title = "Image gallery";

        $uploaded_image = ZizpicOrder::where( 'id' , $id )->get( ['id' , 'package' , 'zizpic_1_image' , 'zizpic_2_image' , 'zizpic_3_image' ] );

        return view( 'packages::zizpic.gallery' , compact( 'page_title' , 'uploaded_image' ) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy() {

    }

    public function show( ZizpicOrder $zizpicOrder ) {

        $transaction = ZizpicOrder::where( 'id' , $zizpicOrder->id )->get();

        $page_title = 'Transactions';

        $results = [ ];
        $i = 0;
        foreach ( $transaction as $key => $trans ) {
            $data = $trans->data;
            if ( $data ) {
                $order = unserialize( $data );
                $results[ $i ][ 'transaction_id' ] = $order[ 'PAYMENTINFO_0_TRANSACTIONID' ];
                $results[ $i ][ 'amount' ] = $order[ 'PAYMENTINFO_0_AMT' ];
                $results[ $i ][ 'currency' ] = $order[ 'PAYMENTINFO_0_CURRENCYCODE' ];
                $results[ $i ][ 'status' ] = $order[ 'ACK' ];
                $results[ $i ][ 'date' ] = $order[ 'PAYMENTINFO_0_ORDERTIME' ];
                $results[ $i ][ 'id' ] = $zizpicOrder->id;
                $results[ $i ][ 'zizpic_status' ] = $zizpicOrder->status;
            }
            else {
                $results[ $i ][ 'transaction_id' ] = $zizpicOrder->id;
                $results[ $i ][ 'amount' ] = $zizpicOrder->order_price;
                $results[ $i ][ 'currency' ] = $zizpicOrder->currency;
                $results[ $i ][ 'status' ] = "N/A";
                $results[ $i ][ 'date' ] = $zizpicOrder->created_at;
                $results[ $i ][ 'id' ] = $zizpicOrder->id;
                $results[ $i ][ 'zizpic_status' ] = $zizpicOrder->status;
            }
            $i++;
        }
        $shiping_address = ZizpicOrder::where( 'id' , $zizpicOrder->id )->get()->toArray();

        return $this->view( 'packages::zizpic.orders' , compact( 'results' , 'page_title' , 'shiping_address' ) );
    }

}
