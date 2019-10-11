<?php

class ComentarioAtualizacao extends Eloquent {

  	protected $table    = 'comments_updates';
    protected $fillable = array('comment_id','text');

    public function comentario(){
      return $this->belongsTo('Comentario','comment_id','id');
    }

}
