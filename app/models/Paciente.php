<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Paciente extends Eloquent {

	use SoftDeletingTrait;

  protected $table    = 'pacientes';

  protected $fillable = array('nome','sus','sem_sus','nome_mae',
															'data_nascimento','email','tipo_sexo_id'
														  );

	public function sexo() {
    return $this->belongsTo('TipoSexo','tipo_sexo_id');
  }

	public function solicitacao(){
		return $this->hasMany('Solicitacao');
	}

	public function endereco(){
		return $this->hasOne('Endereco');
	}

	public function telefones(){
		return $this->hasMany('Telefone');
	}

	public function getDataNascimentoAttribute(){
		if($this->attributes['data_nascimento'] != null){
			return FormatterHelper::dateToPtBR($this->attributes['data_nascimento']);
		}
	}

	public function setDataNascimentoAttribute($data){
			$this->attributes['data_nascimento'] = FormatterHelper::dateToMySQL($data);
	}

	public function setSusAttribute($sus){
			$this->attributes['sus'] = FormatterHelper::somenteNumeros($sus);
	}

	public function getSusAttribute(){
		if($this->attributes['sus'] != null){
				$num0 = substr($this->attributes['sus'],0,3);
				$num1 = substr($this->attributes['sus'],3,4);
				$num2 = substr($this->attributes['sus'],7,4);
				$num3 = substr($this->attributes['sus'],11);
			}
		return $num0." ".$num1." ".$num2." ".$num3 ;
	}

}
