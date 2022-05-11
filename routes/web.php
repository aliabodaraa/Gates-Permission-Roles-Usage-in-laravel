<?php

use Illuminate\Support\Facades\Route;
USE Illuminate\Support\Facades\Gate;//important call
use  App\Models\User;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(Gate::allows('tasks_create',"App\\Models\Task")){
        $message_Authrizing="Hello Admin You can Create/Edit/delit Any Task for any User";
        return view('welcome',compact('message_Authrizing'));
    }
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');



Route::group(['middleware'=>'auth'],function(){
    Route::group(['prefix'=>'admin',//url
                'middleware'=>'isAdmin',
                'as'=>'admin.'/*like ->name('admin.')*/],function(){
        Route::get('/',[\App\Http\Controllers\Admin\TaskController::class,'index'])->name('tasks');
        Route::get('tasks',[\App\Http\Controllers\Admin\TaskController::class,'index'])->name('tasks.index');
    });
    Route::group(['prefix'=>'user',
                  'as'=>'user.'],function(){
        Route::get('/',[\App\Http\Controllers\User\TaskController::class,'index'])->name('tasks');
        Route::get('/tasks',[\App\Http\Controllers\User\TaskController::class,'index'])->name('tasks.index');
        Route::get('/{id}',function($id){//protection via middle ware user cant show while admin can
          $user=User::findOrFail($id);
          print_r($user->name." ");
          print_r($user->email." ");
          print_r($user->is_admin);
        })->middleware('isAdmin');//user can't show in contrast admin can
    });
    Route::get('/tryGate',function(){//protection via Gates
        //Gate::allows('tasks_delete');//all the user can access
        Gate::authorize('tasks_delete');//if will allow for the user the implement the condition for current user that have is_admin=1 -- with Exception 403-THIS ACTION IS UNAUTHORIZED.
        echo "<h1>you are authorized access to here<h1>";
    });
    Route::get('/tryPolicy',function(){//protection via Policis(you should pass  Model as the second parameter)
        //Gate::allows('tasks_delete',\App\Models\Task::class);//all the user can access
        Gate::authorize('create',\App\Models\Task::class);//if will allow for the user the implement the condition for current user that have is_admin=2(fo to the create policy(TaskPolicy)) -- with Exception 403-THIS ACTION IS UNAUTHORIZED.
        echo "<h1>you are authorized access to here<h1>";
    });
    //Route::view('/edit','admin')
});



require __DIR__.'/auth.php';
