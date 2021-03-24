<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProjectResources extends FormRequest
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
            'project_resource.*.resource' => 'required_with:project_resource.*.resource,project_resource.*.consumption_quantity|nullable|integer',
            'project_resource.*.consumption_quantity' => 'required_with:project_resource.*.resource,project_resource.*.consumption_quantity|nullable|integer',

            'project_resource' => 
                function ($attribute, $value, $fail) {
                    if ($value[0]["resource"] == "") {
                        return $fail("利用資材1は入力してください");
                    }
                }
        ];
    }
}
