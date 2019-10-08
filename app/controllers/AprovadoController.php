<?php

class AprovadoController extends BaseController {

  protected $aprovados;

  protected $service;

  protected $selects;

  public function __construct(Aprovado $aprovados, AprovadoService $service) {

    parent::__construct($service);

    $this->aprovados = $aprovados;
    $this->service = $service;

    $this->selects = $this->service->selects();
		//
    // $this->beforeFilter('role:GERENTE', array('only' => array(
    //   'destroy', 'restore'
    // )));
		//
    // $this->beforeFilter('role:UBS', array('only' => array(
    //   'index', 'create', 'store', 'show', 'edit', 'update', 'report', 'export', 'printOne', 'printAll'
    // )));

  }

  public function index() {

    return View::make('aprovados.index')->with('selects', $this->service->selects(true));

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

  public function report() {

    $aprovado = parent::getElements('aprovados', true, 'get');

    return View::make('aprovados.report', compact('aprovado'));
  }

  public function export($type) {

    $aprovado = parent::getElements('aprovados', true, 'get');

    $this->service->export($aprovado, $type);
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
