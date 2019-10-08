<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoStatus extends Eloquent {

	use SoftDeletingTrait;

  public $timestamps  = false;

  protected $table    = 'tipo_status';

  protected $fillable = array('tipo'
														  );

  protected $guarded  = array();

	public function exame() {
    return $this->hasOne('Exame');
  }

}
