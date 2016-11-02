<?php

namespace Inventory\Admin\Validators\WorkOrder;

use Inventory\Admin\Validators\BaseValidator;

/**
 * Class ReportValidator.
 */
class ReportValidator extends BaseValidator
{
    protected $rules = [
        'status' => 'required|integer',
        'description' => 'required|min:5|unique_report',
    ];
}
