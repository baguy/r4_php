<?php

class Cidade extends Eloquent{

		public $timestamps  = false;
  	protected $table    = 'cidades';
    protected $fillable = array('nome', 'estado_id');
		protected $guarded  = array();

    public function endereco(){
      return $this->hasMany('Endereco', 'cidade_id', 'id');
    }

    public function estado(){
      return $this->belongsTo('Estado');
    }

		public function setCidadeAttribute($cidade){
				$this->attributes['cidade'] = Cidade::select('id')->where('nome', '=', $cidade)->first()->id;
		}

}
