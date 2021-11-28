<?php

use App\Http\Controllers\ChannelController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UploadVideoController;
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
Route::resource('channels', ChannelController::class);
Route::get('channels/videos/{video}', [ChannelController::class, 'getVideo']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function(){
//    Route::resource('channels.subscriptions', SubscriptionController::class)->shallow();
    Route::post('subscribers/channels/{channel}',[SubscriptionController::class, 'toggleSubscriber']);
    Route::get('channels/upload-video/{channel}', [UploadVideoController::class, 'index'])->name('upload-video.index');
    Route::post('channels/upload-video/{channel}', [UploadVideoController::class, 'store']);
});
Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

