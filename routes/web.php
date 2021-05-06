<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SitemapController;

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminComicsController;
use App\Http\Controllers\AdminChaptersController;
use App\Http\Controllers\AdminGenresController;
use App\Http\Controllers\AdminAuthorsController;
use App\Http\Controllers\AdminLanguagesController;
use App\Http\Controllers\AdminCommentsController;
use App\Http\Controllers\AdminUsersController;


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

Route::redirect('/admin', '/admin/dashboard');
Route::redirect('/comic', '/');
Route::redirect('/chapter', '/');
Route::redirect('/read', '/');
Route::redirect('/comment', '/');


// Main Routes

Route::get('/fdrcomics_sitemap.xml', [SitemapController::class, 'index']);
Route::get('/fdrcomics_sitemap2.xml', [SitemapController::class, 'index']);


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

Route::get('/search', [SearchController::class, 'search'])
->name('search');

Route::post('/search/filter', [SearchController::class, 'filter'])
->name('search.filter');

Route::get('/comics/{comic_id}', [ComicController::class, 'index'])
->name('comics');

Route::get('/read/{chapter_id}', [ReadController::class, 'index'])
->name('read');

Route::get('/comments/{chapter_id}', [CommentController::class, 'index'])
->name('comments');


Route::middleware(['auth'])->group(function () {

	Route::middleware(['role:reader,admin'])->group(function () {

		Route::post('/comics/{comic_id}/bookmark', [ComicController::class, 'bookmark'])
		->name('comics.bookmark');

		Route::post('/comics/{comic_id}/rating', [ComicController::class, 'rating'])
		->name('comics.rating');

		Route::get('/user/bookmarks', [UserController::class, 'bookmarks'])
		->name('user.bookmarks');

		Route::get('/user/history', [UserController::class, 'history'])
		->name('user.history');

		Route::get('/user/settings', [UserController::class, 'settings'])
		->name('user.settings');

		Route::put('/user/settings/profile/update', [UserController::class, 'profileUpdate'])
		->name('user.settings.profile.update');

		Route::put('/user/settings/password/update', [UserController::class, 'passwordUpdate'])
		->name('user.settings.password.update');

		Route::post('/comment/{chapter_id}', [CommentController::class, 'store'])
		->name('comment.store');

		Route::delete('/comment/{id}/delete', [CommentController::class, 'delete'])
		->name('comment.delete');
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

		Route::get('/admin/comics/{comic_id}/chapters/new', [AdminChaptersController::class, 'new'])
		->name('admin.comics.chapters.new');

		Route::post('/admin/comics/{comic_id}/chapters/store', [AdminChaptersController::class, 'store'])
		->name('admin.comics.chapters.store');

		Route::get('/admin/comics/chapters/{chapter_id}/edit', [AdminChaptersController::class, 'edit'])
		->name('admin.comics.chapters.edit');

		Route::put('/admin/comics/chapters/{chapter_id}/update', [AdminChaptersController::class, 'update'])
		->name('admin.comics.chapters.update');

		Route::delete('/admin/comics/chapters/{chapter_id}/delete', [AdminChaptersController::class, 'delete'])
		->name('admin.comics.chapters.delete');

		Route::post('/admin/comics/chapters/{chapter_id}/contents/store', [AdminChaptersController::class, 'storeContent'])
		->name('admin.comics.chapters.contents.store');

		Route::put('/admin/comics/chapters/{chapter_id}/contents/update', [AdminChaptersController::class, 'updateContent'])
		->name('admin.comics.chapters.contents.update');

		Route::get('/admin/comics/chapters/contents/{id}/delete', [AdminChaptersController::class, 'deleteContent'])
		->name('admin.comics.chapters.contents.delete');

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

		// Languages

		Route::get('/admin/languages', [AdminLanguagesController::class, 'index'])
		->name('admin.languages');

		Route::get('/admin/languages/new', [AdminLanguagesController::class, 'new'])
		->name('admin.languages.new');

		Route::post('/admin/languages/store', [AdminLanguagesController::class, 'store'])
		->name('admin.languages.store');

		Route::get('/admin/languages/{id}/edit', [AdminLanguagesController::class, 'edit'])
		->name('admin.languages.edit');

		Route::put('/admin/languages/{id}/update', [AdminLanguagesController::class, 'update'])
		->name('admin.languages.update');

		Route::delete('/admin/languages/{id}/delete', [AdminLanguagesController::class, 'delete'])
		->name('admin.languages.delete');

		// Users

		Route::get('/admin/users', [AdminUsersController::class, 'index'])
		->name('admin.users');

		// Comments

		Route::get('/admin/comments', [AdminCommentsController::class, 'index'])
		->name('admin.comments');

		// Route::get('/admin/comments/new', [AdminCommentsController::class, 'new'])
		// ->name('admin.comments.new');

		// Route::post('/admin/comments/store', [AdminCommentsController::class, 'store'])
		// ->name('admin.comments.store');

		// Route::get('/admin/comments/{id}/edit', [AdminCommentsController::class, 'edit'])
		// ->name('admin.comments.edit');

		// Route::put('/admin/comments/{id}/update', [AdminCommentsController::class, 'update'])
		// ->name('admin.comments.update');

		// Route::delete('/admin/comments/{id}/delete', [AdminCommentsController::class, 'delete'])
		// ->name('admin.comments.delete');
	});
});