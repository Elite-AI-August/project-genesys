<?php

namespace Inventory\Admin\Validators\Inventory;

use Inventory\Admin\Validators\BaseValidator;

/**
 * Class InventoryStockValidator.
 */
class StockValidator extends BaseValidator
{
    /**
     * The stock validation rules.
     *
     * @var array
     */
    protected $rules = [
        'location_id' => 'integer|min:1|stock_location',
        'location' => 'required',
        'quantity' => 'required|positive',
        'reason' => 'max:250',
        'cost' => 'positive',
    ];
}
