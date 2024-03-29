<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Auth::routes();


/*  ---- USER ROLES ------- */
// COMPARATOR: subscriber, (+guest)
// CMS: admin, author


/*Public routes*/
Route::get('/', 'HomepageController@index')->name('home');



/* ADMIN */
Route::group(['middleware' => ['auth','admin'], 'prefix' => 'admin', 'as' => 'admin.'], function() {
	Route::get('/', 'Backend\AdminDashboardController@index')->name('home');
	Route::resource('users', 'Backend\AdminUserController');
	Route::get('comments', 'Backend\AdminCommentsController@index')->name('comments');
	Route::get('comments-filter', 'Backend\AdminCommentsController@filter')->name('comments.filter');
	Route::post('comments-filter', 'Backend\AdminCommentsController@storeFilterKeywords')->name('comments.store-filter-keywords');
	Route::get('run-comments-spam-filter', 'Backend\AdminCommentsController@runCommentsSpamFilter')->name('comments.run-spam-filter');
	Route::get('pending-comments', 'Backend\AdminCommentsController@pending')->name('pending-comments');
	Route::get('publish-comment-{id}', 'Backend\AdminCommentsController@publish')->where('id', '[0-9]+')->name('publish-comment');
	Route::get('edit-comment-{id}', 'Backend\AdminCommentsController@edit')->name('edit-comment');
	Route::post('edit-comment-{id}', 'Backend\AdminCommentsController@update')->name('publish-comment-post');
	Route::get('delete-comment-{id}', 'Backend\AdminCommentsController@destroy')->name('delete-comment');
	Route::get('change-my-pswd', 'Backend\ComparatorDashboardController@changepswd')->name('change-my-pswd');
	Route::post('change-my-pswd', 'Backend\ComparatorDashboardController@postChangepswd')->name('change-my-pswd-post');
	Route::get('change-my-profile', 'Backend\ComparatorDashboardController@changeMyProfile')->name('change-my-profile');
	Route::post('change-my-profile', 'Backend\ComparatorDashboardController@postChangeMyProfile')->name('change-my-profile-post');
	Route::get('delete/my-profile', 'Backend\ComparatorUserController@deleteMyProfile')->name('delete-my-profile');
});


/* COMPARATOR - FRONTEND */
Route::get('{slug}/comparatore-prezzi', 'ComparatorController@index')->name('slug-prices-comparator');
Route::post('{slug}/comparatore-prezzi', 'ComparatorController@filter')->name('slug-prices-comparator-post');
Route::get('search/autocomplete', 'ComparatorController@autocomplete')->name('search-autocomplete');
Route::get('unsubscribe-profile/{id}', ['middleware' => 'signedurl', 'uses' => 'Backend\ComparatorUserController@autoDestroy', 'as' => 'unsubscribe-profile'])->where('id', '[0-9]+');
Route::get('autorestore/{code}', ['uses' => 'Backend\ComparatorUserController@autoRestore', 'as' => 'autorestore']);


/* COMPARATOR - BACKEND */
// Route::get('register/verify/{token}', 'Auth\RegisterController@verify')->name('register');
Route::get('autologin/{token}', '\Watson\Autologin\AutologinController@autologin')->name('autologin');
Route::get('email-confirmation/{token}', 'Backend\ComparatorDashboardController@emailConfirmation')->name('email-confirmation');
Route::group(['middleware' => ['auth', 'subscriber'], 'prefix' => 'backend', 'as' => 'comparator-backend.'], function() {
	Route::get('/', 'Backend\ComparatorDashboardController@index')->name('home');
	Route::get('change-my-pswd', 'Backend\ComparatorDashboardController@changepswd')->name('change-my-pswd');
	Route::post('change-my-pswd', 'Backend\ComparatorDashboardController@postChangepswd')->name('change-my-pswd-post');
	Route::get('change-my-profile', 'Backend\ComparatorDashboardController@changeMyProfile')->name('change-my-profile');
	Route::post('change-my-profile', 'Backend\ComparatorDashboardController@postChangeMyProfile')->name('change-my-profile-post');
	Route::get('delete/my-profile', 'Backend\ComparatorUserController@deleteMyProfile')->name('delete-my-profile');
	Route::get('metti-in-osservazione-{asin}-{id}', 'Backend\ComparatorWatchinglistController@add')->name('put-in-observation');
	Route::get('smetti-di-osservare-{asin}-{id}', 'Backend\ComparatorWatchinglistController@remove')->name('remove-from-observation');
	Route::get('elimina-da-lista-{asin}-{id}', 'Backend\ComparatorWatchinglistController@delete')->name('delete-from-list');
	Route::get('rimetti-in-osservazione-{asin}-{id}', 'Backend\ComparatorWatchinglistController@restore')->name('reinsert-in-list');
});


/* CMS - BACKEND */
Route::group(['middleware' => ['auth', 'author'], 'prefix' => 'cms-backend', 'as' => 'cms-backend.'], function() {
	Route::get('/', 'Backend\CmsDashboardController@index')->name('home');
	Route::get('change-my-pswd', 'Backend\ComparatorDashboardController@changepswd')->name('change-my-pswd');
	Route::post('change-my-pswd', 'Backend\ComparatorDashboardController@postChangepswd')->name('change-my-pswd-post');
	Route::get('change-my-profile', 'Backend\ComparatorDashboardController@changeMyProfile')->name('change-my-profile');
	Route::post('change-my-profile', 'Backend\ComparatorDashboardController@postChangeMyProfile')->name('change-my-profile-post');
	Route::get('delete/my-profile', 'Backend\ComparatorUserController@deleteMyProfile')->name('delete-my-profile');
	Route::post('save-article-slug', 'Backend\CmsDashboardController@saveArticleSlug')->name('save-article-slug');
	Route::post('save-article/{with_status_definition?}', 'Backend\CmsDashboardController@saveArticle')->name('save-article');
	Route::resource('article', 'Backend\CmsArticleController');
	Route::get('make-new-article', 'Backend\CmsDashboardController@makeNewArticle')->name('make-new-article');
});


/* CMS - FRONTEND */
Route::post('articles-rating', 'ArticlesController@rating')->name('articles-rating');
Route::post('{slug}/comment/send', 'Backend\CmsCommentsController@send')->where('slug', '[A-Za-z0-9-_]+')->name('comment-send');
Route::post('{slug}/comment/subscribe', 'Backend\CmsCommentsController@subscribe')->where('slug', '[A-Za-z0-9-_]+')->name('comment-subscribe');
Route::get('unsubscribe/{slug}/{unique_code}', 'Backend\CmsCommentsController@UnsubscribeToComment')->where('slug', '[A-Za-z0-9-_]+')->name('comment-unsubscribe');
// ARTICLES, IMPORTANT: leave this the LAST in the page (ex. /videocitofoni) !!
Route::get('{slug}', 'ArticlesController@index')->where('slug', '[A-Za-z0-9-_]+')->name('article');
