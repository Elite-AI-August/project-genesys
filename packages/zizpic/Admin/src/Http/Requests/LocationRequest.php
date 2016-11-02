<?php

namespace Inventory\Admin\Http\Requests;

use App\Http\Requests\Request;
use Input;

class LocationRequest extends Request {

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
                        'name' => "required|max:250" ,
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    if ( $locations = $this->locations ) {

                        return [
                            'name' => "required|max:250" ,
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
