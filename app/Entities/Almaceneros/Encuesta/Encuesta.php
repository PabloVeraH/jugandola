<?php namespace MeLaJuego\Entities\Almaceneros\Encuesta;

use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model{

	protected $table = 'almaceneros_encuesta';

	public function alternativas(){
        return $this->hasMany('MeLaJuego\Entities\Almaceneros\Encuesta\Alternativa','encuesta_id','id')->orderBy('almaceneros_encuesta_alternativas.orden','ASC');
    }
}
