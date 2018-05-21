<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\TaskList;

class TaskRequest extends FormRequest
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
    public function rules(TaskList $list)
    {
        \Log::info($list);
       return [
            //'task_name' => 'required|min:1|max:31|unique:tasks,task_name',
            'task_name' => 'required|min:1|max:31|unique:tasks,task_name,' .intval($this->id). ',id,task_list_id,!'. $this->task_list_id
            //'task_name' => 'required|min:1|max:31|unique:tasks,task_name,'. $this->id. ',id,task_list_id,'. $this->input('list_id')
        ];
    }
}
