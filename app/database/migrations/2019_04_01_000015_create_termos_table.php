<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTermosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		Schema::create('termos', function(Blueprint $table) {
			$table->increments('id');
			$table->longText('texto');
			$table->enum('tipo', array('AQUISIÇÃO', 'SERVIÇOS', 'AQUISIÇÃO & SERVIÇOS'));
			$table->integer('user_id')->unsigned();
			$table->integer('origem_id')->unsigned();
			$table->integer('destino_id')->unsigned();
			$table->timestamps();
      $table->softDeletes();

      $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
      $table->foreign('origem_id')->references('id')->on('secretarias')->onDelete('restrict');
      $table->foreign('destino_id')->references('id')->on('secretarias')->onDelete('restrict');

			$table->engine = 'InnoDB';
			$table->charset = 'utf8';
			$table->collation = 'utf8_general_ci'; // utf8_general_ci => performance / utf8_unicode_ci => melhor suporte multi idiomas
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {

		Schema::drop('termos');
	}
}
