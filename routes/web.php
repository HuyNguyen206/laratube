<?php

use App\Http\Controllers\ChannelController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UploadVideoController;
use App\Http\Controllers\VideoController;
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

Route::get('/', [HomeController::class, 'index']);

Auth::routes();
Route::resource('channels', ChannelController::class);
Route::get('channels/videos/{video}', [VideoController::class, 'getVideo'])->name('videos.show');
Route::put('channels/videos/{video}', [VideoController::class, 'updateVideoView']);
Route::put('channels/videos/{video}/update', [VideoController::class, 'updateVideoDetail'])->middleware('auth')->name('videos.update');
Route::put('channels/{type}/{objectId}/vote', [VideoController::class, 'vote'])->middleware('auth'); //type:video/comment
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('videos/comments/store', [CommentController::class, 'storeComment']);
Route::get('videos/{video}/comments', [CommentController::class, 'index']);
Route::get('/channels/comments/{comment}/replies', [CommentController::class, 'getReplies']);
Route::middleware('auth')->group(function(){
//    Route::resource('channels.subscriptions', SubscriptionController::class)->shallow();
    Route::post('subscribers/channels/{channel}',[SubscriptionController::class, 'toggleSubscriber']);
    Route::get('channels/upload-video/{channel}', [UploadVideoController::class, 'index'])->name('upload-video.index');
    Route::post('channels/upload-video/{channel}', [UploadVideoController::class, 'store']);
});
Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

