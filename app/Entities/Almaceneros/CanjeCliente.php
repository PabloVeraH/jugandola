<?php namespace MeLaJuego\Entities\Almaceneros;

use Illuminate\Database\Eloquent\Model;

class CanjeCliente extends Model{

	protected $table = 'canje';
	protected $primaryKey = 'can_id';

	public function cliente(){
        return $this->hasOne('MeLaJuego\Entities\Almaceneros\Cliente','rut_cliente','can_id_registro');
    }

    public function producto(){
        return $this->hasOne('MeLaJuego\Entities\Almaceneros\Producto','pro_id','can_id_producto');
    }
}
