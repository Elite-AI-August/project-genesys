<?php

namespace Inventory\Admin\Validators;

/**
 * Class CategoryValidator.
 */
class CategoryValidator extends BaseValidator
{
    protected $rules = [
        'name' => 'required|max:250',
    ];
}
