<?php

class UsersRolesTableSeeder extends Seeder {

	public function run() {

		// Uncomment the below to wipe the table clean before populating
		// DB::table('users_roles')->truncate();

		$objects = array(

			// ROOT

			array(
				'user_id' => 1, 
				'role_id' => 1
			), 
			array(
				'user_id' => 1, 
				'role_id' => 2
			), 
			array(
				'user_id' => 1, 
				'role_id' => 3
			), 
			array(
				'user_id' => 1, 
				'role_id' => 4
			), 
			array(
				'user_id' => 1, 
				'role_id' => 5
			), 
			array(
				'user_id' => 1, 
				'role_id' => 6
			), 
			array(
				'user_id' => 1, 
				'role_id' => 7
			), 
			array(
				'user_id' => 1, 
				'role_id' => 8
			)

			// SUPER

			array(
				'user_id' => 2, 
				'role_id' => 2
			), 
			array(
				'user_id' => 2, 
				'role_id' => 3
			), 
			array(
				'user_id' => 2, 
				'role_id' => 4
			), 
			array(
				'user_id' => 2, 
				'role_id' => 5
			), 
			array(
				'user_id' => 2, 
				'role_id' => 6
			), 
			array(
				'user_id' => 2, 
				'role_id' => 7
			), 
			array(
				'user_id' => 2, 
				'role_id' => 8
			)
		);

		// Uncomment the below to run the seeder
		DB::table('users_roles')->insert($objects);
	}

}
