<?php

class ExamePredefinido extends Eloquent {

	public $timestamps  = false;

  protected $table    = 'exames_predefinidos';

  protected $fillable = array('tipo_exame_predefinido_id','tipo_exame_id');

	public function tipoExamePredefinido(){
		return $this->belongsTo('TipoExamePredefinido');
	}

  public function tipoExame(){
    return $this->belongsTo('TipoExame');
  }

}
