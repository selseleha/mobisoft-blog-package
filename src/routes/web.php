<?php


use mobisoft\blog\Controllers\CommentController;
use mobisoft\blog\Controllers\PostController;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
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

//change database connection

Route::group(
    ['middleware' => 'web'], function () {


    Route::get('post/guest', [PostController::class, 'guestIndex']);

    Route::resource('post', PostController::class)->middleware('auth');


    Route::get('post/{post}', [PostController::class, 'show'])->name(
        'post.show'
    );

    Route::post('comment/{post_id}', [CommentController::class, 'store'])->name(
        'comment.store'
    );

}
);
