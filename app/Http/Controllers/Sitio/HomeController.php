<?php namespace MeLaJuego\Http\Controllers\Sitio;

use MeLaJuego\Http\Controllers\Controller;
use MeLaJuego\Entities\ModalHome;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(){
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function home(){
		$modal = ModalHome::where('mod_estado','=',true)->first();
		return view('sitio.home',[
			'modal' => $modal
		]);
	}

}
