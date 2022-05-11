<?php

namespace App\Http\Controllers\User;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(){
        $tasks=auth()->user()->tasks;
        //$userTasks=User::with('tasks')->get();
        //dd($userTasks);
        return view('user.tasks.index',compact('tasks'));
    }
}
