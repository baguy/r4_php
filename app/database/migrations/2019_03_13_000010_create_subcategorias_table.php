<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubcategoriasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		Schema::create('subcategorias', function(Blueprint $table) {
			$table->increments('id');
			$table->string('nome', 255)->unique();
			$table->integer('categoria_id')->unsigned();
			$table->timestamps();
      $table->softDeletes();

			$table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('restrict');

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

		Schema::drop('subcategorias');
	}
}
