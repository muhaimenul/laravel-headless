<?php

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

Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);


Route::get('categories', [\App\Http\Controllers\CategoryController::class, 'index']);
Route::get('/public/articles', [\App\Http\Controllers\ArticleController::class, 'publicArticles']);
Route::get('/public/articles/{slug}', [\App\Http\Controllers\ArticleController::class, 'publicArticle']);
Route::get('/public/articles/{slug}/comments', [\App\Http\Controllers\CommentController::class, 'getArticleComments']);

Route::middleware(['auth'])->group(function () {
    Route::resource('articles', \App\Http\Controllers\ArticleController::class);
    Route::resource('comments', \App\Http\Controllers\CommentController::class)->except(['create', 'edit', 'show']);
});
