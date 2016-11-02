<?php

namespace Inventory\Admin\Http\Requests\WorkOrder;

use Inventory\Admin\Http\Requests\Request;

class ReportRequest extends Request
{
    /**
     * The report validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => 'required|integer',
            'description' => 'required|min:5|unique_report',
        ];
    }

    /**
     * Allows all users to create a report.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
