<?php

use App\Http\Controllers\Home\HomeController;
use Illuminate\Support\Facades\Route;

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
    return redirect('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['prefix' => 'home'], function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::resource("page", HomeController::class)
        ->only(['edit', 'show', 'create'])
        ->parameters(['page' => 'id'])
        ->names('page')
        ->middleware('auth');;
    Route::resource("actions", HomeController::class)
        ->only(['store', 'update', 'destroy'])
        ->parameters(['actions' => 'id'])
        ->names('home.actions')
        ->middleware('auth');

});

require __DIR__ . '/auth.php';
