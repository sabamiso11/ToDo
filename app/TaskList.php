<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskList extends Model
{
    protected $fillable = ['list_name'];

    public function tasks(){
        return $this->hasMany('App\Task');
    }
}
