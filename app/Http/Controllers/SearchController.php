<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\TaskList;

class SearchController extends Controller
{
    public function index(Request $request){
        $keyword = $request->input('keyword');

/*        $lists = TaskList::with('tasks');
    
        if(!empty($keyword)){
            $lists = TaskList::withCount([
                'tasks' => function ($query) {
                  $query->where('task_name', 'like', '%'. input('keyword') .'%')
                  ->orderBy('updated_at', 'desc');
                }
            ])->orderBy('updated_at', 'desc')->get();    
        }
*/
        $query = TaskList::query();
        
        $query->join('tasks', function ($query) use ($request){
            $query->on('task_lists.id', '=', 'tasks.task_list_id');
        });

        if(!empty($keyword)){
            $query->where('task_name', 'like', '%'. $keyword .'%');
        }
/*        if(!empty($keyword)){
            $query->where('task_name', 'like', '%'. $keyword .'%');
        }*/

        $data = $query->get();
        return view('list.search', ['data' => $data, 'keyword' => $keyword, 'message' => 'ユーザーリスト']);
    }
}
