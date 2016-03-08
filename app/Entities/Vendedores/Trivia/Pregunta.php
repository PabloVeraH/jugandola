<?php namespace MeLaJuego\Entities\Vendedores\Trivia;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model{

	protected $table = 'ganapuntos_trivia_preguntas';

	public function trivia(){
        return $this->hasOne('MeLaJuego\Entities\Vendedores\Trivia\Trivia');
    }
}
