<?php

class Medico extends Eloquent {

  protected $table    = 'medicos';

  protected $fillable = array('nome', 'cpf');

}
