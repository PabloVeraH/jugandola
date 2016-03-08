<?php namespace MeLaJuego\Entities\Vendedores\Encuesta;

use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model{

	protected $table = 'ganapuntos_encuesta_respuestas';

	public function alternativa(){
        return $this->hasMany('MeLaJuego\Entities\Vendedores\Encuesta\Alternativa');
    }
}
