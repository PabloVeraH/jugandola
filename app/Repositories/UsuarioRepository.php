<?php namespace MeLaJuego\Repositories;

use MeLaJuego\Entities\Vendedores\User;
use MeLaJuego\Entities\Almaceneros\Cliente;

class UsuarioRepository extends BaseRepository{

	private $entity;
	private $cliente;
	
	function __construct(User $entity,Cliente $cliente){
		$this->entity  = $entity;
		$this->cliente = $cliente;
	}

	public function all(){
		return $this->entity->all();
	}
}