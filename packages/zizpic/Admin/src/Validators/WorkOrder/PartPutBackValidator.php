<?php

namespace Inventory\Admin\Validators\WorkOrder;

use Inventory\Admin\Validators\BaseValidator;

/**
 * Class PartPutBackValidator.
*/
class PartPutBackValidator extends BaseValidator
{
    protected $rules = [
        'quantity' => 'required|positive|greater_than:0',
    ];
}
