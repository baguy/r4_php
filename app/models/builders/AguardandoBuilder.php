<?php

	class AguardandoBuilder {

		private $instance;

		public function __construct() {

			$this->instance = new Aguardando();
		}

		public function getModel() {

			return $this->instance;
		}

		public function getQuery() {

			$this->instance = $this->instance;

			return $this;
		}

		public function getSpecificRestrictions($parameters = array()) {

			// Status
			if (array_key_exists('S_status', $parameters)) {

				if ($parameters['S_status'] === '1') { // Active

					$this->instance = $this->instance->whereNull('deleted_at');

				} elseif ($parameters['S_status'] === '0') { // Inactive

					$this->instance = $this->instance->withTrashed()->whereNotNull('deleted_at');

				}
			}

			if (array_key_exists('S_solicitacao', $parameters)) {

				if (!empty($parameters['S_solicitacao'])) {
					if(is_numeric($parameters['S_solicitacao'])){

						$this->instance = $this->instance
						->whereHas('solicitacao', function ($q) use($parameters) {
							$q->where('numero', '=', $parameters['S_solicitacao']);
						});

					}
				}
			}

			// Paciente [nome] e [sus]
			if (array_key_exists('S_paciente', $parameters)) {

				if (!empty($parameters['S_paciente'])) { // Nome
					if(!is_numeric($parameters['S_paciente'])){

						$this->instance = $this->instance->
						whereHas('solicitacao', function($q) use ($parameters){
							$q->join('pacientes', 'pacientes.id', '=', 'solicitacoes.paciente_id')->
								 where('pacientes.nome','LIKE', $parameters['S_paciente']."%");
						});

					}else{ // SUS

						$this->instance = $this->instance->
						whereHas('solicitacao', function($q) use ($parameters){
							$q->join('pacientes', 'pacientes.id', '=', 'solicitacoes.paciente_id')->
							   where('pacientes.sus','=', $parameters['S_paciente']);
						});

					}

				}
			}

			// Exames
			if (array_key_exists('S_exame', $parameters)) {

				if (!empty($parameters['S_exame'])) {

					$this->instance = $this->instance->where('tipo_exame_id', '=', $parameters['S_exame']);

				}

			}

			// Unidade
			if (array_key_exists('S_unidade', $parameters)) {

				if (!empty($parameters['S_unidade'])) {

					$this->instance = $this->instance
					->whereHas('solicitacao', function ($q) use($parameters) {
						$q->where('unidade_id', '=', $parameters['S_unidade']);
					});

				}

			}

			return $this;
		}

		public function getGeneralRestrictions($restrictions = null) {

			if ($restrictions)

				$this->instance = $this->instance->where($restrictions);

			return $this;
		}

		public function getBasicRestrictions($parameters = array()) {

			if(Auth::user()->hasRole('ADMIN') || Auth::user()->hasRole('LAB')){
				$this->instance = $this->instance->where('tipo_status_id', '=', 2);
			}else{
				$this->instance = $this->instance->where('tipo_status_id', '=', 2)->whereHas('solicitacao', function ($q) use($parameters) {
					$q->where('unidade_id','=',Auth::user()->unidade_id);
				});
			}

			return $this;
		}

		public function getOrder($parameters = array()) {

			$sort  = 'created_at';

			$order = 'ASC';

			if (array_key_exists('C_sort', $parameters))

				$sort = empty($parameters['C_sort']) ? $sort : $parameters['C_sort'];

			if (array_key_exists('C_order', $parameters))

				$order = empty($parameters['C_order']) ? $order : $parameters['C_order'];

			if ($sort === 'status')

				$this->instance = $this->instance->orderBy('deleted_at', $order);

			else

				$this->instance = $this->instance->orderBy($sort, $order);

			return $this;
		}

		public function getGroup($parameters = array()) {

			$group = null;

			if (array_key_exists('C_group', $parameters))

				$group = empty($parameters['C_group']) ? $group : $parameters['C_group'];

			if ($group === 'status')

				$this->instance = $this->instance
																	->select(
																		'unidades.*',
																		DB::raw('IF(deleted_at IS NULL, NULL, 1) AS status'),
																		DB::raw('COUNT(deleted_at) AS inactive'),
																		DB::raw('SUM(deleted_at IS NULL) AS active')
																	)
																	->groupBy('status');

			return $this;
		}

		public function getContent($type = null, $parameters = array()) {

			switch ($type) {

				case 'get':

					$this->instance = $this->instance->get();

					break;

				default:

					$perPage = 10;

					if (array_key_exists('C_per_page', $parameters))

						$perPage = empty($parameters['C_per_page']) ? $perPage : $parameters['C_per_page'];

					$this->instance = $this->instance->paginate($perPage);

					break;
			}

			return $this;
		}

		public function build() {

			return $this->getModel();
		}
	}

?>
