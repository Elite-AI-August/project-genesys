<?php

namespace Inventory\Admin\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Input;

class CustomFieldRequest extends Request {

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
                        'fieldable'  => "required" ,
                        'field_name' => "required|max:250" ,
                        'field_type' => "required" ,
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'fieldable'  => "required" ,
                        'field_name' => "required|max:250" ,
                        'field_type' => "required" ,
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
