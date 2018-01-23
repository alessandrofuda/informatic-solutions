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

// routing per i bad bots (redirect tramite .htaccess)
Route::get('no-scansioni.html', function () { return 'Hello Robot !'; });

// FRONT END

//home page
Route::get('/', 'HomepageController@index');
Route::post('/', 'HomepageController@index_form');  //..modulo contatti..

// videocitofoni page
Route::get('videocitofoni', 'ArticlesController@index');  //verificare eventuali conflitti con le routes sotto
Route::post('articles-rating', 'ArticlesController@rating');

// videocitofoni comments
Route::post('{slug}/comment/send', 'Backend\CommentsController@send')->where('slug', '[A-Za-z0-9-_]+');
Route::post('{slug}/comment/subscribe', 'Backend\CommentsController@subscribe')->where('slug', '[A-Za-z0-9-_]+');
Route::get('unsubscribe/{slug}/{unique_code}', 'Backend\CommentsController@UnsubscribeToComment')->where('slug', '[A-Za-z0-9-_]+');

// videocitofoni comparator
Route::get('{slug}/comparatore-prezzi', 'ComparatorController@index');
Route::post('{slug}/comparatore-prezzi', 'ComparatorController@filter');

// search box
Route::post('ajax-search', 'ComparatorController@PlainTextFilter');

//'home' è il redirect predefinito assegnato di default dal sistema di autenticazione di Laravel (make:auth)
Route::get('home', function () { return redirect('backend');  });


//TESTING FETCH PRODUCT  -  SCRAPING --> sostituiti con custom artisan commands !!
//Route::get('{slug}/comparatore-prezzi/fetch-product-{videocitofono}', 'ComparatorController@FetchAndInsertProductInDb');
//Route::get('{slug}/comparatore-prezzi/scraping-reviews', 'ComparatorController@scrapingreview');
//Route::get('test', '')

//TESTING SEND EMAILS
//Route::get('send_test_email', function(){
//	Mail::raw('Sending emails with Mailgun and Laravel is easy!', function($message) {
//		$message->to(env('ADMIN_EMAIL')); });
//});


// MAILS ROUTING
// verifica via mail nel processo di registrazione nuovo utente al comparatore (double opt-in)
Route::get('register/verify/{token}', 'Auth\RegisterController@verify'); 

// package https://github.com/dwightwatson/autologin
Route::get('autologin/{token}', ['as' => 'autologin', 'uses' => '\Watson\Autologin\AutologinController@autologin']);

// package https://github.com/spatie/laravel-url-signer  -- release:1.1.3
Route::get('unsubscribe-profile/{id}', ['middleware' => 'signedurl', 'uses' => 'Backend\UserController@autoDestroy'])->where('id', '[0-9]+');
Route::get('autorestore/{code}', ['uses' => 'Backend\UserController@autoRestore']);





// BACK END - tutti gli url gestibili da utenti autenticati (admin || author || subscriber)

Auth::routes();
Route::group(['middleware' => ['auth'], 'prefix' => 'backend'], function() {  

	Route::get('/', 'Backend\DashboardController@index');
	Route::get('change-my-pswd', 'Backend\DashboardController@changepswd');
	Route::post('change-my-pswd', 'Backend\DashboardController@postChangepswd');
	Route::get('delete/my-profile', 'Backend\UserController@deleteMyProfile');
	Route::get('metti-in-osservazione-{asin}-{id}', 'Backend\WatchinglistController@add');
	Route::get('smetti-di-osservare-{asin}-{id}', 'Backend\WatchinglistController@remove');
	Route::get('elimina-da-lista-{asin}-{id}', 'Backend\WatchinglistController@delete');
	Route::get('rimetti-in-osservazione-{asin}-{id}', 'Backend\WatchinglistController@restore'); 



	//routes accessibili SOLO da ADMIN (routes con prefix 'backend')
  	Route::group(['middleware' => 'admin'], function() {

		Route::get('comments', 'Backend\CommentsController@index');
		Route::get('pending-comments', 'Backend\CommentsController@pending');
		Route::get('publish-comment-{id}', 'Backend\CommentsController@publish')->where('id', '[0-9]+');
		Route::get('edit-comment-{id}', 'Backend\CommentsController@edit');
		Route::post('edit-comment-{id}', 'Backend\CommentsController@update');
		Route::get('delete-comment-{id}', 'Backend\CommentsController@destroy');

		Route::resource('users', 'Backend\UserController');

  	});
  

});


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

/*
//redirect 301 /russo/index.html http://informatic-solutions.it/videocitofoni
redirect 301 /lavoraconnoi.htm http://informatic-solutions.it
RedirectMatch 301 /russo/(.*) http://informatic-solutions.it/videocitofoni
RedirectMatch 301 /spagnolo/(.*) http://informatic-solutions.it
RedirectMatch 301 /tedesco/(.*) http://informatic-solutions.it
RedirectMatch 301 /italiano/(.*) http://informatic-solutions.it
RedirectMatch 301 /inglese/(.*) http://informatic-solutions.it
RedirectMatch 301 /graphics/(.*) http://informatic-solutions.it
RedirectMatch 301 /francese/(.*) http://informatic-solutions.it
RedirectMatch 301 /documenti/(.*) http://informatic-solutions.it
RedirectMatch 301 /db/(.*) http://informatic-solutions.it
*/






//  /login  /register --> sono già stati predisposti con 'php artisan make:auth' (anche reset e forgot password)
