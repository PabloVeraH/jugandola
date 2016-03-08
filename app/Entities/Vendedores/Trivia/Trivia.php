<?php namespace MeLaJuego\Entities\Vendedores\Trivia;

use Illuminate\Database\Eloquent\Model;

class Trivia extends Model{

	protected $table = 'ganapuntos_trivia';

	public function preguntas(){
        return $this->hasMany('MeLaJuego\Entities\Vendedores\Trivia\Pregunta');
    }
}
