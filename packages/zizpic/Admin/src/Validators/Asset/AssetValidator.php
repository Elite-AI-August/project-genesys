<?php

namespace Inventory\Admin\Validators\Asset;

use Inventory\Admin\Validators\BaseValidator;

class AssetValidator extends BaseValidator
{
    /**
     * The asset validation rules.
     *
     * @var array
     */
    protected $rules = [
        'name' => 'required|min:3|max:250',
        'condition' => 'required|integer|max:5|min:1',
        'category' => 'required',
        'category_id' => 'integer|min:1',
        'location' => 'required',
        'location_id' => 'integer|min:1',
    ];
}
