<?php

use Illuminate\Support\Facades\Route;
use App\Models\Task;
use Illuminate\Http\Request;

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
//TODO: убрать очистку кеша после разработки базы
Artisan::call('view:clear');



Route::get('/', function () {
    $tasks = Task::orderBy('created_at', 'ASC')->get();

    return view('tasks', [
        'tasks' => $tasks
    ]);
});
Route::get('/task/{id}', function ($id) {



    $task = Task::find($id);
    return view('task', [
        'task' => $task
    ]);
});
/**
 * Добавить новую задачу
 */
Route::post('/task', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
    ]);

    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }
    $task = new Task;
    $task->name = $request->name;
    $task->description = $request->description;
    $task->save();

    return redirect('/');
    // Создание задачи...
});

/**
 * Удалить задачу
 */
Route::delete('/task/{task}', function (Task $task) {
    $task->delete();

    return redirect('/');
});


