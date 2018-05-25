<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\TaskList;
use App\Task;

class TaskController extends Controller
{
    public function store(Request $request, TaskList $list){
        $validatedData = $request->validate([
            'task_name' => [ 
                'required',
                'min:1',
                'max:31',
                Rule::unique('tasks')->where(function($query) use($list){
                    return $query->where("task_list_id",$list->id);
                })
            ],
            'limit' => 'required|date',
            $messages = [
                'task_name.required' => '必須項目です'
            ],
        ]);
        $task = new Task;
        $task->task_name = $request->task_name;
        $task->limit = $request->limit;
        echo $list;
        $list->tasks()->save($task);
        $list->touch();
  
        return redirect()
        ->action('TaskListController@show', $list)
        ->with('message', '新しくToDoを追加しました');

    }

    public function state(Request $request,TaskList $list){
        $task = Task::find($request->done);
        $task->done = !$task->done;
        $list->tasks()->save($task);

        return redirect()
        ->action('TaskListController@show', $list);

    }

    public function destroy(TaskList $list){
        $list->tasks()->where('done', true)->delete();
        
        return redirect()
        ->action('TaskListController@show', $list)
        ->with('message', 'ToDoを削除しました');
    }
}
