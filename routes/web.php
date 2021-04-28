<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminComicsController;
use App\Http\Controllers\AdminChaptersController;
use App\Http\Controllers\AdminGenresController;
use App\Http\Controllers\AdminAuthorsController;


use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReadController;
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

Route::get('/comics/{comic_id}', [ComicController::class, 'show'])
->name('comics');

Route::get('/read/{chapter_id}', [ReadController::class, 'index'])
->name('read');


Route::middleware(['auth'])->group(function () {

	Route::middleware(['role:reader,admin'])->group(function () {

		Route::get('/user/history', [UserController::class, 'history'])
		->name('user.history');

		Route::post('/comment/{chapter_id}', [CommentController::class, 'store'])
		->name('comment.store');
	});

	Route::middleware(['role:admin'])->group(function () {

		// Route::redirect('/admin', '/admin/dashboard');

		Route::get('/admin/dashboard', [AdminDashboardController::class, 'dashboard'])
		->name('admin.dashboard');

		// Comics

		Route::get('/admin/comics', [AdminComicsController::class, 'index'])
		->name('admin.comics');

		Route::get('/admin/comics/new', [AdminComicsController::class, 'new'])
		->name('admin.comics.new');

		Route::post('/admin/comics/store', [AdminComicsController::class, 'store'])
		->name('admin.comics.store');

		Route::get('/admin/comics/{comic_id}/edit', [AdminComicsController::class, 'edit'])
		->name('admin.comics.edit');

		Route::put('/admin/comics/{comic_id}/update', [AdminComicsController::class, 'update'])
		->name('admin.comics.update');

		// Chapters

		Route::get('/admin/comic/chapters/{chapter_id}', [AdminChaptersController::class, 'new'])
		->name('admin.comics.chapters');

		Route::get('/admin/comics/{comic_id}/chapters/new', [AdminChaptersController::class, 'new'])
		->name('admin.comics.chapters.new');

		Route::post('/admin/comics/{comic_id}/chapters/store', [AdminChaptersController::class, 'store'])
		->name('admin.comics.chapters.store');

		// Genres

		Route::get('/admin/genres', [AdminGenresController::class, 'index'])
		->name('admin.genres');

		Route::get('/admin/genres/new', [AdminGenresController::class, 'new'])
		->name('admin.genres.new');

		Route::post('/admin/genres/store', [AdminGenresController::class, 'store'])
		->name('admin.genres.store');


		// Authors

		Route::get('/admin/authors', [AdminAuthorsController::class, 'index'])
		->name('admin.authors');

		Route::get('/admin/authors/new', [AdminAuthorsController::class, 'new'])
		->name('admin.authors.new');

		Route::post('/admin/authors/store', [AdminAuthorsController::class, 'store'])
		->name('admin.authors.store');











		// Comics

		Route::get('/admin/comic/list', [AdminDashboardController::class, 'dashboard'])
		->name('admin.comic.list');

		Route::get('/admin/comic/new', [AdminDashboardController::class, 'dashboard'])
		->name('admin.comic.new');

		// Comic

		Route::get('/comic/create/new', [ComicController::class, 'create'])
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
});