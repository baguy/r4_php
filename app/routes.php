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

Route::get('/', function() {
	return Redirect::to('login');
});

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

		// BASES

		// Get Elements
		Route::get('list/{resource}/{objects?}/{type?}', 'BaseController@getElements');



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


    // Resource
	  Route::resource('users', 'UserController');


		// VIGILÂNCIA EPIDEMIOLÓGICA

		// Export para excel
		Route::get('vigilancia_epidemiologica/export/{e_cliente}/{e_solicitacao}/{e_status}/{e_exame}/{e_resultado}/{e_data_inicio}/{e_data_fim}', ['as' => 'vigilancia_epidemiologica.export', 'uses' => 'VigilanciaEpidemiologicaController@export']);

		// Resource
		Route::resource('vigilancia_epidemiologica', 'VigilanciaEpidemiologicaController');


	  // UNIDADES

	  // Restore
	  Route::patch('unidades/{id}/restore', [
	  	'as' => 'unidades.restore', 'uses' => 'UnidadeController@restore'
	  ])->where('id', '[0-9]+');

	  // Resource
	  Route::resource('unidades', 'UnidadeController');


	  // PRODUTO

		// Report
    Route::get('produtos/report', 'ProdutoController@report');

    // Export
    Route::get('produto/export/{type}', ['as' => 'produtos.export', 'uses' => 'ProdutoController@export']);

    // Print One
    Route::get('produtos/{id}/print-one', ['as' => 'produtos.print-one', 'uses' => 'ProdutoController@printOne'])->where(array('id' => '[0-9]+'));

    // Print All
    Route::get('produtos/print-all', ['as' => 'produtos.print-all', 'uses' => 'ProdutoController@printAll']);

	  // Restore
	  Route::patch('produtos/{id}/restore', [
	  	'as' => 'produtos.restore', 'uses' => 'ProdutoController@restore'
	  ])->where('id', '[0-9]+');

	  // Find by Description
	  Route::get('produtos/find-by-description/{term?}', [
	  	'as' => 'produtos.findByDescription', 'uses' => 'ProdutoController@findByDescription'
	  ]);

	  // Resource
	  Route::resource('produtos', 'ProdutoController');


		// EXAMES

		// Aprovar
		Route::get('exames/{id}/aprovar', ['as' => 'exames.aprovar', 'uses' => 'ExameController@aprovar'])->where('id', '[0-9]+');

		// Laudo
		Route::get('exames/{id}/laudo', ['as' => 'exames.laudo', 'uses' => 'ExameController@laudo'])->where('id', '[0-9]+');

		// Report
    Route::get('exames/report', 'ExameController@report');

    // Export
    Route::get('exames/export/{id}', ['as' => 'exames.export', 'uses' => 'ExameController@export']);

    // Print One
    Route::get('exames/{id}/print-one', ['as' => 'exames.print-one', 'uses' => 'ExameController@printOne'])->where(array('id' => '[0-9]+'));

    // Print All
    Route::get('exames/print-all', ['as' => 'users.print-all', 'uses' => 'ExameController@printAll']);

    // Restore
	  Route::patch('exames/{id}/restore', ['as' => 'exames.restore', 'uses' => 'ExameController@restore'])->where('id', '[0-9]+');

    // Resource
	  Route::resource('exames', 'ExameController');

		// Export para excel — protocolo VDRL/VDRL.G
		Route::get('pendentes/export_vdrl/{e_data_inicio}/{e_data_fim}', ['as' => 'pendentes.export_vdrl', 'uses' => 'PendenteController@export_vdrl']);

		// Export para excel — protocolo HIV/HBSAG/HCV
		Route::get('pendentes/export_hiv/{e_exame}/{e_solicitacao}/{e_data_inicio}/{e_data_fim}/{pre}', ['as' => 'pendentes.export_hiv', 'uses' => 'PendenteController@export_protocolo']);

		// Export para excel — protocolo TOXOPLASMOSE
		Route::get('pendentes/export_toxo/{e_exame}/{e_solicitacao}/{e_data_inicio}/{e_data_fim}/{pre}', ['as' => 'pendentes.export_toxo', 'uses' => 'PendenteController@export_protocolo']);

		// Export para excel — protocolo de trabalho
		Route::get('pendentes/export/{e_exame}/{e_solicitacao}/{e_data_inicio}/{e_data_fim}/{pre}', ['as' => 'pendentes.export_protocolo', 'uses' => 'PendenteController@export_protocolo']);

		// Status
		// PENDENTE
		Route::resource('pendentes', 'PendenteController');

		// AGUARDANDO
		// Export
		Route::post('aguardando/export', ['as' => 'aguardando.export', 'uses' => 'AguardandoController@export']);
		// Route::post('aguardando/export/{array}', ['as' => 'aguardando.export', 'uses' => 'AguardandoController@export']);
		// Resource
		Route::resource('aguardando', 'AguardandoController');

		// APROVADO
		Route::resource('aprovados', 'AprovadoController');


		// LAUDO

		// Print PDF
		Route::get('laudos/{id}/print-pdf', ['as' => 'laudos.print-pdf', 'uses' => 'LaudoController@printPDF'])->where(array('id' => '[0-9]+'));

		// Download PDF
		Route::get('laudos/{id}/download-pdf', ['as' => 'laudos.download-pdf', 'uses' => 'LaudoController@downloadPDF'])->where(array('id' => '[0-9]+'));

		// Destroy PDF
		Route::get('laudos/{id}/destroy-pdf', ['as' => 'laudos.destroy-pdf', 'uses' => 'LaudoController@destroyPDF'])->where(array('id' => '[0-9]+'));

		// Restore
		Route::patch('laudos/{id}/restore', ['as' => 'laudos.restore', 'uses' => 'LaudoController@restore'])->where('id', '[0-9]+');

		// Resource
		Route::resource('laudos', 'LaudoController');

	  // SOLICITAÇÕES

		// Report
    Route::get('solicitacoes/report', 'SolicitacaoController@report');

    // Export
    Route::get('solicitacoes/export/{type}', ['as' => 'solicitacoes.export', 'uses' => 'SolicitacaoController@export']);

    // Print One
    Route::get('solicitacoes/{id}/print-one', [
    	'as' => 'solicitacoes.print-one', 'uses' => 'SolicitacaoController@printOne'
    ])->where(array('id' => '[0-9]+'));

    // Print All
    Route::get('solicitacoes/print-all/{id}', ['as' => 'solicitacoes.print-all', 'uses' => 'SolicitacaoController@printAll'])->where(array('id' => '[0-9]+'));

	  // Restore
	  Route::patch('solicitacoes/{id}/restore', [
	  	'as' => 'solicitacoes.restore', 'uses' => 'SolicitacaoController@restore'
	  ])->where('id', '[0-9]+');

	  // Get Items
	  Route::get('solicitacoes/get-items/{id}', [
	  	'as' => 'solicitacoes.getItems', 'uses' => 'SolicitacaoController@getItems'
	  ])->where('id', '[0-9]+');

	  // Resource
	  Route::resource('solicitacoes', 'SolicitacaoController');



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
