<?php namespace MeLaJuego\Entities\Vendedores;

use Illuminate\Database\Eloquent\Model;

class Canje extends Model{

	protected $table = 'canje_vendedor';
	protected $primaryKey = 'can_id';

	public function cliente(){
        return $this->hasOne('MeLaJuego\Entities\Vendedores\User','rut','can_id_registro');
    }

    public function producto(){
        return $this->hasOne('MeLaJuego\Entities\Vendedores\Producto','pro_id','can_id_producto');
    }
}
