<?php namespace MeLaJuego\Entities\Almaceneros\Trivia;

use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model{

	protected $table = 'almaceneros_trivia_respuestas';

	public function pregunta(){
        return $this->hasOne('MeLaJuego\Entities\Almaceneros\Trivia\Pregunta','id','pregunta_id');
    }
}
