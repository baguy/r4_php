<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Produto extends Eloquent {

	use SoftDeletingTrait;

  protected $table    = 'produtos';

  protected $fillable = array('nome','lote','validade');

  protected $dates    = ['deleted_at'];

	public function sexo() {
    return $this->belongsTo('Sexo');
  }

	public function laudo(){
		return $this->hasOne('Laudo');
	}

	public function getValidadeAttribute(){
		if($this->attributes['validade'] != null){
			return FormatterHelper::dateToPtBR($this->attributes['validade']);
		}
	}

	public function setValidadeAttribute($validade){
			$this->attributes['Validade'] = FormatterHelper::dateToMySQL($validade);
	}

}
