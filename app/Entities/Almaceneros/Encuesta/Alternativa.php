<?php namespace MeLaJuego\Entities\Almaceneros\Encuesta;

use Illuminate\Database\Eloquent\Model;

class Alternativa extends Model{

	protected $table = 'almaceneros_encuesta_alternativas';

	public function encuesta(){
        return $this->hasOne('MeLaJuego\Entities\Almacenero\Encuesta\Encuesta');
    }
}
