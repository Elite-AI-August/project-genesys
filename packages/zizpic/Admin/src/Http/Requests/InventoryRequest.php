<?php

namespace Inventory\Admin\Http\Requests;

use App\Http\Requests\Request;
use Input;

class InventoryRequest extends Request {

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
                            'name'   => "required|max:250" ,
                            'category_id' => "required" ,
                           
                        ];
                    }
                case 'PUT':
                case 'PATCH': { 
                    if ( $inventories = $this->inventories ) {
                        return [
                            'name'   => "required|max:250" ,
                            'category_id' => "required" ,
                            
                        ];
                    }
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
