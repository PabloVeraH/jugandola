<?php namespace MeLaJuego\Http\Controllers\Sitio;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use MeLaJuego\Entities\SuperLog;
use MeLaJuego\Entities\Vendedores\LogVendedor as Log;
use MeLaJuego\Http\Controllers\Controller;

class JuegatelaController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Cuenta Controller
	|--------------------------------------------------------------------------
	|
	*/

	public function __construct(){
	}

	/**
	 * Entrega menu de juegos.
	 *
	 * @return Response
	 */
	public function juegatela(){
		$habilitado = false;
		$superlog = SuperLog::where('rut','=',Auth::user()->rut)
				->where('tipo','=','jackpot_melajuego')
				->get();

		if( count($superlog) == 0 ){
			$habilitado = true;

			//Guardamos punto extra
			$log = new Log();
			$log->rut = Auth::user()->rut;
			$log->puntos = 0;
			$log->log = 'Juego jackpot realizado';
			$log->save();

			Session::put('idJuegatela', $log->id);
			
			//Guardamos SuperLog
			$nuevoSuperLog = new SuperLog();
			$nuevoSuperLog->rut  = Auth::user()->rut;
			$nuevoSuperLog->tipo = 'jackpot_melajuego';
			$nuevoSuperLog->save();
		}

		return view('juegatela.juegatela',[
			'habilitado' => $habilitado
		]);
	}

	public function guardar(){
		if(\Request::has('game')){
			$game    = \Request::get('game');
			$estado  = false; 
			
			$log = Log::find($game);
			Session::put('gracias_juego', 1);
			
			if(!is_null($log)){
				$log->puntos = 75;
				$log->save();
				Session::set('gracias_juego', 2);
				$estado = true;
			}

			//Repsonse final
			return response()->json([
				'success' => $estado
			]);
		}

		//Caso erroneo
		return response()->json([
			'success' => false,
			'mensaje' => 'Faltan las variables'
		]);
	}

}
