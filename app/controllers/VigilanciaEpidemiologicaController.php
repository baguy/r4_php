<?php

class VigilanciaEpidemiologicaController extends \BaseController {

	  protected $ve;

	  protected $service;

	  protected $selects;

	  public function __construct(VigilanciaEpidemiologica $ve, VigilanciaEpidemiologicaService $service) {

	    parent::__construct($service);

	    $this->ve   = $ve;
	    $this->service = $service;

	    $this->selects = $this->service->selects();

	  }

		public function index() {

	    return View::make('vigilancia_epidemiologica.index')->with('selects', $this->service->selects(true));

	  }

	  public function create() {

	  }

	  public function store() {

	  }

	  public function show($id) {

	    $solicitacao = $this->aprovado->withTrashed()->find($id);

	    LoggingHelper::show($solicitacao);

	    return View::make('aprovados.show', compact('solicitacao'))->with('exames');
	  }

	  public function edit($id) {

	  }

	  public function update($id) {

	  }

	  public function destroy($id) {

	  }

	  public function restore($id) {

	  }

		public function export($e_cliente,$e_solicitacao,$e_status,$e_exame,$e_resultado,$e_data_inicio,$e_data_fim) {

			$type = 'xls';

			$ve = parent::getElements('vigilancia_epidemiologica', true, 'get');

			$result = VigilanciaEpidemiologicaController::applyFilter($ve,$e_cliente,$e_solicitacao,$e_status,$e_exame,$e_resultado,$e_data_inicio,$e_data_fim);

			$this->service->export($result, $type);

			return Redirect::back()
											->with('_status', Lang::get('application.msg.status.xls-created-successfully'));
		}

		/**
	  * Aplicar filtros quando gerar arquivo excel
	  *
	  * @return object filtrado
	  */

	  public static function applyFilter($ve,$e_cliente,$e_solicitacao,$e_status,$e_exame,$e_resultado,$e_data_inicio,$e_data_fim){

	    $result=[];

	    $contador=0;

			if($e_cliente != 0 || !is_numeric($e_cliente)){
				$contador+=1;
			}
	    if($e_solicitacao != 0){
	      $contador+=1;
	    }
	    if($e_status != 0){
	      $contador+=1;
	    }
	    if($e_exame != 0){
	      $contador+=1;
	    }
			if($e_resultado != 0){
				$contador+=1;
			}
			if($e_data_inicio != 0){
				$contador+=1;
			}
			if($e_data_fim != 0){
				$contador+=1;
			}

			if($contador > 0){

				foreach ($ve as $key => $value) {

				    $verdadeDesafio=0;

						if($e_cliente != 0){

							if(FormatterHelper::somenteNumeros($value->solicitacao->paciente->sus) == $e_cliente){
								$verdadeDesafio+=1;
							}

						}else if(!is_numeric($e_cliente)){

							if(strpos(strtoupper($value->solicitacao->paciente->nome),strtoupper($e_cliente)) !== false){
								$verdadeDesafio+=1;
							}

						}

		        if($e_solicitacao != 0){
	            if($value->solicitacao->numero == $e_solicitacao){
								$verdadeDesafio+=1;
	            }
		        }

						if($e_exame != 0){
				      if($value->tipo_exame_id == $e_exame){
				        $verdadeDesafio+=1;
				      }
				    }

		        if($e_resultado != 0){
		          if($value->laudo->tipo_reagente_id == $e_resultado){
		            $verdadeDesafio+=1;
		          }
		        }

						if($e_data_inicio != 0){
							if($value->created_at->format("Y-m-d") >= $e_data_inicio){
								$verdadeDesafio+=1;
							}
						}

						if($e_data_fim != 0){
							if($value->created_at->format("Y-m-d") <= $e_data_fim){
								$verdadeDesafio+=1;
							}
						}

		        if($verdadeDesafio == $contador){
		          $result[$key] = $value;
		        }

		    } //.foreach

			}else{
				$result = $ve;
			}

	    return $result;

	  }

	  public function report() {

	    $aprovado = parent::getElements('aprovados', true, 'get');

	    return View::make('aprovados.report', compact('aprovado'));
	  }

	  public function printOne($id) {

	    $solicitacao = $this->solicitacao->withTrashed()->find($id);

	    LoggingHelper::printing($solicitacao, 'print-one');

	    return View::make('aprovados.print-one', compact('solicitacao'));
	  }

	  public function printAll() {

	    $parameters = Input::except('_token', '_method');

	    $aprovados = parent::getElements('aprovados', true);

	    LoggingHelper::printing($this->solicitacao, 'print-all', $parameters);

	    return View::make('aprovados.print-all', compact('aprovados'));
	  }

	}
