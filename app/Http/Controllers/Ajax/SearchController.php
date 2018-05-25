<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function search(Request $request){
        $keyword = $request->input('keyword');
        $taskquery = \App\TaskList::join('tasks', function ($taskquery) use ($request){
            $taskquery->on('task_lists.id', '=', 'tasks.task_list_id');
        });
        $taskdata = $taskquery->where('task_name', 'like', '%'. $keyword .'%')->orderBy('tasks.created_at', 'asc')->get();
        $listdata = \App\TaskList::where('list_name', 'like', '%'. $keyword .'%')->orderBy('created_at', 'asc')->get();

        return array($taskdata, $listdata);
    }
}
