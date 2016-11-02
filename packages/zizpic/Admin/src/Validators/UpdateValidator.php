<?php

namespace Inventory\Admin\Validators;

class UpdateValidator extends BaseValidator
{
    protected $rules = [
        'update_content' => 'required|max:1000',
    ];
}
