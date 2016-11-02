<?php

namespace Inventory\Admin\Validators\Login;

use Inventory\Admin\Validators\BaseValidator;

/**
 * Class RequestResetValidator.
 */
class RequestResetValidator extends BaseValidator
{
    /**
     * The reset validation rules.
     *
     * @var array
     */
    protected $rules = [
        'email' => 'required',
    ];
}
