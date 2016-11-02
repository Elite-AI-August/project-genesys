<?php

namespace Inventory\Admin\Http\Requests\Auth;

use Inventory\Admin\Http\Requests\Request;

class RegisterRequest extends Request
{
    /**
     * The registration validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'email' => 'required|email|max:250',
            'password' => 'required|confirmed|max:250',
            'password_confirmation' => 'required|max:250',
            'g-recaptcha-response' => 'required|captcha',
        ];
    }

    /**
     * Allows all users to register.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
