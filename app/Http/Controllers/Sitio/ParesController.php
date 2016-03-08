<?php namespace MeLaJuego\Http\Controllers\Sitio;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use MeLaJuego\Entities\SuperLog;
use MeLaJuego\Entities\Vendedores\LogVendedor as Log;
use MeLaJuego\Http\Controllers\Controller;

class ParesController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| PAres Controller
	|--------------------------------------------------------------------------
	|
	*/

	public function __construct(){
	}

	public function getPares(){
		$habilitado = false;

		$superlog = SuperLog::where('rut','=',Auth::user()->rut)
				->where('tipo','=','memorice_melajuego')
				->get();

		if( count($superlog) == 0 ){
			$habilitado = true;

			//Guardamos punto extra
			$log = new Log();
			$log->rut = Auth::user()->rut;
			$log->puntos = 0;
			$log->log = 'Juego memorice realizado';
			$log->save();

			Session::put('idJuego', $log->id);
			
			//Guardamos SuperLog
			$nuevoSuperLog = new SuperLog();
			$nuevoSuperLog->rut  = Auth::user()->rut;
			$nuevoSuperLog->tipo = 'memorice_melajuego';
			$nuevoSuperLog->save();
		}

		return view('gana-puntos.gana-puntos-pares',[
			'habilitado' => $habilitado
		]);
	}

	public function guardarPares(){
		if(\Request::has('game') && \Request::has('s')){
			$maxTime = 180;
			$game    = \Request::get('game');
			$seg     = \Request::get('s');
			$estado  = false; 
			
			$log = Log::find($game);
			Session::put('tiempoJuego', $seg);
			Session::put('gracias_juego', 1);
			
			if(!is_null($log) && $seg <= $maxTime){
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
