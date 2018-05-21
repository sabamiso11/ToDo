<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
    public function rules()
    {
/*        Validator::make($data, [
            'task_name' =>[
                Rule::unique('tasks')->where(function ($query){
                    return $query->where('task_list_id', $data['task_list_id']);
                })
            ],
        ]->validate();*/

       return [
            //'task_name' => 'required|min:1|max:31|unique:tasks,task_name',
            //'task_name' => 'required|min:1|max:31|unique:tasks,task_name'. $this->id. ',id,task_list_id,'. $this->input('list_id')
            /*Validator::make($data, [
                'task_name' =>[
                    Rule::unique('tasks')->where(function ($query){
                        return $query->where('task_list_id', $data['task_list_id']);
                    })
                ],
            ]->validate();*/
            'task_name' => 'required|min:1|max:31|unique:tasks,task_name,'. $this->id. ',id,task_list_id,'. $this->input('list_id') 
        ];
    }
}
