<?php

namespace Inventory\Admin\Validators\WorkOrder;

use Inventory\Admin\Validators\BaseValidator;

class SessionValidator extends BaseValidator
{
    /**
     * The work order session
     * validation rules.
     *
     * @var array
     */
    protected $rules = [
        'work_order_id' => 'required|integer'
    ];
}
