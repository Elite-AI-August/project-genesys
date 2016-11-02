<?php

namespace Inventory\Admin\Http\Requests\WorkOrder;

use Inventory\Admin\Http\Requests\Request as BaseRequest;

class PriorityRequest extends BaseRequest
{
    /**
     * The priority validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:250',
            'color' => 'required|max:20',
        ];
    }

    /**
     * Allows all users to create work order priorities.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
