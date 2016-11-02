<?php

namespace Inventory\Admin\Validators;

/**
 * Class NoteValidator.
 */
class NoteValidator extends BaseValidator
{
    protected $rules = [
        'content' => 'required|min:5',
    ];
}
