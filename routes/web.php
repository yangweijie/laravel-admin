<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Middleware\HandleInertiaRequests;
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
    return view('welcome');
});

Route::controller(TodoController::class)->group(function () {
    Route::get('/todo', 'index');
    Route::post('/todo', 'store');
    Route::put('/todo', 'upd');
    Route::delete('/todo', 'delete');
    Route::delete('/todo/delComplete', 'deleteComplete');
});

// Route::middleware(['web', HandleInertiaRequests::class])->get('todo', function () {
//     return inertia('Todo/index');
// });