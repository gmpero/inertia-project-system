<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::group(['namespace' => 'Project', 'prefix' => 'projects'], function () {


        // Права на создание
        Route::middleware(['can:create projects'])->group(function () {
            Route::get('/create', [\App\Http\Controllers\ProjectController::class, 'create'])->name('project.create');
            Route::post('/', [\App\Http\Controllers\ProjectController::class, 'store'])->name('project.store');
        });

        Route::get('/', [\App\Http\Controllers\ProjectController::class, 'index'])->name('project.index');
        Route::get('/{project}', [\App\Http\Controllers\ProjectController::class, 'show'])->name('project.show');

        // Права на редактирование
        Route::middleware(['can:edit projects'])->group(function () {
            Route::get('/{project}/edit', [\App\Http\Controllers\ProjectController::class, 'edit'])->name('project.edit');
            Route::patch('/{project}', [\App\Http\Controllers\ProjectController::class, 'update'])->name('project.update');
        });

        // Права на удаление
        Route::middleware(['can:delete projects'])->group(function () {
            Route::delete('/{project}', [\App\Http\Controllers\ProjectController::class, 'delete'])->name('project.delete');
        });
    });

    Route::group(['namespace' => 'Task', 'prefix' => 'tasks'], function () {
        Route::get('/', [\App\Http\Controllers\TaskController::class, 'index'])->name('task.index');
        Route::get('/create', [\App\Http\Controllers\TaskController::class, 'create'])->name('task.create');
        Route::get('/{task}', [\App\Http\Controllers\TaskController::class, 'show'])->name('task.show');
        Route::post('/', [\App\Http\Controllers\TaskController::class, 'store'])->name('task.store');
        Route::get('/{task}/edit', [\App\Http\Controllers\TaskController::class, 'edit'])->name('task.edit');
        Route::patch('/{task}', [\App\Http\Controllers\TaskController::class, 'update'])->name('task.update');
        Route::delete('/{task}', [\App\Http\Controllers\TaskController::class, 'delete'])->name('task.delete');
    });

    Route::group(['namespace' => 'Message'], function () {
        Route::post('/', [\App\Http\Controllers\MessageController::class, 'store'])->name('message.store');
        Route::patch('/{message}', [\App\Http\Controllers\MessageController::class, 'update'])->name('message.update');
        Route::delete('/{message}', [\App\Http\Controllers\MessageController::class, 'delete'])->name('message.delete');
    });

    Route::group(['namespace' => 'Calendar', 'prefix' => 'calendar'], function () {
        Route::get('/', [\App\Http\Controllers\CalendarController::class, 'index'])->name('calendar.index');
    });
});

Route::fallback(function() {
    if (request()->is('registr*')) {
        return redirect()->route('register');
    }
    abort(404, 'Страница не найдена');
});

require __DIR__ . '/auth.php';
