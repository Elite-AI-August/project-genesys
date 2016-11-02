<?php

namespace Zizpic\Admin\Http\Requests;

use App\Http\Requests\Request;
use Input;

class ZizpicCouponsRequest extends Request {

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
                        'name'         => "required|max:250" ,
                        'exp_date'     => 'required|date' ,
                        'used_limit'   => "required" ,
                        'amount_usd'   => "required" ,
                        'amount_nis'   => "required" ,
                        'package'      => "required" ,
                        'total_coupon' => "required|integer"
                    ];
                }
            case 'PUT':
            case 'PATCH': {

                    return [
                        'name'       => 'required' ,
                        'exp_date'   => 'required|date' ,
                        'used_limit' => "required" ,
                        'amount_usd' => "required" ,
                        'amount_nis' => "required" ,
                        'package'    => "required" ,
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
