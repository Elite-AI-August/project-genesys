<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateUserRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        if ( $users = $this->users ) {
            return [
                'name'     => 'required|max:255' ,
                'email'    => 'required|unique:users,email,' . $users->id . '|email|max:255' ,
                'password' => 'confirmed|max:255' ,
                'roles'    => 'required'
            ];
        }
    }

}
