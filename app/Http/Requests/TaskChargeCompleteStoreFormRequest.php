<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Task_charge;
use Illuminate\Support\Facades\Auth;

class TaskChargeCompleteStoreFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $task_charge_id = $this->route()->parameter('task_charge_id');
        $task_charge = Task_charge::findOrFail($task_charge_id);
        $auth_user = Auth::user();
        if($task_charge->user->id == $auth_user->id)
        {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'report' => 'required|string|max:500',
        ];
    }
}
