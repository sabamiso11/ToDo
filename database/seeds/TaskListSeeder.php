<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\TaskList;

class TaskListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i<=3;$i++){
		$list = new TaskList;
		$list->list_name = 'タスクリスト'. $i;
		$list->save();		
	}
    }
}
