<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Unidade extends Eloquent {

	use SoftDeletingTrait;

  protected $table    = 'unidades';

	protected $hidden   = array();

  protected $fillable = array('nome', 'email');

  public function solicitacoes(){
		return $this->hasMany('Solicitacao');
	}

}
