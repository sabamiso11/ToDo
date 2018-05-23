<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\TaskList;

class SearchController extends Controller
{
    public function index(){

        return view('list.search');
    }
}
