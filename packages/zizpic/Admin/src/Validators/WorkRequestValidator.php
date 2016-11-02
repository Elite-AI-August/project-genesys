<?php

namespace Inventory\Admin\Validators;

/**
 * Class WorkRequestValidator.
 */
class WorkRequestValidator extends BaseValidator
{
    protected $rules = [
        'subject' => 'required|min:10',
        'description' => 'required|min:10',
        'best_time' => 'min:4',
    ];
}
