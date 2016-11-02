<?php

namespace Inventory\Admin\Http\Requests;

class CategoryMoveRequest extends Request
{
    /**
     * The category move validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'parent_id' => 'required'
        ];
    }

    /**
     * Allows all users to move categories.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
