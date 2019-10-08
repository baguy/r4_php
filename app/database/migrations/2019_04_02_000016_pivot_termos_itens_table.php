<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PivotTermosItensTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		Schema::create('termos_itens', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('termo_id')->unsigned()->index();
			$table->integer('item_id')->unsigned()->index();
			$table->integer('quantidade')->unsigned();

			$table->foreign('termo_id')->references('id')->on('termos')->onDelete('cascade');
			$table->foreign('item_id')->references('id')->on('itens')->onDelete('cascade');

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

		Schema::drop('termos_itens');
	}
}
