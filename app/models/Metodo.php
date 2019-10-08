<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Metodo extends Eloquent {

	use SoftDeletingTrait;

	public $timestamps = false;

  protected $table    = 'tipo_metodo';

	protected $hidden   = array();

  protected $fillable = array('nome');

  protected $guarded  = array();

  public function tipoExame() {
    return $this->hasOne('TipoExame','id','metodo_id');
  }
}
