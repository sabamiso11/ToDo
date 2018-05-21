<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\TaskList;
use App\Task;

class TaskController extends Controller
{
    public function store(TaskRequest $request, TaskList $list){
        $task = new Task;
        $task->task_name = $request->task_name;
        $task->limit = $request->limit;
        $list->tasks()->save($task);
        $list->touch();
  
        return redirect()
        ->action('TaskListController@show', $list)
        ->with('message', '新しく追加しました');

    }

    public function state(Request $request,TaskList $list){
        $task = Task::find($request->done);
        $task->done = !$task->done;
        $list->tasks()->save($task);

/*        $task->done = !$request;
        $task->save(); */

        return redirect()
        ->action('TaskListController@show', $list);


    }
}
