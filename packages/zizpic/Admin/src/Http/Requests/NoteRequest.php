<?php

namespace Inventory\Admin\Http\Requests;

class NoteRequest extends Request
{
    /**
     * The note validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'required|min:5',
        ];
    }

    /**
     * Allows all users to create notes.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
