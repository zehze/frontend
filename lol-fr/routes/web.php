<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Session;
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
    return view('welcome');
});

Route::get('/register', 
    [AuthController::class , 'register_show'
])->name('register');

Route::post('/register', 
    [AuthController::class , 'register']);

Route::get('/login', 
    [AuthController::class , 'login_show'
])->name('login');

Route::post('/login', [AuthController::class , 'login']);


Route::get('/home',
    [HomeController::class,'index'
])->name('home') ;





Route::get(
    '/items',
    [ItemController::class, 'index']
)->name('items');

Route::post(
    '/items',
    [ItemController::class, 'store']
)->name('item.store');

Route::delete(
    '/items/{id}',
    [ItemController::class, 'delete']
)->name('item.delete');

Route::get(
    '/item/edit/{id}',
    [ItemController::class ,'edit']
)->name('item.edit');

Route::put(
    '/item/update/{id}', 
    [ItemController::class ,'update']
)->name('item.update');



