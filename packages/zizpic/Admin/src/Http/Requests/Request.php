<?php

namespace Inventory\Admin\Http\Requests;

use Stevebauman\Purify\Facades\Purify;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /**
     * Cleans a string or array of HTML input.
     *
     * @param string|array $input
     *
     * @return string|array
     */
    public function clean($input)
    {
        return Purify::clean($input);
    }
}
