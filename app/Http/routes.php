<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
*/
Route::group( [ 'middleware' => 'auth' ] , function(){
	Route::get('/',[
		'as'   => 'inicio',
		'uses' => 'Sitio\HomeController@home'
	]);

	Route::get('catalogo',[
		'as'   => 'catalogo',
		'uses' => 'Sitio\CatalogoController@catalogo'
	]);

	Route::get('catalogo/{id}',[
		'as'   => 'detalle_producto',
		'uses' => 'Sitio\CatalogoController@producto'
	]);

	Route::post('catalogo/{id}/canjear',[
		'as'   => 'canjear',
		'uses' => 'Sitio\CatalogoController@canjear'
	]);

	Route::get('tu-cuenta',[
		'as'   => 'tu_cuenta',
		'uses' => 'Sitio\CuentaController@tuCuenta'
	]);

	Route::get('ficha-cliente', function(){
		return redirect()->route('tu_cuenta');
	});

	Route::get('ficha-cliente/{rut}',[
		'as'   => 'ficha_cliente',
		'uses' => 'Sitio\ClienteController@ficha'
	]);

	Route::get('ficha-cliente/{rut}/detalle',[
		'as'   => 'detalle_mes_cliente',
		'uses' => 'Sitio\ClienteController@detalle'
	]);

	Route::get('tus-puntos',[
		'as'   => 'tus_puntos',
		'uses' => 'Sitio\CuentaController@tusPuntos'
	]);

	Route::get('gana-puntos',[
		'as'   => 'gana_puntos',
		'uses' => 'Sitio\CuentaController@ganaPuntos'
	]);

	Route::get('gana-puntos/encuesta',[
		'as'   => 'gana_puntos_encuesta',
		'uses' => 'Sitio\EncuestaController@getEncuesta'
	]);

	Route::post('gana-puntos/encuesta',[
		'as'   => 'guardar_encuesta',
		'uses' => 'Sitio\EncuestaController@guardarEncuesta'
	]);

	Route::get('gana-puntos/trivia',[
		'as'   => 'gana_puntos_trivia',
		'uses' => 'Sitio\TriviaController@getTrivia'
	]);

	Route::post('gana-puntos/trivia',[
		'as'   => 'guardar_trivia',
		'uses' => 'Sitio\TriviaController@guardarTrivia'
	]);

	Route::get('gana-puntos/pares',[
		'as'   => 'gana_puntos_pares',
		'uses' => 'Sitio\ParesController@getPares'
	]);

	Route::post('gana-puntos/pares',[
		'as'   => 'guardar_puntos_pares',
		'uses' => 'Sitio\ParesController@guardarPares'
	]);

	Route::get('juegatela',[
		'as'   => 'juegatela',
		'uses' => 'Sitio\JuegatelaController@juegatela'
	]);	

	Route::post('juegatela',[
		'as'   => 'guardar-juegatela',
		'uses' => 'Sitio\JuegatelaController@guardar'
	]);	
});

Route::controllers([
	'auth' => 'Auth\AuthController'
]);

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/

Route::group(['prefix' => 'api'], function(){
	//Version 1
	Route::group(['prefix' => 'v1'], function(){
		Route::get('tipo-socio/{rut}',[
			'uses' => 'API\ClienteController@tipoSocio'
		]);

		Route::get('encuesta/{rut}',[
			'uses' => 'API\EncuestaController@getEncuesta'
		]);

		Route::post('encuesta',[
			'uses' => 'API\EncuestaController@saveEncuesta'
		]);

		Route::get('trivia/{rut}',[
			'uses' => 'API\TriviaController@getTrivia'
		]);

		Route::post('trivia',[
			'uses' => 'API\TriviaController@saveTrivia'
		]);
	});
});