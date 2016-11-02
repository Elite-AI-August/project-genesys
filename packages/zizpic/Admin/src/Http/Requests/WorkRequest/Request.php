<?php

namespace Inventory\Admin\Http\Requests\WorkRequest;

use Inventory\Admin\Http\Requests\Request as BaseRequest;

class Request extends BaseRequest
{
    /**
     * The work request validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subject' => 'required|min:10',
            'description' => 'required|min:10',
            'best_time' => 'required|min:4',
        ];
    }

    /**
     * Allows all users to create work requests.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
