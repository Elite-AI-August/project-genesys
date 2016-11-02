<?php

namespace Inventory\Admin\Http\Requests;

class CategoryRequest extends Request
{
    /**
     * The category validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:50'
        ];
    }

    /**
     * Allows all users to create categories.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
