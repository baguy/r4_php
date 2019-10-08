<?php

class ThrottlesTableSeeder extends Seeder {

	public function run() {

		// Uncomment the below to wipe the table clean before populating
		// DB::table('throttles')->truncate();

		$objects = array(
			array(
				'ip_address'          => null, 
				'is_default_password' => 1, 
				'last_access_at'      => null, 
				'attempts'            => 0, 
				'last_attempt_at'     => null, 
				'suspended'           => 0, 
				'user_id'             => 1
			),
			array(
				'ip_address'          => null, 
				'is_default_password' => 1, 
				'last_access_at'      => null, 
				'attempts'            => 0, 
				'last_attempt_at'     => null, 
				'suspended'           => 0, 
				'user_id'             => 2
			)
		);

		// Uncomment the below to run the seeder
		DB::table('throttles')->insert($objects);
	}

}
