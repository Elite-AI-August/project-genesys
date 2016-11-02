<?php

namespace Zizpic\Admin\Http\Requests;

use App\Http\Requests\Request;
use Input;

class ZizpicOrderRequest extends Request {

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
                        'name'           => "required|max:250" ,
                        'email'          => 'email|required' ,
                        'zizpackage'     => "required" ,
                        'phone'          => "required" ,
                        'full_name'      => "required" ,
                        'address'        => "required" ,
                        'zizpic_1_image' => "mimes:jpeg,bmp,png,jpg" ,
                        'zizpic_2_image' => "mimes:jpeg,bmp,png,jpg" ,
                        'zizpic_3_image' => "mimes:jpeg,bmp,png,jpg" ,
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    if ( $zizpicOrder = $this->zizpicOrder ) {

                        return [
                            'name'            => "required|max:250" ,
                            'email'           => 'required|unique:users,email|max:255' ,
                            'zizpic_1_image'  => "required" ,
                            'zizpic_1_word_1' => "required" ,
                            'zizpic_1_word_2' => "required" ,
                            'zizpic_1_word_3' => "required" ,
                            'zizpackage'      => "required" ,
                            'phone'           => "required" ,
                            'full_name'       => "required" ,
                            'address'         => "required" ,
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
