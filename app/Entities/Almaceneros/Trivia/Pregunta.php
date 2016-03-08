<?php namespace MeLaJuego\Entities\Almaceneros\Trivia;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model{

	protected $table = 'almaceneros_trivia_preguntas';

	public function trivia(){
        return $this->hasOne('MeLaJuego\Entities\Almaceneros\Trivia\Trivia');
    }

    public function respuesta(){
        return $this->hasOne('MeLaJuego\Entities\Almaceneros\Trivia\Opcion');
    }

    public function opciones(){
        return $this->hasMany('MeLaJuego\Entities\Almaceneros\Trivia\Opcion','pregunta_id');
    }
}
