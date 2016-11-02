<?php

namespace Inventory\Admin\Validators;

/**
 * Class GroupValidator.
 */
class GroupValidator extends BaseValidator
{
    protected $rules = [
        'name' => 'required|min:3|max:250',
    ];
}
