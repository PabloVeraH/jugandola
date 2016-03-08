<?php namespace MeLaJuego\Repositories;

use MeLaJuego\Entities\Vendedores\Producto;

class ProductosRepository extends BaseRepository{

	private $entity;
	
	function __construct(Producto $entity){
		$this->entity  = $entity;
	}

	public function all($order = ['id','asc']){
		return $this->entity
			->where('pro_estado','=',true)
			->orderBy($order[0],$order[1])->get();
	}

	public function paginate($limit = 5,$order = ['id','asc']){
		return $this->entity->where('pro_estado','=',true)->orderBy($order[0],$order[1])->paginate($limit);
	}

	public function getCercanoACobrar($puntos){
		if($puntos > 0){
			$producto = $this->entity->where('pro_estado','=',true)->where('pro_puntos','<=',$puntos)->orderByRaw("RAND()")->first();
			if($producto){
				return $producto;
			}
			else{
				$producto = $this->entity->where('pro_estado','=',true)->where('pro_puntos','>',$puntos)->orderByRaw("RAND()")->first();
				if($producto){
					return $producto;
				}	
			}
		}
		return $this->entity->where('pro_estado','=',true)->orderByRaw("RAND()")->first();
	}

	public function find($value, $key = 'id'){
		return $this->entity->where($key,'=',$value)->first();
	}
}