<?php namespace MeLaJuego\Http\Controllers\Auth;

use MeLaJuego\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth){
		$this->auth = $auth;

		$this->middleware('guest', ['except' => 'getLogout']);
	}

	public function postLogin(Request $request){
		$rut      = $request->get('rut');
		$password = $request->get('password');

        if ($this->auth->attempt( ['rut' => $rut, 'password' => $password, 'tipo' => 'V'] , false )){
            return redirect()->route('inicio');
        }
 
        return redirect('auth/login')->withErrors([
            'rut' => 'Las credenciales ingresadas no son correctas o estas deshabilitado.',
        ])
        ->withInput();
    }

}
