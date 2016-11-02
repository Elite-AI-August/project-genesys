<?php

namespace Inventory\Admin\Http\Requests;

use App\Http\Requests\Request;
use Input;

class InventoryTransactionRequest extends Request {

    /**
     * The metric validation rules.
     *
     * @return array
     */
    public function rules() {

        switch ( $this->method() ) {
            case 'GET':
            case 'DELETE': {
                    return [ ];
                }
            case 'POST': {
                    return [
                        'state'       => "required" ,
                        'description' => "required"
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'state'       => "required" ,
                        'description' => "required"
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
