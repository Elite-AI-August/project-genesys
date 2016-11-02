<?php

namespace Inventory\Admin\Http\Requests\Config;

use Inventory\Admin\Http\Requests\Request;

class MailRequest extends Request
{
    /**
     * The mail configuration validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mail_driver' => 'required',
            'host_ip' => 'required|ip',
            'host_port' => 'required|integer',
            'smtp_username' => 'required_with:smtp_password',
            'smtp_password' => '',
        ];
    }

    /**
     * Allows all users to modify the mail settings.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
