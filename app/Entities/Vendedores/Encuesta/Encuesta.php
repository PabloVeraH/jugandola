<?php namespace MeLaJuego\Entities\Vendedores\Encuesta;

use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model{

	protected $table = 'ganapuntos_encuesta';

	public function alternativas(){
        return $this->hasMany('MeLaJuego\Entities\Vendedores\Encuesta\Alternativa','encuesta_id','id');
    }
}
