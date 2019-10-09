<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// CSRF Validation
Route::when('*', 'csrf', array('post'));

Route::any('/', array( 'as' => 'home', 'uses' => 'MainController@index' ));

// MAIN
// Resource
Route::resource('main', 'MainController');

Route::get('list/{resource}/{objects?}/{type?}', 'BaseController@getElements');

// Authentication
Route::get('login', 'AuthController@getLogin');
Route::post('login', 'AuthController@postLogin');
Route::get('password/remind', 'AuthController@getRemind');
Route::post('password/remind', 'AuthController@postRemind');
Route::get('password/reset/{token}', 'AuthController@getReset');
Route::post('password/reset', 'AuthController@postReset');

// Error JS Route
Route::get('errors/js', function() {
	return View::make('errors.js');
});

// Authentication Filter Verification
Route::group(array('before' => 'auth'), function() {

	//AUTH

	// Logout
	Route::get('logout', 'AuthController@getLogout');

	// Password Verify
  Route::get('password/verify', 'AuthController@passwordVerify');

	// USERS

	// Change Password
	Route::get('users/{id}/change-password', [
		'as' => 'users.change-password',
		'uses' => 'UserController@changePassword'
	])->where('id', '[0-9]+');

	Route::patch('users/{id}/alter-password', [
		'as' => 'users.alter-password',
		'uses' => 'UserController@alterPassword'
	])->where('id', '[0-9]+');



	// BASES

	// Unique Validator
	Route::get('unique/{table}/{field}/{id}', 'BaseController@unique');

	// Is Default Password Filter Verification
	Route::group(array('before' => 'is-default-password'), function() {

	  // USERS

		// Assinatura
		Route::get('users/assinatura', ['as' => 'users.assinatura', 'uses' => 'UserController@createAssinatura']);
		Route::post('users/upload-assinatura', ['as' => 'users.upload-assinatura', 'uses' => 'UserController@uploadAssinatura']);
		Route::post('uploads', ['as' => 'users.upload-assinatura', 'uses' => 'UserController@uploadAssinatura']);

		// Report
    Route::get('users/report', 'UserController@report');

    // Export
    Route::get('users/export/{type}', ['as' => 'users.export', 'uses' => 'UserController@export']);

    // Print One
    Route::get('users/{id}/print-one', ['as' => 'users.print-one', 'uses' => 'UserController@printOne'])->where(array('id' => '[0-9]+'));

    // Print All
    Route::get('users/print-all', ['as' => 'users.print-all', 'uses' => 'UserController@printAll']);

    // Restore
	  Route::patch('users/{id}/restore', ['as' => 'users.restore', 'uses' => 'UserController@restore'])->where('id', '[0-9]+');

	  // Redefine
	  Route::get('users/{id}/redefine-password', [
	  	'as' => 'users.redefine-password', 'uses' => 'UserController@redefinePassword'
	  ])->where('id', '[0-9]+');


		// COMENTÁRIOS
		Route::resource('comentarios', 'ComentarioController');


	  // DASHBOARD

	  // Panel
	  Route::get('dashboard', [
	  	'as' => 'dashboard.panel', 'uses' => 'DashboardController@panel'
	  ]);

	  // Charts
	  Route::get('dashboard/charts/{resource}', [
	  	'as' => 'dashboard.charts', 'uses' => 'DashboardController@charts'
	  ]);


	  // LOGS

	  // Resource
	  Route::resource('logs', 'LoggerController');

  });

	# Rotas API (AJAX)
	Route::get('busca_sus/{sus}', 'PacienteController@buscar_sus');
	Route::get('findCidades/{uf}', 'PacienteController@findCidades');
	Route::get('findDadosProduto/{id}', 'LaudoController@findDadosProduto');
	Route::get('findSolicitacao/{num}', 'SolicitacaoController@findSolicitacao');
	Route::get('findExame/{id}', 'AguardandoController@findExame');
	Route::get('findPaciente/{id}', 'AguardandoController@findPaciente');
	Route::get('findTipoReagente/{id}', 'AguardandoController@findTipoReagente');

});
