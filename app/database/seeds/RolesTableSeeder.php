<?php

class RolesTableSeeder extends Seeder {

	public function run() {

		// Uncomment the below to wipe the table clean before populating
		// DB::table('roles')->truncate();

		$objects = array(
			array(
				'name'        => 'ROOT', 
				'description' => 'Desenvolvedor'
			), 
			array(
				'name'        => 'SUPER', 
				'description' => 'Gestor de Sistemas'
			), 
			array(
				'name'        => 'ADMIN', 
				'description' => 'Responsável(is) na Secretaria'
			), 
			array(
				'name'        => 'MANAGER', 
				'description' => 'Gestores - Secretário / Adjunto'
			), 
			array(
				'name'        => 'SUPERVISOR', 
				'description' => 'Diretores da Secretaria'
			), 
			array(
				'name'        => 'LEADER', 
				'description' => 'Chefes de Sessão'
			), 
			array(
				'name'        => 'WORKER', 
				'description' => 'Funcionários em Geral'
			), 
			array(
				'name'        => 'USER', 
				'description' => 'Usuários que não são funcionários'
			)
		);

		// Uncomment the below to run the seeder
		DB::table('roles')->insert($objects);
	}
}
