<?php

class TipoReagente extends Eloquent {

  public $timestamps  = false;

  protected $table    = 'tipo_reagente';

  protected $fillable = array('tipo'
														  );

  protected $guarded  = array();

	public function laudo() {
    return $this->hasOne('Exame');
  }

}
