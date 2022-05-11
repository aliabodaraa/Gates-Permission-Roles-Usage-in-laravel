<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(){
        $tasks=Task::with('toUser')->get();//pass on all tasks and find $task->toUser(); for each one
        //dd( $tasks);
        //dd(auth()->user();
        return view('admin.tasks.index',compact('tasks'));
    }
}
