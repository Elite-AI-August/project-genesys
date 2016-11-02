<?php

namespace Inventory\Admin\Http\Requests\Event;

use Inventory\Admin\Http\Requests\Request as BaseRequest;

class Request extends BaseRequest
{
    /**
     * The event validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
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
    }

    /**
     * Allows all users to create an event.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}