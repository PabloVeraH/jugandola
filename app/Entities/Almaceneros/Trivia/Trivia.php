<?php namespace MeLaJuego\Entities\Almaceneros\Trivia;

use Illuminate\Database\Eloquent\Model;

class Trivia extends Model{

	protected $table = 'almaceneros_trivia';

	public function preguntas(){
        return $this->hasMany('MeLaJuego\Entities\Almaceneros\Trivia\Pregunta');
    }
}
