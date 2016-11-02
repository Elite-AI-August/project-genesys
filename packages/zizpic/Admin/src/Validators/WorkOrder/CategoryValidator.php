<?php

namespace Inventory\Admin\Validators\WorkOrder;

use Inventory\Admin\Validators\BaseValidator;

/**
 * Class CategoryValidator.
 */
class CategoryValidator extends BaseValidator
{
    protected $rules = [
        'name' => 'required|max:250',
    ];
}
