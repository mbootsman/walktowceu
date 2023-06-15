<?php

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

// Route::statamic('example', 'example-view', [
//    'title' => 'Example'
// ]);
Route::statamic('news/page/{page}', 'news.index', ['load' => 'b9e4bfe3-9c12-4553-b7ef-f43c22ffaa63']);
//Route::statamic('articles/page/{page}', 'articles.index', ['load' => 'id-of-articles-page']);