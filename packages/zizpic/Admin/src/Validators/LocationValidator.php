<?php

namespace Inventory\Admin\Validators;

/**
 * Class LocationValidator.
 */
class LocationValidator extends BaseValidator
{
    protected $rules = [
        'name' => 'required|max:250',
    ];
}
