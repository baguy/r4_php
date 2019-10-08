<?php

class TipoAmostra extends Eloquent {

  public $timestamps  = false;

  protected $dates = ['deleted_at'];

  protected $table    = 'tipo_amostra';

  protected $fillable = array('tipo');

  protected $guarded  = array();

	public function exame() {
    return $this->hasOne('Exame');
  }

}
