<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\TaskListRequest;
use App\TaskList;

class TaskListController extends Controller
{
    public function index(){
      $lists = TaskList::all();
      return view('list.index', ['lists' => $lists]);
    }

    public function create(){
      return view('list.create');
    }

    public function store(TaskListRequest $request){
      $list = new TaskList;
      $list->list_name = $request->list_name;
      $list->save();

      return redirect('/')->with('message', '新しく追加しました');
    }

    public function show(TaskList $list){
      //$list = TaskList::findOrFail($id);
      return view('list.show', ['list' => $list]);
    }
}
