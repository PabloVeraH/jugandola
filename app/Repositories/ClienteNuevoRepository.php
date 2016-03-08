<?php namespace MeLaJuego\Repositories;

use MeLaJuego\Entities\Vendedores\User;
use MeLaJuego\Entities\Vendedores\Canje;
use MeLaJuego\Entities\Vendedores\Producto;
use MeLaJuego\Entities\Almaceneros\ClienteNuevo;

class ClienteNuevoRepository extends BaseRepository{

	private $entity;
	private $vendedor;
	private $canje;
	private $producto;
	
	function __construct(ClienteNuevo $entity,User $vendedor,Canje $canje,Producto $producto){
		$this->entity   = $entity;
		$this->vendedor = $vendedor;
		$this->producto = $producto;
		$this->canje    = $canje;
	}

	public function all(){
		return $this->entity->all();
	}

	public function findByRut($rut){
		return $this->entity->where('rut','=',$rut)->first();
	}
}