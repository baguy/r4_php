<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoSexo extends Eloquent {

	use SoftDeletingTrait;

  protected $table   = 'tipo_sexo';

  protected $guarded = array('tipo');

	public function paciente(){
		return $this->hasOne('Paciente');
	}

}
