<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Input;

class RoleRequest extends Request {

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
                        'name'        => "required|max:250" ,
                        'slug'        => "required|max:250|unique:roles,slug" ,
                        'description' => "max:250" ,
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    if ( $roles = $this->roles ) {

                        return [
                            'slug'        => "required|max:250|unique:roles,slug,$roles->id" ,
                            'name'        => "required|max:250" ,
                            'description' => "max:250" ,
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
