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
// routing per i bad bots (redirect tramite .htaccess)
Route::get('no-scansioni.html', function () { return 'Hello Robot !'; });



/*  ---- RUOLI UTENTE -------
COMPARATOR: subscriber, (+guest)
CMS: admin, author */



/* COMPARATOR - FRONTEND */
Route::get('/', function () { return redirect('videocitofoni/comparatore-prezzi');  });

Route::get('{slug}/comparatore-prezzi', 'ComparatorController@index');
Route::post('{slug}/comparatore-prezzi', 'ComparatorController@filter');  // checkboxs + text search
Route::get('search/autocomplete', 'ComparatorController@autocomplete');   // search box + autocomplete
// unsubscribe via Mail : github.com/spatie/laravel-url-signer
Route::get('unsubscribe-profile/{id}', ['middleware' => 'signedurl', 'uses' => 'Backend\UserController@autoDestroy'])->where('id', '[0-9]+');
Route::get('autorestore/{code}', ['uses' => 'Backend\UserController@autoRestore']);




/* COMPARATOR - BACKEND */
Route::get('register/verify/{token}', 'Auth\RegisterController@verify'); // verifica mail in registrazione nuovo utente (double opt-in)
Route::get('autologin/{token}', ['as' => 'autologin', 'uses' => '\Watson\Autologin\AutologinController@autologin']); // github.com/dwightwatson/autologin
Route::group(['middleware' => ['auth'], 'prefix' => 'backend'], function() {  
	Route::get('/', 'Backend\DashboardController@index');
	Route::get('change-my-pswd', 'Backend\DashboardController@changepswd');
	Route::post('change-my-pswd', 'Backend\DashboardController@postChangepswd');
	Route::get('delete/my-profile', 'Backend\UserController@deleteMyProfile');
	Route::get('metti-in-osservazione-{asin}-{id}', 'Backend\WatchinglistController@add');
	Route::get('smetti-di-osservare-{asin}-{id}', 'Backend\WatchinglistController@remove');
	Route::get('elimina-da-lista-{asin}-{id}', 'Backend\WatchinglistController@delete');
	Route::get('rimetti-in-osservazione-{asin}-{id}', 'Backend\WatchinglistController@restore'); 
});




/* CMS - FRONTEND */
Route::get('videocitofoni', 'ArticlesController@index');  //..verificare eventuali conflitti con le routes sotto
Route::post('articles-rating', 'ArticlesController@rating');
Route::post('{slug}/comment/send', 'Backend\CommentsController@send')->where('slug', '[A-Za-z0-9-_]+');
Route::post('{slug}/comment/subscribe', 'Backend\CommentsController@subscribe')->where('slug', '[A-Za-z0-9-_]+');
Route::get('unsubscribe/{slug}/{unique_code}', 'Backend\CommentsController@UnsubscribeToComment')->where('slug', '[A-Za-z0-9-_]+');




/* CMS - BACKEND */
// cambiare 'backend' con 'cms-backend' ?? 
Route::group(['middleware' => ['auth','admin'], 'prefix' => 'backend'], function() {
	Route::get('comments', 'Backend\CommentsController@index');
	Route::get('pending-comments', 'Backend\CommentsController@pending');
	Route::get('publish-comment-{id}', 'Backend\CommentsController@publish')->where('id', '[0-9]+');
	Route::get('edit-comment-{id}', 'Backend\CommentsController@edit');
	Route::post('edit-comment-{id}', 'Backend\CommentsController@update');
	Route::get('delete-comment-{id}', 'Backend\CommentsController@destroy');

	Route::resource('users', 'Backend\UserController');
});  






//'home' è il redirect predefinito assegnato di default dal sistema di autenticazione di Laravel (make:auth)
Route::get('home', function () { return redirect('backend');  });






// redirect da vecchio sito (da .htaccess su server apache)
Route::get('lavoraconnoi.htm', function () { return redirect('videocitofoni');  });
Route::get('russo/{str}', function () { return redirect('videocitofoni'); })->where('str', '(.*)');
Route::get('spagnolo/{str}', function () { return redirect('videocitofoni'); })->where('str', '(.*)');
Route::get('tedesco/{str}', function () { return redirect('videocitofoni'); })->where('str', '(.*)');
Route::get('italiano/{str}', function () { return redirect('videocitofoni'); })->where('str', '(.*)');
Route::get('inglese/{str}', function () { return redirect('videocitofoni'); })->where('str', '(.*)');
Route::get('graphics/{str}', function () { return redirect('videocitofoni'); })->where('str', '(.*)');
Route::get('francese/{str}', function () { return redirect('videocitofoni'); })->where('str', '(.*)');
Route::get('documenti/{str}', function () { return redirect('videocitofoni'); })->where('str', '(.*)');
Route::get('db/{str}', function () { return redirect('videocitofoni'); })->where('str', '(.*)');


