<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Telefone extends Eloquent {

  use SoftDeletingTrait;

  	protected $table    = 'telefones';
    protected $fillable = array('numero', 'paciente_id', 'tipo_telefone_id');

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

    public function tipoTelefone(){
      return $this->belongsTo('TipoTelefone', 'id', 'tipo_telefone_id');
    }

		public function setNumeroAttribute($numero){
			$this->attributes['numero'] = FormatterHelper::somenteNumeros($numero);
		}

    public function getNumeroAttribute(){
      if($this->attributes['numero'] != null){
        $tamanho = strlen($this->attributes['numero']);
        if($tamanho == 11){
          $ddd = substr($this->attributes['numero'],0,2);
          $num1 = substr($this->attributes['numero'],2,5);
          $num2 = substr($this->attributes['numero'],7);
        }else{
          $ddd = substr($this->attributes['numero'],0,2);
          $num1 = substr($this->attributes['numero'],2,4);
          $num2 = substr($this->attributes['numero'],6);
        }
  		}
      return "(".$ddd.")".$num1."-".$num2 ;
    }
}
