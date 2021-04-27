<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ComicController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ChapterContentController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;

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

// Example

Route::redirect('/comic', '/');
Route::redirect('/chapter', '/');
Route::redirect('/read', '/');
Route::redirect('/chapter', '/');
Route::redirect('/comment', '/');


// Main Routes


Route::get('/auth/login', [AuthController::class, 'login'])
->name('login');

Route::get('/auth/register', [AuthController::class, 'register'])
->name('register');

Route::post('/auth/register', [AuthController::class, 'store'])
->name('register.store');

Route::post('/auth/login/validate', [AuthController::class, 'loginValidate'])
->name('login.validate');

Route::get('/auth/logout', [AuthController::class, 'logout'])
->name('logout');


Route::get('/', [HomeController::class, 'index']);

Route::get('/home', [HomeController::class, 'index'])
->name('home');

Route::get('/search/title/{title}/type/{type}/genres/{genre}', [SearchController::class, 'search'])
->name('search');

Route::post('/search/filter', [SearchController::class, 'filter'])
->name('search.filter');

Route::get('/comic/{comic_id}', [ComicController::class, 'show'])
->name('comic.show');

Route::get('/read/{chapter_id}', [ChapterController::class, 'read'])
->name('chapter.read');


Route::middleware(['auth', 'role:member,admin'])->group(function () {

	Route::get('/user/history', [UserController::class, 'history'])
	->name('user.history');

	Route::post('/comment/{chapter_id}', [CommentController::class, 'store'])
	->name('comment.store');
});

Route::middleware(['auth', 'role:admin'])->group(function () {

	// Comic

	Route::get('/comic/create', [ComicController::class, 'create'])
	->name('comic.create');

	Route::post('/comic/create/store', [ComicController::class, 'store'])
	->name('comic.store');

	Route::get('/comic/{comic_id}/edit', [ComicController::class, 'edit'])
	->name('comic.edit');

	// Chapter

	Route::get('/chapter/{comic_id}/create', [ChapterController::class, 'create'])
	->name('chapter.create');

	Route::post('/chapter/{comic_id}/store', [ChapterController::class, 'store'])
	->name('chapter.store');

	Route::get('/chapter/{chapter_id}/edit', [ChapterController::class, 'edit'])
	->name('chapter.edit');

	Route::delete('/chapter/delete', [ChapterController::class, 'delete'])
	->name('chapter.delete');

	// Chapter Content

	Route::post('/chapter/content/{chapter_id}/store', [ChapterContentController::class, 'store'])
	->name('chapter.content.store');

	Route::put('/comic/{comic_id}/{title}/chapter/{chapter}/update', [ChapterContentController::class, 'update'])
	->name('comic.chapter.content.update');

	Route::get('/chapter/content/{chapter_id}/delete/{chapter_content_id}', [ChapterContentController::class, 'delete'])
	->name('chapter.content.delete');

	Route::delete('/chapter/content/{chapter_id}/delete/all', [ChapterContentController::class, 'deleteAll'])
	->name('chapter.content.delete.all');
});