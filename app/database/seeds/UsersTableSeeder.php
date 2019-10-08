<?php

class UsersTableSeeder extends Seeder {

	public function run() {

		// Uncomment the below to wipe the table clean before populating
		// DB::table('users')->truncate();

		$objects = array(
			array(
				'name' => 'ANDRE TIMOTEO DO ROZARIO', 
				'email' => 'andre.rosario@caraguatatuba.sp.gov.br', 
				'password' => Hash::make('1234567890')
			),
			array(
				'name' => 'ALEXANDRE GUDIN NOVAK', 
				'email' => 'alexandre.novak@caraguatatuba.sp.gov.br', 
				'password' => Hash::make('1234567890')
			)
		);

		// Uncomment the below to run the seeder
		DB::table('users')->insert($objects);
	}

}
