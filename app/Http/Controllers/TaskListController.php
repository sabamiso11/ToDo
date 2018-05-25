<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests\TaskListRequest;
use App\TaskList;

class TaskListController extends Controller
{
    public function index(){
      //↓select `task_lists`.`id`, `list_name`, (select count(*) from tasks where task_lists.id = tasks.task_list_id) as tasks_count, (select count(*) from tasks where task_lists.id = tasks.task_list_id and done = 1) as done_count, (select tasks.limit from tasks where task_lists.id = tasks.task_list_id and done = 0 order by tasks.limit asc limit 1) as dead_line from `task_lists` left join (select task_list_id, MAX(created_at) as maxcreate from tasks group by task_list_id ) as tasks on `task_lists`.`id` = `tasks`.`task_list_id` order by maxcreate desc
      $lists = TaskList::select(
        'task_lists.id',
        'list_name',
        DB::raw('(select count(*) from tasks where task_lists.id = tasks.task_list_id) as tasks_count'),
        DB::raw('(select count(*) from tasks where task_lists.id = tasks.task_list_id and done = 1) as done_count'),
        DB::raw('(select tasks.limit from tasks where task_lists.id = tasks.task_list_id and done = 0 order by tasks.limit asc limit 1) as dead_line')
      )->leftJoin(DB::raw('(select task_list_id, MAX(created_at) as maxcreate from tasks group by task_list_id ) as tasks'), function ($tasklistquery){
        $tasklistquery->on('task_lists.id', '=', 'tasks.task_list_id');
      })->orderByRaw('maxcreate desc')->get();

      return view('list.index', ['lists' => $lists]);
    }

    public function create(){
      return view('list.create');
    }

    public function store(TaskListRequest $request){
      $list = new TaskList;
      $list->list_name = $request->list_name;
      $list->save();

      return redirect('/')->with('message', '新しくToDoリスト追加しました');
    }

    public function show(TaskList $list){
      $donecheck = $list->tasks->where('done', true)->count();
      return view('list.show', ['list' => $list, 'donecheck' => $donecheck]);
    }

    public function destroy(TaskList $list){
      $list->delete();
      return redirect('/')->with('message', 'ToDoリスト削除しました');
  }
}
