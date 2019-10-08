<?php

class DownloadPDF extends Eloquent {

	public $timestamps  = true;

  protected $table    = 'downloads';

  protected $fillable = array('laudo_id', 'user_id', 'pdf');

	public function laudo(){
		return $this->belongsTo('Laudo');
	}

  public function user(){
    return $this->belongsTo('User');
  }

}
