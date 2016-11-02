<?php

namespace Inventory\Admin\Http\Requests;

class UpdateRequest extends Request
{
    /**
     * The update validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'update_content' => 'required|max:1000',
        ];
    }

    /**
     * Allows all users to create updates.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
