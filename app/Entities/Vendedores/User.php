<?php namespace MeLaJuego\Entities\Vendedores;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	protected $table = 'usuario_ven_edd';
	protected $primaryKey = 'rut';

	public function clientes(){
        return $this->hasMany('MeLaJuego\Entities\Almaceneros\Cliente','rut_vendedor','rut');
    }

    public function logsJuego(){
        return $this->hasMany('MeLaJuego\Entities\Vendedores\LogVendedor','rut','rut');
    }

    public function canjes(){
        return $this->hasMany('MeLaJuego\Entities\Vendedores\Canje','can_id_registro','rut');
    }

	public function getAuthPassword(){
		return \Hash::make($this->contrasena);
	}

	public function getRememberToken(){
	   return null; // not supported
	}

	public function setRememberToken($value){
	   // not supported
	}

	public function getRememberTokenName(){
	   return null; // not supported
	}

	/**
	 * Overrides the method to ignore the remember token.
	 */
	public function setAttribute($key, $value){
	   	$isRememberTokenAttribute = $key == $this->getRememberTokenName();
	   	if (!$isRememberTokenAttribute){
	     	parent::setAttribute($key, $value);
	   	}
	}
}
