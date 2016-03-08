<?php namespace MeLaJuego\Http\Controllers\Sitio;

use MeLaJuego\Http\Controllers\Controller;
use MeLaJuego\Repositories\ProductosRepository;
use MeLaJuego\Repositories\ClienteRepository;
use MeLaJuego\Entities\Vendedores\Producto;
use MeLaJuego\Entities\Vendedores\Canje;

class CatalogoController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Productos Controller
	|--------------------------------------------------------------------------
	|
	*/

	private $productos;
	private $clientes;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(ProductosRepository $productos,ClienteRepository $clientes){
		$this->productos = $productos;
		$this->clientes  = $clientes;
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function catalogo(){
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

		//Sacamos los productos
		$productos = $this->productos->paginate(8,['pro_puntos','asc']);

		return view('catalogo.catalogo',[
			'puntos'    => 0,//$puntos-$gastados,
			'productos' => $productos
		]);
	}

	public function producto($encryptedId){
		try {
			$id = \Crypt::decrypt($encryptedId);
			$producto = $this->productos->find($id,'pro_id');

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
			
			if($producto instanceOf Producto){
				return view('catalogo.detalle-producto',[
					'producto' => $producto,
					'puntos'   => 0//$puntos-$gastados
				]);
			}
			abort(404);

		}catch (\Exception $e){
			abort(404);			
		}
	}

	public function canjear($encryptedId){
		abort(503);
		try {
			$id = \Crypt::decrypt($encryptedId);
			$producto = $this->productos->find($id,'pro_id');

			if($producto instanceOf Producto){
				try {
					$canje = new Canje();
					$canje->can_estado = 0;
					$canje->can_fecha = date('Y-m-d');
					$canje->can_id_producto = $producto->pro_id;
					$canje->can_id_registro = \Auth::user()->rut;
					$canje->save();

					return redirect()->back()
						->with('canje_correcto',true);
				}catch(\Exception $e) {
					return redirect()->back()
						->with('canje_error','Ocurrio un error al momento de generar el canje, intentelo nuevamente.');
				}
			}
			return redirect()->back()
				->with('canje_error','El producto solicitado no existe en nuestros registros.');

		}catch (\Exception $e){
			return redirect()->back()
				->with('canje_error','El producto solicitado no es valido.');
		}
	}

}
