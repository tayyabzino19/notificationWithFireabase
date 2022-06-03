<?php

use App\Http\Controllers\UserController;

use App\Http\Controllers\WebNotificationController;

use App\Http\Controllers\OrderController;
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

Route::get('chnageStatus',[UserController::class,'update']);
Route::get('read/{id}',[UserController::class,'read']);
Route::get('update-password/{token}/{email}', ['as' => 'updatePassword','uses' => 'UserController@setNewPassword']);


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');
Route::get('dashboard',[OrderController::class,'dashboard'])->name('dashboard');
Route::get('allowNotification',[OrderController::class,'allowNotification'])->name('allowNotification');
Route::post('/store-token', [WebNotificationController::class, 'storeToken'])->name('store.token');
Route::get('create_order',[OrderController::class,'create']);


Route::get('/push-notificaiton', [WebNotificationController::class, 'index'])->name('push-notificaiton');

Route::post('/send-web-notification', [WebNotificationController::class, 'sendWebNotification'])->name('send.web-notification');


require __DIR__.'/auth.php';
