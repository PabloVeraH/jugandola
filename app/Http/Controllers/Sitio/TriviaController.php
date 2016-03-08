<?php namespace MeLaJuego\Http\Controllers\Sitio;

use MeLaJuego\Http\Controllers\Controller;
use MeLaJuego\Entities\Vendedores\Trivia\Trivia;
use MeLaJuego\Entities\Vendedores\Trivia\Pregunta;
use MeLaJuego\Entities\Vendedores\Trivia\Respuesta;
use MeLaJuego\Entities\Vendedores\LogVendedor as Log;
use MeLaJuego\Entities\SuperLog;

class TriviaController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Trivia Controller
	|--------------------------------------------------------------------------
	|
	*/

	public function __construct(){
	}

	public function getTrivia(){
		//abort(503);
		$preguntas = [];
		$trivia = '';

		//Evaluamos si han pasado dos meses desde la ultima respuesta
		// $ultimaRespuesta = Respuesta::where('vendedor_id','=',\Auth::user()->rut)
		// 	->orderBy('created_at','desc')
		// 	->first();
		// $dosMeses = (time() + (60 * 24 * 60 * 60)) - time();
		// if( is_null($ultimaRespuesta) || ((time() - $ultimaRespuesta->created_at->getTimestamp()) > $dosMeses) ){
		$superlog = SuperLog::where('rut','=',\Auth::user()->rut)
				->where('tipo','=','trivia_melajuego')
				->get();

		if( count($superlog) == 0 ){
			$trivia = Trivia::where('habilitada','=',true)->first();
			if(!is_null($trivia)){
				$preguntas = $trivia->preguntas;				
			}
		}

		return view('gana-puntos.gana-puntos-trivia',[
			'preguntas' => $preguntas,
			'trivia'    => $trivia
		]);
	}

	public function guardarTrivia(){
		//abort(503);
		$message = 'Ocurrio un error al momento de procesar la trivia, intentelo nuevamente.';
		if(\Input::has('trivia')){
			try {
				$idTrivia = \Crypt::decrypt(\Request::input('trivia'));
				$trivia = Trivia::find($idTrivia);
				if($trivia instanceOf Trivia){
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
										'id'       => 'required|numeric|exists:ganapuntos_trivia_preguntas,id'
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
					if( count($trivia->preguntas) == count($preguntas) ){
						$ultimaRespuesta = Respuesta::orderBy('id','desc')->first();
						$triviaRespuestaID = (is_null($ultimaRespuesta)) ? 1 : $ultimaRespuesta->trivia_respuesta_id + 1;
						foreach ($preguntas as $pregunta){

							$respuesta = new Respuesta();
							$respuesta->respuesta = $pregunta['value'];
							$respuesta->pregunta_id = $pregunta['id'];
							$respuesta->vendedor_id = \Auth::user()->rut;
							$respuesta->trivia_respuesta_id = $triviaRespuestaID;
							$respuesta->save();
						}

						

						//Guardamos el SuperLog
						$superlog       = new SuperLog();
						$superlog->rut  = \Auth::user()->rut;
						$superlog->tipo = 'trivia_melajuego';
						$superlog->save();

						$puntaje = $this->getResultadoTrivia($triviaRespuestaID);
						$todoOk = ($puntaje['buenas'] == $puntaje['totales']) ? true : false;
						
						$log = new Log();
						$log->rut = \Auth::user()->rut;
						$log->puntos = ($todoOk) ? 75 : 0;
						$log->log = "Trivia contestada";
						$log->save();

						//Retornamos un redirect con todo ok a gana puntos
						if($todoOk){
							return redirect()->route('gana_puntos')->with('message_success','Has contestado perfectamente. <br> ¡Ganaste 75 puntos! <br> Pronto nueva trivia.');
						}
						else{
							return redirect()->route('gana_puntos')->with('error_trivia','Estuviste a punto de responder con exito. <br> Mira cúal era la correcta. La próxima trivia te ganas los puntos. Pronto.');	
						}
					}
					else{
						$message = "La cantidad de preguntas enciadas no es valida.";
					}
				}
				$message = "No se encontro la trivia solicitada, enviela nuevamente.";
			}catch(\Exception $e){
				$message = "El identificador de la trivia no es valido, intentelo nuevamente.";
			}
		}
		return redirect()->back()
			->withInput()
			->with('error_message',$message);
	}

	public function getResultadoTrivia($idTrivia){
		//abort(503);
		$respuestas = [
			'buenas'  => 0,
			'totales' => 0,
			'malas'   => 0
		];

		$tmp = Respuesta::where('trivia_respuesta_id','=',$idTrivia)->get();
		foreach ($tmp as $respuesta){
			$respuestas['totales']++;
			if($respuesta->respuesta == $respuesta->pregunta->respuesta)
				$respuestas['buenas']++;
			else
				$respuestas['malas']++;
		}

		return $respuestas;
	}
}
