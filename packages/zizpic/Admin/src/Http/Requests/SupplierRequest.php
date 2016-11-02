<?php

namespace Inventory\Admin\Http\Requests;

use App\Http\Requests\Request;
use Input;

class SupplierRequest extends Request {

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

                                'name' => "required",
                                'address' => "max:500",
                                'postal_code' => "required|numeric",
                                'zip_code' => "numeric",
                                'city' => "required|max:100",
                                'country' => "required|max:100",
                                'contact_title' => "max:255",
                                'contact_name' => "max:255",
                                'contact_email' => "required|email",
                                'contact_phone' => "numeric",
                                'contact_fax' => "numeric",
                        ];
                    }
                case 'PUT':
                case 'PATCH': {
                    if ( $suppliers = $this->suppliers ) {

                        return [
                            
                                'name' => "required",
                                'address' => "max:500",
                                'postal_code' => "required|numeric",
                                'zip_code' => "numeric",
                                'city' => "required|max:100",
                                'country' => "required|max:100",
                                'contact_title' => "max:255",
                                'contact_name' => "max:255",
                                'contact_email' => "required|email",
                                'contact_phone' => "numeric",
                                'contact_fax' => "numeric",
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
