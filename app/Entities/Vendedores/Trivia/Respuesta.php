<?php namespace MeLaJuego\Entities\Vendedores\Trivia;

use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model{

	protected $table = 'ganapuntos_trivia_respuestas';

	public function pregunta(){
        return $this->hasOne('MeLaJuego\Entities\Vendedores\Trivia\Pregunta','id','pregunta_id');
    }
}
