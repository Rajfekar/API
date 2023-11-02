<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['controller' => UserController::class], function () {
    Route::post('store-user', 'StoreUser')->name('store.user');
    Route::get('all-users', 'AllUser')->name('all.user');
    Route::patch('edit-user/{id}', 'UpdateUser')->name('edit.user');
    Route::delete('delete-user/{id}', 'DeleteUser')->name('delete.user');
});
