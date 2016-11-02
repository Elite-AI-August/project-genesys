<?php

namespace Inventory\Admin\Validators;

/**
 * Class AccessCheckValidator.
 */
class AccessCheckValidator extends BaseValidator
{
    protected $rules = [
        'permission' => 'required',
    ];
}
