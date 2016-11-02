<?php

namespace Inventory\Admin\Validators;

/**
 * Class AssignmentValidator.
 */
class AssignmentValidator extends BaseValidator
{
    protected $rules = [
            'users' => 'required|user_assignment',
    ];
}
