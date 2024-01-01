<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{AdminController,SourceController,LeadStatusController,LeadsController,CallLogsController,NotesController};
use App\Http\Controllers\Admin\Auth\{LoginController};
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

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'adminLogin'])->name('login');

    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('logout',[LoginController::class,'logout'])->name('logout');
        
        Route::resource('users', AdminController::class);
        Route::post('users/list',[AdminController::class,'list'])->name('users.list');
        
        Route::resource('source', SourceController::class);
        Route::post('source/list',[SourceController::class,'list'])->name('source.list');

        Route::resource('lead_status', LeadStatusController::class);
        Route::post('lead_status/list',[LeadStatusController::class,'list'])->name('lead_status.list');
        
        Route::resource('leads', LeadsController::class);
        Route::post('leads/list',[LeadsController::class,'list'])->name('leads.list');
        Route::post('leads/tabinfo',[LeadsController::class,'tabInfo'])->name('leads.tabinfo');

        Route::resource('calllog', CallLogsController::class);
        Route::post('calllog/list',[CallLogsController::class,'list'])->name('calllog.list');

        Route::resource('note', NotesController::class);
        Route::post('note/list',[NotesController::class,'list'])->name('note.list');

    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::resource('role', 'App\Http\Controllers\RoleController');
});
