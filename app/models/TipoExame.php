<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoExame extends Eloquent {

	use SoftDeletingTrait;

  public $timestamps  = false;

  protected $dates = ['deleted_at'];

  protected $table    = 'tipo_exame';

  protected $fillable = array('tipo','metodo_id','abreviacao'
														  );

  protected $guarded  = array();

	public function exame() {
    return $this->hasOne('Exame');
  }

	public function metodo(){
		return $this->hasOne('Metodo','id','metodo_id');
	}

}
