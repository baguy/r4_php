<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Exame extends Eloquent {

	use SoftDeletingTrait;

	public $timestamps  = false;

  protected $table    = 'exames';

  protected $fillable = array('solicitacao_id','tipo_status_id',
															'tipo_exame_id','tipo_amostra_id');

  public function solicitacao() {
    return $this->belongsTo('Solicitacao');
  }

	public function tipoStatus(){
		return $this->belongsTo('TipoStatus');
	}

	public function tipoExame(){
		return $this->belongsTo('TipoExame');
	}

	public function tipoAmostra(){
		return $this->belongsTo('TipoAmostra');
	}

	public function laudo(){
		return $this->hasOne('Laudo','exame_id','id');
	}

}
