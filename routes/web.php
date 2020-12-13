<?php

use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); // ez lehet nem is kell lol

// Felhasználói dolgok
Route::get('/user/{username}', [App\Http\Controllers\ProfilesController::class, 'index']);
Route::get('/user/{username}/edit', [App\Http\Controllers\ProfilesController::class, 'edit']);
Route::patch('/user/{username}', [App\Http\Controllers\ProfilesController::class, 'update']);
Route::post('/user/{id}/setCurrentBadge', [App\Http\Controllers\ProfilesController::class, 'setCurrentBadge']);

// Feladatok
Route::get('/tasks', [App\Http\Controllers\TasksController::class, 'taskList']);
Route::get('/tasks/create', [App\Http\Controllers\TasksController::class, 'taskCreate']);
Route::get('/tasks/{page}', [App\Http\Controllers\TasksController::class, 'taskCreate']);
Route::patch('/tasks', [App\Http\Controllers\TasksController::class, 'taskUpload']);

// Ranglista
Route::redirect('/leaderboard', '/leaderboard/level');
Route::get('/leaderboard/level', [App\Http\Controllers\LeaderboardController::class, 'level']);
Route::get('/leaderboard/solved', [App\Http\Controllers\LeaderboardController::class, 'solved']);
Route::get('/leaderboard/sent', [App\Http\Controllers\LeaderboardController::class, 'sent']);

// Feladat
Route::get('/task/{id}', [App\Http\Controllers\TaskController::class, 'index']);
Route::get('/task/{id}/edit', [App\Http\Controllers\TaskController::class, 'edit']);
Route::patch('/task/{id}/edit', [App\Http\Controllers\TaskController::class, 'update']);
Route::get('/task/{id}/newhint', [App\Http\Controllers\TaskController::class, 'newhint']);
Route::patch('/task/{id}/savenewhint', [App\Http\Controllers\TaskController::class, 'savenewhint']);
Route::get('/task/{id}/edit/hint/{hintid}', [App\Http\Controllers\TaskController::class, 'hintedit']);
Route::patch('/task/{id}/savehint/{hintid}', [App\Http\Controllers\TaskController::class, 'savehint']);
Route::get('/task/{id}/newtestcase', [App\Http\Controllers\TaskController::class, 'newtestcase']);
Route::patch('/task/{id}/savenewtestcase', [App\Http\Controllers\TaskController::class, 'savenewtestcase']);
Route::get('/task/{id}/edit/testcase/{testcaseid}', [App\Http\Controllers\TaskController::class, 'testcaseedit']);
Route::patch('/task/{id}/savetestcase/{testcaseid}', [App\Http\Controllers\TaskController::class, 'savetestcase']);
Route::get('/task/{id}/ide', [App\Http\Controllers\TaskController::class, 'ide']);
Route::post('/task/{id}/ide/test', [App\Http\Controllers\TaskController::class, 'test']);
Route::post('/task/{id}/ide/submitTask', [App\Http\Controllers\TaskController::class, 'submitTask']);
Route::post('/task/{id}/ide/hint', [App\Http\Controllers\TaskController::class, 'hint']);
Route::post('/task/{id}/sendFeedback', [App\Http\Controllers\TaskController::class, 'sendFeedback']);

// Egyéb
Route::get('/', function () {
    return view('/layouts/home');
});

Route::get('/{name}', function ($name) {
    return view('/layouts/'.$name);
});
