<?php

namespace Inventory\Admin\Http\Requests\WorkOrder;

use Inventory\Admin\Http\Requests\Request as BaseRequest;

class Request extends BaseRequest
{
    /**
     * The work order validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
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

    /**
     * Authorizes all users to create a work order.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
