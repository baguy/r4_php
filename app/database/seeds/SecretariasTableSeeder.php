<?php

class SecretariasTableSeeder extends Seeder {

	public function run() {

		// Uncomment the below to wipe the table clean before populating
		// DB::table('secretarias')->truncate();

		$objects = array(
			array(
				'nome' => 'Secretaria Municipal de Administração', 
				'endereco' => 'Rua Siqueira Campos, N° 44 - Centro - Caraguatatuba/SP'
			),
			array(
				'nome' => 'Secretaria Municipal de Assuntos Jurídicos', 
				'endereco' => 'Av. Prefeito Geraldo Nogueira da Silva, nº 2.182 - Jd. Aruan - Caraguatatuba/SP'
			),
			array(
				'nome' => 'Secretaria Municipal de Comunicação Social', 
				'endereco' => 'Rua José Damazo dos Santos, N° 39 - Centro - Caraguatatuba/SP'
			),
			array(
				'nome' => 'Secretaria Municipal de Desenvolvimento Social e Cidadania', 
				'endereco' => 'Rua Vereador Antônio Cruz Arouca, Nº 121 - Indaiá- Caraguatatuba/SP'
			),
			array(
				'nome' => 'Secretaria Municipal de Educação', 
				'endereco' => 'Av. Rio de Janeiro, N° 860 - Indaiá - Caraguatatuba/SP'
			),
			array(
				'nome' => 'Secretaria Municipal de Esportes e Recreação', 
				'endereco' => 'Av. José Herculano, N° 50 - Jd. Britânia - Caraguatatuba/SP'
			),
			array(
				'nome' => 'Secretaria Municipal de Fazenda', 
				'endereco' => 'Rua Major Aires, N° 365 - Centro - Caraguatatuba/SP'
			),
			array(
				'nome' => 'Secretaria Municipal de Governo', 
				'endereco' => 'Av. Frei Pacífico Wagner, 1011 - Centro - Caraguatatuba/SP'
			),
			array(
				'nome' => 'Secretaria Municipal de Habitação', 
				'endereco' => 'Av. Minas Gerais, 1.290 - Indaiá - Caraguatatuba/SP'
			),
			array(
				'nome' => 'Secretaria Municipal de Meio Ambiente, Agricultura e Pesca', 
				'endereco' => 'Rua Santos Dumont, 502 - Centro - Caraguatatuba/SP'
			),
			array(
				'nome' => 'Secretaria Municipal de Obras Públicas', 
				'endereco' => 'Rua Luiz Passos Júnior, N° 50 - Centro - Caraguatatuba/SP'
			),
			array(
				'nome' => 'Secretaria Municipal dos Direitos da Pessoa com Deficiência e do Idoso', 
				'endereco' => 'Rua Jorge Burihan, N° 10 - Jd. Jaqueira - Caraguatatuba/SP'
			),
			array(
				'nome' => 'Secretaria Municipal de Planejamento Estratégico e Desenvolvimento', 
				'endereco' => 'Av. Frei Pacífico Wagner, nº 163, piso Superior - Centro - Caraguatatuba/SP'
			),
			array(
				'nome' => 'Secretaria Municipal de Saúde', 
				'endereco' => 'Av. Maranhão, N° 451 - 2° ANDAR - Jd. Primavera - Caraguatatuba/SP'
			),
			array(
				'nome' => 'Secretaria Municipal de Serviços Públicos', 
				'endereco' => 'Av. Senador Feijó, N° 165 - Jd. Aruan - Caraguatatuba/SP'
			),
			array(
				'nome' => 'Secretaria Municipal de Tecnologia da Informação', 
				'endereco' => 'Rua São Benedito, Nº 436 - Centro - Caraguatatuba/SP'
			),
			array(
				'nome' => 'Secretaria Municipal de Mobilidade Urbana e Proteção ao Cidadão', 
				'endereco' => 'Rua Irmã São Francisco, Nº 83 - Caputera - Caraguatatuba/SP'
			),
			array(
				'nome' => 'Secretaria Municipal de Turismo', 
				'endereco' => 'Av. Dr. Arthur Costa Filho, N°25 - Centro - Caraguatatuba/SP'
			),
			array(
				'nome' => 'Secretaria Municipal de Urbanismo', 
				'endereco' => 'Av. Brasil, N° 749 - Sumaré - Caraguatatuba/SP'
			)
		);

		// Uncomment the below to run the seeder
		DB::table('secretarias')->insert($objects);
	}

}
