<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Endereco extends Eloquent{

		use SoftDeletingTrait;

		public $timestamps  = false;
  	protected $table    = 'enderecos';
    protected $fillable = array(
								'cep', 'numero', 'estado_uf',
								'logradouro', 'complemento',
								'cidade_id', 'tipo_logradouro_id',
								'bairro', 'paciente_id',
								'latitude', 'longitude'
							);

    public function paciente(){
      return $this->belongsTo('Paciente');
    }

    public function cidade(){
      return $this->belongsTo('Cidade');
    }

		public function setCepAttribute($cep){
			$this->attributes['cep'] = FormatterHelper::somenteNumeros($cep);
		}

		public function getCepAttribute(){
			if($this->attributes['cep'] != null && $this->attributes['cep'] != 0){
				if(strlen($this->attributes['cep'] > 7)){
					$num1 = substr($this->attributes['cep'],0,5);
					$num2 = substr($this->attributes['cep'],5);
				}
				return $num1."-".$num2 ;
			}
		}

}
