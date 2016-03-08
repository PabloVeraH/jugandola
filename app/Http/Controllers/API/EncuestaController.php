<?php namespace MeLaJuego\Http\Controllers\API;

use MeLaJuego\Http\Controllers\Controller;
use MeLaJuego\Repositories\ClienteRepository;
use MeLaJuego\Repositories\ClienteNuevoRepository;
use MeLaJuego\Entities\Almaceneros\Encuesta\Respuesta;
use MeLaJuego\Entities\Almaceneros\Encuesta\Encuesta;
use MeLaJuego\Entities\Almaceneros\LogCliente as Log;
use MeLaJuego\Entities\SuperLog;

class EncuestaController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Cliente Controller
	|--------------------------------------------------------------------------
	|
	*/

	private $repository;
	private $nuevosClientes;

	public function __construct(ClienteRepository $cliente,ClienteNuevoRepository $nuevo){
		$this->repository     = $cliente;
		$this->nuevosClientes = $nuevo;
	}

	public function getEncuesta($rut){
		$cliente = $this->repository->findByRut($rut);
		$cliente = (is_null($cliente)) ? $this->nuevosClientes->findByRut($rut) : $cliente;
		if(!is_null($cliente)){
			$encuesta = '';
			//Evaluamos si han pasado dos meses desde la ultima respuesta
			// $ultimaRespuesta = Respuesta::where('rut_cliente','=',$rut)
			// 	->orderBy('created_at','desc')
			// 	->first();

			// $dosMeses = (time() + (60 * 24 * 60 * 60)) - time();
			// if( is_null($ultimaRespuesta) || ((time() - $ultimaRespuesta->created_at->getTimestamp()) > $dosMeses) ){
			$superlog = SuperLog::where('rut','=',$rut)
				->where('tipo','=','encuesta_alm')
				->get();

			if( count($superlog) == 0 ){
				//Sacamos los IDs de encuestas que ya respondio
				$IDsResuletos = [];
				$encuestas = Respuesta::where('rut_cliente','=',$rut)
					->groupBy('encuesta_id')
					->get();

				foreach ($encuestas as $encuesta){
					array_push($IDsResuletos, $encuesta->id);
				}

				//Verificamos si hay encuestas listas
				$encuestas = Encuesta::where('disponible','=',true)
					->whereNotIn('id',$IDsResuletos)
					->get();
				if(count($encuestas) > 0){
					$encuesta = $encuestas->random();

					$encuesta->alternativas->each(function($index){
						$index->id = \Crypt::encrypt($index->id);
					})->toArray();
					$encuesta->id = \Crypt::encrypt($encuesta->id);
					$response = $encuesta->toArray();
					$response['rut'] = $rut;
					$response['_token'] = csrf_token();
					$status = 200;
				}
				else{
					$response = [
						'error' => 'No existen encuestas disponibles para ti'
					];
					$status = 200;
				}
			}
			else{
				$response = [
					'error' => 'Usted ya respondio una encuesta, debe esperar que sea habilitado nuevamente para consultar esta sección.'
				];
				$status = 200;
			}
		}
		else{
			$response = [
				'error' => 'EL RUT indicado no se encuentra en los registros'
			];
			$status = 200;
		}
		return response()->json($response,$status);
	}

	public function saveEncuesta(){
		if( \Request::input('rut', false) ){
			if( \Request::input('encuesta', false) ){
				$pase = true;
				try {
					$idEncuesta = \Crypt::decrypt(\Request::input('encuesta'));
				}catch (\Exception $e){
					$response = [
						'error' => 'El ID de encuesta es invalido'
					];
					$status = 200;
					$pase = false;
				}

				//Validar rut y encuesta
				if( $pase && \Request::input('preguntas', false) && is_array(\Request::input('preguntas')) && count(\Request::input('preguntas')) > 0 ){
					$rut = \Request::input('rut');
					$values = [
						'rut' => $rut,
						'encuesta' => $idEncuesta
					];
					$rules = [
						'rut' => 'required|exists:registro_usuario,rut',
						'encuesta' => 'required|numeric|exists:almaceneros_encuesta,id'
					];

					//Extraemos las preguntas
					$keys = [];
					$preguntas = \Request::input('preguntas');
					foreach ($preguntas as $key => $value){
						$idPregunta = \Crypt::decrypt($key);
						if( !in_array($idPregunta, $keys) ){
							try {
								$values['pregunta'.$idPregunta] = $idPregunta;
								$rules['pregunta'.$idPregunta]  = 'required|numeric|exists:almaceneros_encuesta_alternativas,id';								
							} catch (\Exception $e) {
								$pase = false;
								$response = [
									'error' => 'IDs de preguntas no son validos.'
								];
								$status = 200;
								break;
							}
							array_push($keys, $idPregunta);
						}
					}

					//No hubo exeociones en las preguntas
					if( $pase ){
						//Validamos toda la data
						$validator = \Validator::make($values, $rules);

						if( $validator->passes() ){

							foreach ($preguntas as $id => $pregunta){
								$respuesta = new Respuesta();
								$idPregunta = \Crypt::decrypt($id);

								//Asignamos la respuesta correcta, si es un checkbox es una respuesta multiple separada por '|'
								if( $pregunta['type'] != 'text' ){
									if( $pregunta['type'] == 'checkbox' ){
										$agregarOtroValor = false;
										$valorPorPregunta = '';
										if( array_key_exists('value', $pregunta) ){
											foreach ($pregunta['value'] as $option) {
												if( trim(strtolower($option)) == 'otro' && !$agregarOtroValor ){
													$agregarOtroValor = true;
												}
												else{
													$valorPorPregunta .= $option.'|' ;
												}
											}											
										}
										if( $agregarOtroValor ){
											$valorPorPregunta .= $pregunta['comment'] ;
										}
										$valorPorPregunta = rtrim($valorPorPregunta,'|');
									}
									else{
										$valorPorPregunta = ( trim(strtolower($pregunta['value'])) == 'otro' ) ? $pregunta['comment'] : $pregunta['value'];
									}
								}
								else{
									$valorPorPregunta = $pregunta['value'];
								}

								//Se asignan valores y se guarda
								$respuesta->respuesta      = $valorPorPregunta;
								$respuesta->alternativa_id = $idPregunta;
								$respuesta->rut_cliente    = $rut;
								$respuesta->encuesta_id    = $idEncuesta;
								$respuesta->save();
							}

							$log         = new Log();
							$log->rut    = $rut;
							$log->puntos = 100;
							$log->log    = "Encuesta contestada";
							$log->save();

							//Guardamos el SuperLog
							$superlog       = new SuperLog();
							$superlog->rut  = $rut;
							$superlog->tipo = 'encuesta_alm';
							$superlog->save();

							$response = [
								'status' => true
							];
							$status = 200;
						}
						else{
							$response = [
								'error' => 'Ocurrieron errores en la validacion de la encuesta',
								'messages' => $validator->errors()
							];
							$status = 200;
						}
					}
				}
			}
			else{
				$response = [
					'error' => 'Debe indicar el campo encuesta'
				];
				$status = 200;
			}
		}
		else{
			$response = [
				'error' => 'Debe indicar el RUT del cliente que esta participando'
			];
			$status = 200;
		}
		return response()->json($response,$status);
	}
}
