<?php

namespace Inventory\Admin\Http\Requests\Config;

use Inventory\Admin\Http\Requests\Request;

class SiteRequest extends Request
{
    /**
     * The site configuration rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:30',
            'admin_title' => 'required|max:30',
            'work_order_calendar' => 'max:100',
            'asset_calendar' => 'max:100',
            'inventory_calendar' => 'max:100',
        ];
    }

    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
