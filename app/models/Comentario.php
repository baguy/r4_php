<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Comentario extends Eloquent {

  use SoftDeletingTrait;

  	protected $table    = 'comments';
    protected $fillable = array('text', 'user_id');

    public function user(){
      return $this->belongsTo('User');
    }

    public function comentarioAtualizacao(){
      return $this->hasMany('ComentarioAtualizacao');
    }

}
