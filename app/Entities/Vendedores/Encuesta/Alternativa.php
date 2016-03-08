<?php namespace MeLaJuego\Entities\Vendedores\Encuesta;

use Illuminate\Database\Eloquent\Model;

class Alternativa extends Model{

	protected $table = 'ganapuntos_encuesta_alternativas';

	public function encuesta(){
        return $this->hasOne('MeLaJuego\Entities\Vendedores\Encuesta\Encuesta');
    }
}
