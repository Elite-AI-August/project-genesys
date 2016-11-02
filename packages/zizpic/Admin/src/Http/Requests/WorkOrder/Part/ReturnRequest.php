<?php

namespace Inventory\Admin\Http\Requests\WorkOrder\Part;

use Inventory\Admin\Http\Requests\Request as BaseRequest;

class ReturnRequest extends BaseRequest
{
    /**
     * The stock request validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'quantity' => 'required|positive'
        ];
    }

    /**
     * Allows all users to attach stock to work orders.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
