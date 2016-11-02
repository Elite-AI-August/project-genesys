<?php

namespace Inventory\Admin\Validators;

/**
 * Class WorkOrderValidator.
 */
class WorkOrderValidator extends BaseValidator
{
    protected $rules = [
        'category' => '',
        'category_id' => 'integer|min:1',

        'location' => '',
        'location_id' => 'integer|min:1',

        'status' => 'required|integer',
        'priority' => 'required|integer',

        'subject' => 'required|min:5|max:250',
        'description' => 'min:5',

        'started_at_date' => '',
        'started_at_time' => '',

        'completed_at_date' => '',
        'completed_at_time' => '',
    ];
}
