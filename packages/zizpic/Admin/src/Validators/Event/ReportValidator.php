<?php

namespace Inventory\Admin\Validators\Event;

use Inventory\Admin\Validators\BaseValidator;

/**
 * Class ReportValidator.
 */
class ReportValidator extends BaseValidator
{
    /**
     * The report validation rules.
     *
     * @var array
     */
    protected $rules = [
        'description' => 'required|min:10',
    ];
}
