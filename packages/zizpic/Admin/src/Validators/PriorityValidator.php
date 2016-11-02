<?php

namespace Inventory\Admin\Validators;

/**
 * Class PriorityValidator.
 */
class PriorityValidator extends BaseValidator
{
    protected $rules = [
        'name' => 'required|max:250',
        'color' => 'required|max:250',
    ];
}
