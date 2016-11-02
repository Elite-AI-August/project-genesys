<?php

namespace Inventory\Admin\Http\Requests\Asset;

use Inventory\Admin\Http\Requests\Request as BaseRequest;

class Request extends BaseRequest
{
    /**
     * The asset validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category' => 'required',
            'category_id' => 'integer|min:1',
            'location' => 'required',
            'location_id' => 'integer|min:1',
            'name' => 'required|min:3|max:250',
            'description' => 'required|max:1500',
            'condition' => 'required|integer|max:5|min:1',
            'size' => 'max:30',
            'weight' => 'max:30',
            'vendor' => 'max:100',
            'make' => 'max:100',
            'model' => 'max:100',
            'serial' => 'max:200',
            'price' => 'max:20'
        ];
    }

    /**
     * Allows all users to create an asset.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
