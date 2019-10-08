<?php

class TipoExamePredefinido extends Eloquent {

  public $timestamps  = false;

  protected $table    = 'tipo_exame_predefinido';

  protected $fillable = array('tipo');

  protected $guarded  = array();

	public function examePredefinido() {
    return $this->hasOne('ExamePredefinido');
  }

}
