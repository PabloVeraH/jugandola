<?php namespace MeLaJuego\Entities\Almaceneros\Encuesta;

use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model{

	protected $table = 'almaceneros_encuesta_respuestas';

	public function alternativa(){
        return $this->hasMany('MeLaJuego\Entities\Almaceneros\Encuesta\Alternativa');
    }

    public function encuesta(){
        return $this->hasOne('MeLaJuego\Entities\Almacenero\Encuesta\Encuesta');
    }
}
