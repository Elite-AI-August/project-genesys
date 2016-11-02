<?php

namespace Inventory\Admin\Validators;

class UserValidator extends BaseValidator
{
    protected $createRules = [
        'first_name' => 'required|min:3',
        'last_name' => 'required|min:3',
        'username' => 'required|min:5',
        'email' => 'required|min:5|email',
        'password' => 'confirmed|required_with:activated|min:8',
        'password_confirmation' => 'required_with:activated|min:8',
        'activated' => 'integer|boolean',
    ];

    protected $updateRules = [
        'first_name' => 'required|min:3',
        'last_name' => 'required|min:3',
        'username' => 'required|min:5',
        'email' => 'required|min:5|email',
        'activated' => 'integer|boolean',
    ];

    public function passesCreate()
    {
        $this->setRules($this->createRules);

        $this->unique('username', 'users', 'username');
        $this->unique('email', 'users', 'email');

        return $this->passes();
    }

    public function passesUpdate($id)
    {
        $this->setRules($this->updateRules);

        $this->unique('username', 'users', 'username', $id);
        $this->unique('email', 'users', 'email', $id);

        return $this->passes();
    }
}
