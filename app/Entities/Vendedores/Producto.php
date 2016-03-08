<?php namespace MeLaJuego\Entities\Vendedores;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model{

	protected $table = 'producto_vendedor';
	protected $primaryKey = 'pro_id';

}
