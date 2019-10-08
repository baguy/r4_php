<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Solicitacao extends Eloquent {

	use SoftDeletingTrait;

  protected $table    = 'solicitacoes';

  protected $fillable = array(
    'paciente_id',
    'unidade_id',
    'user_id',
    'medico_id',
		'data_coleta',
		'numero'
  );

  protected $guarded  = array();

  protected $dates    = ['deleted_at'];

  public function exames() {
    return $this->hasMany('Exame');
  }

  public function paciente() {
    return $this->belongsTo('Paciente')->withTrashed();
  }

  public function user() {
    return $this->belongsTo('User')->withTrashed();
  }

  public function unidade() {
    return $this->belongsTo('Unidade')->withTrashed();
  }

	public function medico() {
		return $this->belongsTo('Medico');
	}

	public function getDataColetaAttribute(){
		if($this->attributes['data_coleta'] != null){
			return FormatterHelper::dateToPtBR($this->attributes['data_coleta']);
		}
	}

	public function setDataColetaAttribute($data_coleta){
			$this->attributes['data_coleta'] = FormatterHelper::dateToMySQL($data_coleta);
	}

}
