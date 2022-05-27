<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();
Route::group(['middleware' => 'auth:web'], function () {
    
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('products',ProductController::class);
    Route::resource('categories',CategoryController::class)->except(['show','update']);
    Route::patch('category/{id}',[CategoryController::class,'update'])->name('cat.update');
    Route::post('product/uploadImage',[ProductController::class,'uploadImages'])->name('upload.images');
    Route::get('product/showImages/{id}',[ProductController::class,'showImages'])->name('products.image.show');
    Route::post('product/deleteimage{id}',[ProductController::class,'deleteImages'])->name('products.image.delete');


});
