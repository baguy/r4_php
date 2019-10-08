<?php

class PendenteController extends BaseController {

  protected $pendente;

  protected $service;

  protected $selects;

  public function __construct(Pendente $pendente, PendenteService $service) {

    parent::__construct($service);

    $this->pendente   = $pendente;
    $this->service = $service;

    $this->selects = $this->service->selects();

  }

  public function index() {

    return View::make('pendentes.index')->with('selects', $this->service->selects(true));

  }

  public function create() {

  }

  public function store() {


  }

  public function show($id) {

    $solicitacao = $this->solicitacao->withTrashed()->find($id);

    LoggingHelper::show($solicitacao);

    return View::make('pendentes.show', compact('solicitacao'))->with('exames');
  }

  public function edit($id) {

  }

  public function update($id) {

  }

  public function destroy($id) {

  }

  public function restore($id) {

  }

  public function report() {

    $pendentes = parent::getElements('pendentes', true, 'get');

    return View::make('pendentes.report', compact('pendentes'));
  }

  public function export($type) {

    $pendentes = parent::getElements('pendentes', true, 'get');

    $this->service->export($pendentes, $type);
  }

  public function printOne($id) {

    $solicitacao = $this->solicitacao->withTrashed()->find($id);

    LoggingHelper::printing($solicitacao, 'print-one');

    return View::make('pendentes.print-one', compact('solicitacao'));
  }

  public function printAll() {

    $parameters = Input::except('_token', '_method');

    $pendentes = parent::getElements('pendentes', true);

    LoggingHelper::printing($this->solicitacao, 'print-all', $parameters);

    return View::make('pendentes.print-all', compact('pendentes'));
  }


/**
 * Gera relatório com todos os exames pendentes VDRL e VDRL.G
 * @author Mayra D Bueno
 * @return excel download
 */
  public function export_vdrl($e_data_inicio,$e_data_fim) {

    $type = 'vdrl';

    $ve = parent::getElements('pendentes', true, 'get');

    $result1 = VigilanciaEpidemiologicaController::applyFilter($ve,$e_cliente=0,$e_solicitacao=0,$e_status=0,$e_exame=8,$e_resultado=0,$e_data_inicio,$e_data_fim);

    $result2 = VigilanciaEpidemiologicaController::applyFilter($ve,$e_cliente=0,$e_solicitacao=0,$e_status=0,$e_exame=17,$e_resultado=0,$e_data_inicio,$e_data_fim);

    $result = array_merge($result1,$result2);

    $this->service->export($result, $result2=[], $result3=[], $type, $solicitacao1=0, $solicitacao2=0, $solicitacao3=0);

    return Redirect::back()
                    ->with('_status', Lang::get('application.msg.status.xls-created-successfully'));
  }

  /**
   * Gera protocolos de trabalho geral (qualquer exame) ou
   * HIV/HBSAG/HCV ou TOXOPLASMOSE IGM/IGG com filtros
   * @author Mayra D Bueno
   * @return excel download
   */
  public function export_protocolo($e_exame,$e_solicitacao,$e_data_inicio,$e_data_fim,$pre) {

      $type = 'protocolo';

      $ve = parent::getElements('pendentes', true, 'get');

      if($pre != 'geral'){

        if($pre == 'hiv'){

          $result_hiv = VigilanciaEpidemiologicaController::applyFilter($ve,$e_cliente=0,$e_solicitacao,$e_status=0,$e_exame=1,$e_resultado=0,$e_data_inicio,$e_data_fim);

          $result_hbsag = VigilanciaEpidemiologicaController::applyFilter($ve,$e_cliente=0,$e_solicitacao,$e_status=0,$e_exame=2,$e_resultado=0,$e_data_inicio,$e_data_fim);

          $result_hcv = VigilanciaEpidemiologicaController::applyFilter($ve,$e_cliente=0,$e_solicitacao,$e_status=0,$e_exame=7,$e_resultado=0,$e_data_inicio,$e_data_fim);

          $temp = array_merge($result_hiv,$result_hbsag);
          $result = array_merge($temp,$result_hcv);

        }

        if($pre == 'toxo'){

          $result_igm = VigilanciaEpidemiologicaController::applyFilter($ve,$e_cliente=0,$e_solicitacao,$e_status=0,$e_exame=9,$e_resultado=0,$e_data_inicio,$e_data_fim);

          $result_igg = VigilanciaEpidemiologicaController::applyFilter($ve,$e_cliente=0,$e_solicitacao,$e_status=0,$e_exame=10,$e_resultado=0,$e_data_inicio,$e_data_fim);

          $result = array_merge($result_igm,$result_igg);

        }

      }else{
        if($e_exame != 0){

          $result = VigilanciaEpidemiologicaController::applyFilter($ve,$e_cliente=0,$e_solicitacao,$e_status=0,$e_exame,$e_resultado=0,$e_data_inicio,$e_data_fim);

        }else{
          return Redirect::back()
                          ->with('_error', Lang::get('application.msg.error.xls-protocol'));
        }

      }

      $contadorVetor = count($result);
      $keyVetor = 0;
      $contador = 0;
      $result2 = [];
      if($contadorVetor > 95){
        foreach($result as $key => $value){
          $contador++;
          if($contador > 95){
            $result2[$keyVetor] = $value;
            $keyVetor++;
          }
        }
      }
      $contador = 0;
      $result3 = [];
      if($contadorVetor > 190){
        foreach($result as $key => $value){
          $contador++;
          if($contador > 190){
            $result3[$keyVetor] = $value;
            $keyVetor++;
          }
        }
      }

      $this->service->export($result, $result2, $result3, $type, $solicitacao1=0);

      return Redirect::back()
                      ->with('_status', Lang::get('application.msg.status.xls-created-successfully'));

  }

}
