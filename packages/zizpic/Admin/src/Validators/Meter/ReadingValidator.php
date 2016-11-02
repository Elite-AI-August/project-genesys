<?php

namespace Inventory\Admin\Validators\Meter;

use Inventory\Admin\Validators\BaseValidator;

/**
 * Class MeterReadingValidator.
 */
class ReadingValidator extends BaseValidator
{
    /**
     * The reading validation rules.
     *
     * @var array
     */
    protected $rules = [
        'reading' => 'required|positive',
        'comment' => 'max:250',
    ];
}
