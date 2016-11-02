<?php

namespace Inventory\Admin\Validators;

/**
 * Class InventoryValidator.
 */
class InventoryValidator extends BaseValidator
{
    protected $rules = [
        'name' => 'required|max:250',
        'description' => 'max:1000',
        'category' => 'required',
        'category_id' => 'min:1|integer',
        'metric' => 'required|integer',
    ];
}
