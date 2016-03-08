<?php namespace MeLaJuego\Http\Controllers\Sitio;

use MeLaJuego\Http\Controllers\Controller;
use MeLaJuego\Entities\Vendedores\Encuesta\Encuesta;
use MeLaJuego\Entities\Vendedores\Encuesta\Alternativa;
use MeLaJuego\Entities\Vendedores\Encuesta\Respuesta;
use MeLaJuego\Entities\Vendedores\LogVendedor as Log;
use MeLaJuego\Entities\SuperLog;

class EncuestaController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Encuesta Controller
	|--------------------------------------------------------------------------
	|
	*/

	public function __construct(){
	}

	public function getEncuesta(){
		//abort(503);
		$alternativas = [];
		$encuesta = '';

		//Evaluamos si han pasado dos meses desde la ultima respuesta
		// $ultimaRespuesta = Respuesta::where('vendedor_id','=',\Auth::user()->rut)
		// 	->orderBy('created_at','desc')
		// 	->first();

		// $dosMeses = (time() + (60 * 24 * 60 * 60)) - time();
		// if( is_null($ultimaRespuesta) || ((time() - $ultimaRespuesta->created_at->getTimestamp()) > $dosMeses) ){
		$superlog = SuperLog::where('rut','=',\Auth::user()->rut)
				->where('tipo','=','encuesta_melajuego')
				->get();

		if( count($superlog) == 0 ){
			$encuesta = Encuesta::where('habilitada','=',true)->first();
			if(!is_null($encuesta)){
				$alternativas = $encuesta->alternativas;
			}
		}

		return view('gana-puntos.gana-puntos-encuesta',[
			'alternativas' => $alternativas,
			'encuesta'     => $encuesta
		]);
	}

	public function guardarEncuesta(){
		//abort(503);
		$message = 'Ocurrio un error al momento de procesar la encuesta, intentelo nuevamente.';
		if(\Input::has('encuesta')){
			try {
				$idEncuesta = \Crypt::decrypt(\Request::input('encuesta'));
				$encuesta = Encuesta::find($idEncuesta);
				if($encuesta instanceOf Encuesta){
					$preguntas = [];
					foreach (\Request::input() as $key => $value){
						if(substr($key, 0,8) == 'pregunta'){

							//Validamos que la opcion sea un booleano
							$tmp = explode('#', $key);
							try {
								$validator = \Validator::make(
									[
										'pregunta' => $value,
										'id'       => \Crypt::decrypt($tmp[1])
									],
									[
										'pregunta' => 'required|boolean',
										'id'       => 'required|numeric|exists:ganapuntos_encuesta_alternativas,id'
									]
								);	
							}catch(\Exception $e) {
								$message = "Hay preguntas que no tienen valores correctos.";
								break;
							}

							if($validator->passes()){
								array_push($preguntas,[
									'id'    => \Crypt::decrypt($tmp[1]),
									'value' => $value
								]);
							}
							else{
								$message = "Hay preguntas que no tienen valores validos.";
								break;
							}
						}
					}

					//Validamos que las preguntas tienen el mismo largo
					if( count($encuesta->alternativas) == count($preguntas) ){
						foreach ($preguntas as $pregunta){
							$respuesta = new Respuesta();
							$respuesta->valor = $pregunta['value'];
							$respuesta->pregunta_id = $pregunta['id'];
							$respuesta->vendedor_id = \Auth::user()->rut;
							$respuesta->save();
						}

						$log = new Log();
						$log->rut = \Auth::user()->rut;
						$log->puntos = 100;
						$log->log = "Encuesta contestada";
						$log->save();

						//Guardamos el SuperLog
						$superlog       = new SuperLog();
						$superlog->rut  = \Auth::user()->rut;
						$superlog->tipo = 'encuesta_melajuego';
						$superlog->save();

						//Retornamos un redirect con todo ok a gana puntos
						return redirect()->route('gana_puntos')->with('message_success','Gracias por responder, te has ganado 100 puntos. <br> Juntos haremos crecer al club, tus metas y tus clientes. <br> Pronto una nueva encuesta para que sigas potenciando tus conocimientos.');
					}
					else{
						$message = "La cantidad de preguntas enviadas no es valida.";
					}
				}
				$message = "No se encontro la encuesta enviada, enviela nuevamente.";
			}catch(\Exception $e){
				$message = "El identificador de la encuesta no es valido, intentelo nuevamente.";
			}
		}
		return redirect()->back()
			->withInput()
			->with('error_message',$message);
	}
}
