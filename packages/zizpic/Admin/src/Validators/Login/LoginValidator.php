<?php

namespace Inventory\Admin\Validators\Login;

use Inventory\Admin\Validators\BaseValidator;

/**
 * Class AuthLoginValidator.
 */
class LoginValidator extends BaseValidator
{
    /**
     * The login validation rules.
     *
     * @var array
     */
    protected $rules = [
        'email' => 'required',
        'password' => 'required',
    ];
}
