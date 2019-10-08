<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Status extends Eloquent {

	use SoftDeletingTrait;

  protected $table    = 'tipo_status';

  protected $fillable = array('tipo');

  protected $guarded  = array();

	public function exame() {
    return $this->hasOne('Exame');
  }

}
