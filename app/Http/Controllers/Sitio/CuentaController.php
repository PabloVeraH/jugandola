<?php namespace MeLaJuego\Http\Controllers\Sitio;

use MeLaJuego\Http\Controllers\Controller;
use MeLaJuego\Repositories\ClienteRepository;
use MeLaJuego\Repositories\ProductosRepository;

class CuentaController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Cuenta Controller
	|--------------------------------------------------------------------------
	|
	*/

	private $clientes;
	private $productos;

	public function __construct(ClienteRepository $cliente, ProductosRepository $productos){
		$this->clientes  = $cliente;
		$this->productos = $productos;
	}

	/**
	 * Renderiza la vista que 
	 *
	 * @return Response
	 */
	public function tuCuenta(){
		return view('cuenta.tu-cuenta');
	}

	public function tusPuntos(){
		//Sacamos los puntos
		$clientes = \Auth::user()->clientes;
		$puntos = 0;
		foreach ($clientes as $cliente){
			$informacion = $this->clientes->getInformacion($cliente,12,true);
			$puntos += $informacion['puntos'];
		}
		foreach (\Auth::user()->logsJuego as $juego){
			$puntos += $juego->puntos;
		}

		//Sacando los canjes
		$gastados = 0;
		$canjes = 0;
		if(\Auth::user()->canjes){
			foreach (\Auth::user()->canjes as $canje){
				$canjes++;
				$gastados += $canje->producto->pro_puntos;
			}
		}

		//Sacando el producto mas cercano a cobrar segun sus puntos
		$producto = $this->productos->getCercanoACobrar($puntos - $gastados);

		return view('cuenta.tus-puntos',[
			'puntos'   => $puntos,
			'gastados' => $gastados,
			'canjes'   => $canjes,
			'producto' => $producto
		]);
	}

	public function ganaPuntos(){
		return view('gana-puntos.gana-puntos');
	}

}
