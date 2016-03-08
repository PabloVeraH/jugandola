<?php namespace MeLaJuego\Http\Controllers\Sitio;

use MeLaJuego\Http\Controllers\Controller;
use MeLaJuego\Repositories\ClienteRepository;

class ClienteController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Cliente Controller
	|--------------------------------------------------------------------------
	|
	*/

	private $repository;

	public function __construct(ClienteRepository $cliente){
		$this->repository = $cliente;
	}

	/**
	 * Despliega el detalle de un cliente
	 *
	 * @return Response
	 */
	public function ficha($rut){
		$cliente = $this->repository->findByRut($rut);
		if(!is_null($cliente) && $cliente->vendedor->rut == \Auth::user()->rut){
			$informacion = $this->repository->getInformacion($cliente,3);
			return view('clientes.ficha-cliente',[
				'cliente'      => $cliente,
				'total'        => $informacion['total'],
				'delmes'       => $informacion['totalMeses'],
				'puntos'       => $informacion['puntos'] - $informacion['puntosCanjesEspera'] - $informacion['puntosCanjesEfectuados'],
				'imagen_nivel' => $this->getImagenNivel($informacion['totalMeses'])
			]);
		}

		return redirect()->route('tu_cuenta')->with([
            'error_message' => 'El RUT indicado no esta asociado a alguno de sus clientes.',
        ])
        ->withInput();
	}

	private function getImagenNivel($puntos){
		if($puntos > 1500000){$imagen = 'socio_top.png';}
		else if($puntos >= 750000 && $puntos < 1500000){$imagen = 'socio_oro.png';}
		else if($puntos >= 300000 && $puntos < 750000){$imagen = 'socio_plata.png';}
		else if($puntos >= 150000 && $puntos < 300000){$imagen = 'socio_bronce.png';}
		else{$imagen = 'socio_invitado.png';}
		return $imagen;
	}

	public function detalle($rut){
		$cliente = $this->repository->findByRut($rut);
		if(!is_null($cliente) && $cliente->vendedor->rut == \Auth::user()->rut){
			return view()->make('clientes.facturacion-cliente',[
				'cliente'      => $cliente
			]);
		}
		return redirect()->route('tu_cuenta')->with([
            'error_message' => 'El RUT indicado no esta asociado a alguno de sus clientes.',
        ])
        ->withInput();
	}

}
