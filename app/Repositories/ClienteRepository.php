<?php namespace MeLaJuego\Repositories;

use MeLaJuego\Entities\Vendedores\User;
use MeLaJuego\Entities\Vendedores\Canje;
use MeLaJuego\Entities\Vendedores\Producto;
use MeLaJuego\Entities\Almaceneros\Cliente;
use MeLaJuego\Entities\Almaceneros\ClienteNuevo;

class ClienteRepository extends BaseRepository{

	private $entity;
	private $vendedor;
	private $canje;
	private $producto;
	
	function __construct(Cliente $entity,User $vendedor,Canje $canje,Producto $producto){
		$this->entity   = $entity;
		$this->vendedor = $vendedor;
		$this->producto = $producto;
		$this->canje    = $canje;
	}

	public function all(){
		return $this->entity->all();
	}

	public function findByRut($rut){
		return $this->entity->where('rut_cliente','=',$rut)->first();
	}

	public function getInformacion($entity = null,$meses = 12,$tomarSoloDesdeSeptiembre = false){
		$response = [
			'periodo'                => 0, // Acumulados del periodo, este es el bruto
			'total'                  => 0, // Acumulados y restados, estos son los neto
			'acumuladoPuntosMeses'   => 0, // Acumulados de puntos de los meses solicitadis
			'totalMeses'             => 0, // Acumulados de puntos de los meses solicitadis
			'puntos'                 => 0, // La suma de puntos normales y especiales, mas los extra
			'puntosNormales'         => 0, // Los puntos nomrlaes
			'puntosEspeciales'       => 0, // Los puntos especiales
			'puntosExtra'            => 0, // Los puntos extra
			'canjesEfectuados'       => 0, // EL numerp de cajes efectuados
			'puntosCanjesEfectuados' => 0, // Los puntos gastados por los canjes
			'canjesEspera'           => 0, // El numero de canjes en espera
			'puntosCanjesEspera'     => 0  // Los puntos gastados por la cola de espera
		];
		
		if($entity instanceOf Cliente){
			// if(is_numeric($meses)){
			// 	for ($i=0; $i < $meses; $i++){
			// 		$response['total']            += $entity->{"ptos_normal".(12-$i)} + $entity->{"ptos_estrellas".(12-$i)};
			// 		$response['puntosNormales']   += $entity->{"ptos_normal".(12-$i)};
			// 		$response['puntosEspeciales'] += $entity->{"ptos_estrellas".(12-$i)};
			// 		$response['puntos']           += round( ($entity->{"ptos_normal".(12-$i)} / 150) , 0) + round( ($entity->{"ptos_estrellas".(12-$i)} / 75) , 0);
			// 		$response['periodo']          += $entity->{"ptos_normal".(12-$i)} + $entity->{"ptos_estrellas".(12-$i)};
			// 	}
			// }
			// else{
				for ($i=1; $i < 13; $i++){
					$fecha = explode('/', $entity->{"mes".$i});
					if( $tomarSoloDesdeSeptiembre && ( ((int)$fecha[1] <= 9 && (int)$fecha[2] <= 15) || ( (int)$fecha[2] < 15) ) ){
						continue;
					}
					$response['total']            += $entity->{"ptos_normal".$i} + $entity->{"ptos_estrellas".$i};
					$response['puntosNormales']   += $entity->{"ptos_normal".$i};
					$response['puntosEspeciales'] += $entity->{"ptos_estrellas".$i};
					$response['puntos']           += round( ($entity->{"ptos_normal".$i} / 150) , 0) + round( ($entity->{"ptos_estrellas".$i} / 75) , 0);
					if( (int)date('m') == $i ){
						$response['periodo'] = $entity->{"ptos_normal".$i} + $entity->{"ptos_estrellas".$i};
					}
					if( is_numeric($meses) && $meses > 0 ){
						$response['acumuladoPuntosMeses'] += round( ($entity->{"ptos_normal".(13-$i)} / 150) , 0) + round( ($entity->{"ptos_estrellas".(13-$i)} / 75) , 0);
						$response['totalMeses']           += $entity->{"ptos_normal".(13-$i)} + $entity->{"ptos_estrellas".(13-$i)};
						$meses--;
					}
				}
			// }
		}
		
		//Agregamos los puntos de los juegos
		foreach ($entity->logsJuego as $juego){
			$response['puntos']               += $juego->puntos;
			$response['puntosExtra']          += $juego->puntos;
			$response['periodo']              += $juego->puntos;
			$response['total']                += $juego->puntos;
			$response['acumuladoPuntosMeses'] += $juego->puntos;
			$response['totalMeses']           += $juego->puntos;
		}

		//Verificamos los canjes efectuados
		foreach ($entity->canjes as $canje){
			$response['canjesEfectuados']       = $response['canjesEfectuados'] + 1;
			$response['puntosCanjesEfectuados'] += (!is_null($canje->producto)) ? $canje->producto->pro_puntos : 0;
			$response['total']                  = $response['total'] - ( (!is_null($canje->producto)) ? $canje->producto->pro_puntos : 0);
		}

		//Verificamos los canjes en espera
		foreach ($entity->canjesEnEspera as $canje){
			$response['canjesEspera']       = $response['canjesEspera'] + 1;
			$response['puntosCanjesEspera'] += (!is_null($canje->producto)) ? $canje->producto->pro_puntos : 0;
			$response['total']              = $response['total'] - ( (!is_null($canje->producto)) ? $canje->producto->pro_puntos : 0);
		}


		return $response;
	}
}