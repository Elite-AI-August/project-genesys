<?php

namespace Inventory\Admin\Validators\Event;

use Inventory\Admin\Validators\BaseValidator;

/**
 * Class EventValidator.
 */
class EventValidator extends BaseValidator
{
    /**
     * The event validation rules.
     *
     * @var array
     */
    protected $rules = [
        'title' => 'required|min:5|max:250',
        'description' => 'min:5|max:2000',
        'start_date' => 'required|max:25',
        'end_date' => 'required|required_with:end_time|max:25',
        'start_time' => 'required_without:all_day|required_with:end_time|max:25',
        'end_time' => 'required_without:all_day|required_with:start_time|max:25',
        'recur_frequency' => 'required_with:recur_limit,recur_days,recur_months',
        'recur_limit' => 'integer|max:2000',
        'recur_days' => '',
        'recur_months' => '',
        'all_day' => '',
    ];

    /**
     * {@inheritdoc}
     */
    public function passes()
    {
        /*
         * Validate if the end date is before the
         * start date only if all day is not checked
         */
        $this->validator()->sometimes('start_date', 'before:end_date', function ($input) {

            if ($input->all_day) {
                return false;
            }

            return true;
        });

        return parent::passes();
    }
}
