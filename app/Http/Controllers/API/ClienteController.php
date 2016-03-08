<?php namespace MeLaJuego\Http\Controllers\API;

use MeLaJuego\Http\Controllers\Controller;
use MeLaJuego\Repositories\ClienteRepository;
use MeLaJuego\Repositories\ClienteNuevoRepository;
use MeLaJuego\Entities\Almaceneros\TipoCliente;
use MeLaJuego\Entities\Almaceneros\Encuesta\Respuesta;
use MeLaJuego\Entities\Almaceneros\Encuesta\Encuesta;

class ClienteController extends Controller {

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

	/**
	 * Devuelve el tipo de cliente
	 *
	 * @return Response
	 */
	public function tipoSocio($rut){
		$cliente = $this->nuevosClientes->findByRut($rut);
		$prosige = false;
		$rango   = null;
		$meses   = 3;
		//Buscar en regitro de usuario
		if(!is_null($cliente)){
			//Agregamos los puntos de los juegos
			$listaCliente = $this->repository->findByRut($rut);
			$informacion = (is_null($listaCliente)) ? $this->repository->getInformacion($cliente,$meses) : $this->repository->getInformacion($listaCliente,$meses);
			$rango = ($cliente->precargado == 0 || ($cliente->precargado == 1 && $cliente->distribuidor == 5) ) ? $this->getNivelSegunRango($informacion['periodo']) : 'bronce';
			if($rango == 'bronce'){
				$rango = $this->getNivelSegunRango($informacion['totalMeses']);
				$rango = ( $rango != 'invitado' ) ? $rango : 'bronce';
			}

			$prosige = true;
			$status = 200;
		}
		else{
			$response = [
				'error' => 'El RUT de cliente no se encuentra disponible'
			];
			$status = 400;				
		}

		if($prosige){
			$tipoSocio = TipoCliente::where('slug','=',$rango)->first();
			if(!is_null($tipoSocio)){
				$response = [
					//Informcion de Nivel
					'imagen'                 => $tipoSocio->img,
					'titulo'                 => $tipoSocio->nombre,
					'idTipo'                 => $tipoSocio->id,
					//Informacion de usuairo
					'idRegistroUsuario'      => $cliente->id,
					'nombres'                => $cliente->nombres,
					'apellidos'              => $cliente->apellidos,
					'sexo'                   => $cliente->sexo,
					'fechaNacimiento'        => $cliente->fecha_nac,
					'email'                  => $cliente->email,
					'estadoCivil'            => $cliente->estadocivil,
					'direccionPersonal'      => $cliente->direccionpersonal,
					'direccionPersonalPobla' => $cliente->direccionpersonalpobla,
					'region'                 => $cliente->region,
					'comuna'                 => $cliente->comuna,
					'celular'                => $cliente->celular,
					'rutNegocio'             => $cliente->rutnegocio,
					'almacen'                => $cliente->almacen,
					'fonoAlmacen'            => $cliente->fonoalmacen,
					'razonSocial'            => $cliente->razonsocial,
					'direccionAlmacen'       => $cliente->direccionalmacen,
					'regionAlmacen'          => $cliente->regionalmacen,
					'comunaAlmacen'          => $cliente->comunaalmacen,
					'distribuidor'           => $cliente->distribuidor,
					'precargado'             => $cliente->precargado,
					'estado'                 => $cliente->estado,
					'fechaRegistro'          => $cliente->fecha_registro,
					'fechaModificacion'      => $cliente->fecha_modificacion,
					'fechaLogin'             => $cliente->fecha_login,
					'registroNuevo'          => $cliente->registronuevo,
					'fechaNuevoForm'         => $cliente->fecha_nuevo_form,
					//Informacion puntos
					'meses'                  => $meses,
					'periodo'                => $informacion['periodo'],
					'total'                  => $informacion['total'],
					'puntos'                 => $informacion['puntos'],
					'puntosNormales'         => $informacion['puntosNormales'],
					'puntosEspeciales'       => $informacion['puntosEspeciales'],
					'puntosExtra'            => $informacion['puntosExtra'],
					'canjesEfectuados'       => $informacion['canjesEfectuados'],
					'puntosCanjesEfectuados' => $informacion['puntosCanjesEfectuados'],
					'canjesEspera'           => $informacion['canjesEspera'],
					'puntosCanjesEspera'     => $informacion['puntosCanjesEspera']
				];
				$status = 200;
			}
			else{
				$response = [
					'error' => 'El tipo de socio '.$rango.' no se encontro en los registros.'
				];
				$status = 400;
			}
		}

		return response()->json($response,$status);
	}

	private function getNivelSegunRango($puntos){
		if($puntos > 1500000){$rango = 'top';}
		else if($puntos >= 750000 && $puntos < 1500000){$rango = 'oro';}
		else if($puntos >= 300000 && $puntos < 750000){$rango = 'plata';}
		else if($puntos >= 150000 && $puntos < 300000){$rango = 'bronce';}
		else{$rango = 'invitado';}
		return $rango;
	}
}
