<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskCharges extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'task_charge.*.task_name' => 'required_with:task_charge.*.user,task_charge.*.outline,task_charge.*.order|nullable|string',
            'task_charge.*.user' => 'required_with:task_charge.*.task_name,task_charge.*.outline,task_charge.*.order|nullable|integer',
            'task_charge.*.outline' => 'required_with:task_charge.*.task_name,task_charge.*.user,task_charge.*.order|nullable|string',
            'task_charge.*.order' => 'required_with:task_charge.*.task_name,task_charge.*.user,task_charge.*.outline|nullable|integer',

            'task_charge' =>
                function ($attribute, $value, $fail) {
                    if ($value[0]["task_name"] == "") {
                        return $fail("1:担当項目は入力してください");
                    }
                }
        ];
    }
}
