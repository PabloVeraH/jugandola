<?php namespace MeLaJuego\Entities\Almaceneros\Trivia;

use Illuminate\Database\Eloquent\Model;

class Opcion extends Model{

	protected $table = 'almaceneros_trivia_opciones';

	public function pregunta(){
        return $this->hasOne('MeLaJuego\Entities\Almaceneros\Trivia\Pregunta');
    }
}
