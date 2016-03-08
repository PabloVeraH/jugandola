<?php namespace MeLaJuego\Entities\Almaceneros;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model{

	protected $table = 'lista_cliente';
	protected $primaryKey = 'id';

	public function vendedor(){
        return $this->belongsTo('MeLaJuego\Entities\Vendedores\User','rut_vendedor','rut');
    }

    public function canjes(){
        return $this->hasMany('MeLaJuego\Entities\Almaceneros\CanjeCliente','rut','rut_cliente')->where('canje.can_estado','=',1);
    }

    public function canjesEnEspera(){
        return $this->hasMany('MeLaJuego\Entities\Almaceneros\CanjeCliente','rut','rut_cliente')->where('canje.can_estado','=',0);
    }

    public function logsJuego(){
        return $this->hasMany('MeLaJuego\Entities\Almaceneros\LogCliente','rut','rut');
    }

}
