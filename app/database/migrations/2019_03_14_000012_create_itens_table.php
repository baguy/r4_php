<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItensTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		Schema::create('itens', function(Blueprint $table) {
			$table->increments('id');
			$table->string('descricao', 255)->unique();
			$table->text('especificacao');
			$table->enum('tipo', array('BENS DE CONSUMO', 'BENS PERMANENTES', 'SERVIÇOS'));
			$table->integer('subcategoria_id')->unsigned();
			$table->integer('unidade_id')->unsigned();
			$table->timestamps();
      $table->softDeletes();

			$table->foreign('subcategoria_id')->references('id')->on('subcategorias')->onDelete('cascade');
			$table->foreign('unidade_id')->references('id')->on('unidades')->onDelete('cascade');

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

		Schema::drop('itens');
	}
}
