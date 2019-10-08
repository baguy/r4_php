<?php

class Estado extends Eloquent{

  	protected $table    = 'estados';
    protected $fillable = array('uf', 'nome');
    protected $guarded  = array();

    public function cidades(){
      return $this->hasMany('Cidade', 'estado_id', 'id');
    }

    public function setEstadoAttribute($estado){
        $this->attributes['estado'] = Estado::select('id')->where('nome', '=', $estado)->first()->id;
    }

}
