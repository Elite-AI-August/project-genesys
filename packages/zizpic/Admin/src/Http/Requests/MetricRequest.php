<?php

namespace Inventory\Admin\Http\Requests;

use App\Http\Requests\Request;
use Input;

class MetricRequest extends Request {

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
                            'name'   => "required|max:250|unique:metrics,name" ,
                            'symbol' => "required|max:5|unique:metrics,symbol" ,
                        ];
                    }
                case 'PUT':
                case 'PATCH': {
                    if ( $metrics = $this->metrics ) {

                        return [
                            'name'   => "required|max:250|unique:metrics,name,$metrics->id" ,
                            'symbol' => "required|max:5|unique:metrics,symbol,$metrics->id" ,
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
