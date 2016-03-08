<?php namespace MeLaJuego\Http\Controllers\API;

use MeLaJuego\Http\Controllers\Controller;
use MeLaJuego\Repositories\ClienteRepository;
use MeLaJuego\Repositories\ClienteNuevoRepository;
use MeLaJuego\Entities\Almaceneros\Trivia\Respuesta;
use MeLaJuego\Entities\Almaceneros\Trivia\Trivia;
use MeLaJuego\Entities\Almaceneros\LogCliente as Log;
use MeLaJuego\Entities\SuperLog;

class TriviaController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Trivia Controller - API
	|--------------------------------------------------------------------------
	|
	*/

	private $repository;
	private $nuevosClientes;

	public function __construct(ClienteRepository $cliente,ClienteNuevoRepository $nuevo){
		$this->repository     = $cliente;
		$this->nuevosClientes = $nuevo;
	}

	public function getTrivia($rut){
		$cliente = $this->repository->findByRut($rut);
		$cliente = (is_null($cliente)) ? $this->nuevosClientes->findByRut($rut) : $cliente;
		if(!is_null($cliente)){
			$trivia = '';
			//Evaluamos si han pasado dos meses desde la ultima respuesta
			// $ultimaRespuesta = Respuesta::where('rut_cliente','=',$rut)
			//	->orderBy('created_at','desc')
			//	->first();

			// $dosMeses = (time() + (60 * 24 * 60 * 60)) - time();
			// if( is_null($ultimaRespuesta) || ((time() - $ultimaRespuesta->created_at->getTimestamp()) > $dosMeses) ){

			$superlog = SuperLog::where('rut','=',$rut)
				->where('tipo','=','trivia_alm')
				->get();

			if( count($superlog) == 0 ){
				//Sacamos los IDs de trivia que ya respondio
				$IDsResuletos = [];
				$trivias = Respuesta::where('rut_cliente','=',$rut)
					->groupBy('trivia_id')
					->get();

				foreach ($trivias as $trivia){
					array_push($IDsResuletos, $trivia->id);
				}

				//Verificamos si hay trivias listas
				$trivias = Trivia::where('disponible','=',true)
					->whereNotIn('id',$IDsResuletos)
					->get();
				if(count($trivias) > 0){
					$trivia = $trivias->random();

					$trivia->preguntas->each(function($pregunta){
						$pregunta->opciones->each(function($opcion){
							$opcion->id = \Crypt::encrypt($opcion->id);
						});
						$pregunta->id = \Crypt::encrypt($pregunta->id);
					})->toArray();
					$trivia->id = \Crypt::encrypt($trivia->id);
					$response = $trivia->toArray();
					$response['rut'] = $rut;
					$response['_token'] = csrf_token();
					$status = 200;

				}
				else{
					$response = [
						'error' => 'No existen trivias disponibles para ti'
					];
					$status = 200;
				}
			}
			else{
				$response = [
					'error' => 'Usted ya respondio una trivia, debe esperar que sea habilitado nuevamente para consultar esta sección.'
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

	public function saveTrivia(){
		if( \Request::input('datos', false) ){
			$datos = json_decode( \Request::input('datos') );
			
			//Recorremos todo lo que se envio
			$contador = 0;

			foreach ($datos as $fila){
				if( property_exists($fila,'name') && property_exists($fila,'value') ){
					$input = $fila->name;
					$valor = $fila->value;
					//Validamos el cliente
					if( $input == 'rut' ){
						$values['rut'] = $valor;
						$rules['rut']  = 'required|exists:registro_usuario,rut';
						$rut = $valor;
					}
					//Validamos la trivia
					else if( $input == 'trivia' ){
						try {
							$idTrivia         = \Crypt::decrypt($valor);
							$values['trivia'] = $idTrivia;
							$rules['trivia']  = 'required|numeric|exists:almaceneros_trivia,id';
						}catch (\Exception $e){
							$response = [
								'error' => 'El ID de la trivia es invalido'
							];
							$status = 200;
							break;
						}					
					}
					//Validamos la pregunta
					else{
						try {
							$idAlternativa                   = \Crypt::decrypt($input);
							$idOpcion                        = \Crypt::decrypt($valor);
							$values['alternativa'.$contador] = $idAlternativa;
							$values['opcion'.$contador]      = $idOpcion;

							$rules['alternativa'.$contador] = 'required|numeric|exists:almaceneros_trivia_preguntas,id';
							$rules['opcion'.$contador]      = 'required|numeric|exists:almaceneros_trivia_opciones,id';
						}catch (\Exception $e){
							$response = [
								'error' => 'El ID de la trivia es invalido'
							];
							$status = 200;
							break;
						}
					}
				}
				$contador++;
			}

			$validator = \Validator::make($values, $rules);
			if( $validator->passes() ){
				$valoresRespondidos = [];
				foreach ($datos as $fila){
					$input = $fila->name;
					$valor = $fila->value;
					//Agregamos una repsuesta
					if( $input != 'rut' && $input != 'trivia' && $input != '_token' ){
						$idAlternativa = \Crypt::decrypt($input);
						$idOpcion      = \Crypt::decrypt($valor);

						$respuesta              = new Respuesta();
						$respuesta->rut_cliente = $rut;
						$respuesta->trivia_id   = $idTrivia;
						$respuesta->pregunta_id = $idAlternativa;
						$respuesta->respuesta   = $idOpcion;
						$respuesta->save();

						$valoresRespondidos[$idAlternativa] = $idOpcion;
					}
				}

				//Validamos el resultado de la trivia
				$malas      = 0;
				$porcentaje = 0;
				$trivia     = Trivia::find($idTrivia);
				foreach ($trivia->preguntas as $pregunta){
					if( array_key_exists($pregunta->id, $valoresRespondidos) ){
						if( $pregunta->opcion_correcta != $valoresRespondidos[$pregunta->id] ){
							$malas++;
						}
						unset($valoresRespondidos[$pregunta->id]);
					}
					else{
						$malas++;
					}
				}
				$porcentaje = (( count($trivia->preguntas) - $malas ) * 100) / count($trivia->preguntas);

				//Guardamos el Log de lo realizado
				$log         = new Log();
				$log->rut    = $rut;
				$log->puntos = ( $porcentaje >= 60 ) ? 75 : 0;
				$log->log    = "Trivia contestada";
				$log->save();

				//Guardamos el SuperLog
				$superlog       = new SuperLog();
				$superlog->rut  = $rut;
				$superlog->tipo = 'trivia_alm';
				$superlog->save();

				$response = [
					'status'     => true,
					'porcentaje' => $porcentaje
				];
				$status = 200;
			}
			else{
				$response = [
					'error' => 'Ocurrieron errores en la validacion de la trivia',
					'messages' => $validator->errors()
				];
				$status = 200;
			}
		}
		else{
			$response = [
				'error' => 'No se envio información para procesar.'
			];
			$status = 200;
		}
		return response()->json($response,$status);
	}
}
