<?php

namespace Inventory\Admin\Http\Requests\Meter;

use Inventory\Admin\Http\Requests\Request as BaseRequest;

class Request extends BaseRequest
{
    /**
     * The meter validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'metric' => 'required|integer',
            'name' => 'required|max:250',
            'reading' => 'positive',
            'comment' => 'max:250',
        ];
    }

    /**
     * Allows all users to create a meter.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
