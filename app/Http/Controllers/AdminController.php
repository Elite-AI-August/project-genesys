<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Redirect;
use Menu;
use App\Helpers\Helper as Helper;
use Inventory\Admin\Models\InventoryBulkTransaction;

class AdminController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {

        return Redirect::to( route( 'admin.dashboard' ) );
    }

    public function dashboard() {
        if ( !Auth::check() ) {
            return redirect::to( '/login' );
        }

        /* $query = (new \Inventory\Admin\Models\InventoryMoveLocation() )
          ->newQuery()
          ->groupBy( 'bulk_id' )->get();
          $transaction_count = count( $query ); */
        $transaction_count = 0;
        return view( 'admin.index' , compact( 'transaction_count









        ' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //
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
    public function edit( $id ) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update( $id ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy( $id ) {
        //
    }

}
