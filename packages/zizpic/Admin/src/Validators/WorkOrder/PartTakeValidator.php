<?php

namespace Inventory\Admin\Validators\WorkOrder;

use Inventory\Admin\Validators\BaseValidator;

/**
 * Class WorkOrderPartTakeValidator.
 */
class PartTakeValidator extends BaseValidator
{
    protected $rules = [
        'quantity' => 'required|positive|greater_than:0|enough_quantity',
    ];
}
