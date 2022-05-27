<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Route::group(['middleware' => 'auth:api'], function () {
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class)->except('update');
    Route::patch('category/{id}', [CategoryController::class, 'update'])->name('cat.update');
    Route::post('product/uploadImage', [ProductController::class, 'uploadImages'])->name('upload.images');
    Route::get('product/showImages/{id}', [ProductController::class, 'showImages'])->name('products.image.show');
    Route::post('deleteimage/{id}', [ProductController::class, 'deleteImages'])->name('products.image.delete');
// });
