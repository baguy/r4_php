<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Laudo extends Eloquent {

	use SoftDeletingTrait;

  protected $table    = 'laudos';

  protected $fillable = array('descricao', 'lote', 'validade', 'tipo_reagente_id',
	 														'exame_id', 'user_id', 'pdf', 'pdf_ativo', 'produto_id');

  protected $guarded  = array();

  protected $dates    = ['deleted_at'];

  public function tipoReagente() {
    return $this->belongsTo('TipoReagente');
  }

  public function user() {
    return $this->belongsTo('User')->withTrashed();
  }

  public function produto() {
    return $this->belongsTo('Produto')->withTrashed();
  }

  public function exame() {
    return $this->belongsTo('Exame','exame_id','id')->withTrashed();
  }

	public function getValidadeAttribute(){
		if($this->attributes['validade'] != null){
			return FormatterHelper::dateToPtBR($this->attributes['validade']);
		}
	}

	public function download(){
		return $this->hasMany('DownloadPDF');
	}

}
