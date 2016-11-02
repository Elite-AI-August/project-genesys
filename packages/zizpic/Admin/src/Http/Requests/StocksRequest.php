<?php

namespace Inventory\Admin\Http\Requests;

use App\Http\Requests\Request;
use Input;

class StocksRequest extends Request {

    /**
     * The metric validation rules.
     *
     * @return array
     */
    public function rules() {
        //if ( $metrics = $this->metrics ) {
        switch ( $this->method() ) {
            case 'GET':
            case 'DELETE': {
                    return [ ];
                }
            case 'POST': {
                    return [
                        'location_id' => "required" ,
                        'quantity'    => "required|numeric" ,
                        'serial_no'   => "unique:inventory_stocks,serial_no,null,id,inventory_id," . Input::get( 'inventory_id' )
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                    ];
                }
            default:break;
        }
        //}
    }

    /**
     * The
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

}
