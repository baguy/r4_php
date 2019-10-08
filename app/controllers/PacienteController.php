<?php

class PacienteController extends BaseController {

  protected $paciente;

  protected $service;

  protected $selects;

  public function __construct(Paciente $paciente, PacienteService $service) {

    parent::__construct($service);

    $this->paciente   = $paciente;
    $this->service = $service;

    $this->selects = $this->service->selects();

    $this->beforeFilter('role:GERENTE', array('only' => array(
      'destroy', 'restore'
    )));

    $this->beforeFilter('role:LAB', array('only' => array(
      'index', 'create', 'store', 'show', 'edit', 'update', 'report', 'export', 'printOne', 'printAll'
    )));

  }

  /**
	 * Encontrar cidades dependendo do estado selecionado no formulário de Indivíduo e Atendimento
	 * Recebe UF do estado -> encontra ID do estado -> pega lista de cidades relacionadas à ID do estado
   * @author Mayra Dantas Bueno
   * chamado: estado_cidade.js
	 */
  public static function findCidades($uf){
      $id = Estado::select('id')->where('uf', '=', $uf)->first()->id;
      $cidades = Cidade::select('id', 'nome')->orderBy('nome', 'asc')->where('estado_id','=', $id)->get();
      return $cidades;
  }

  /**
   * Encontrar dados do paciente a partir do número do cartão SUS
   * @author Mayra Dantas Bueno
   * chamado: buscarPaciente_sus.js
   */
  public function buscar_sus($sus) {
      return Paciente::where('sus', '=', $sus)->with('endereco','telefones')->first();
  }


  public function index() {

    return View::make('pacientes.index')->with('selects', $this->service->selects(true));
  }


  public function create() {

    $data=[
      'unidades'      => MainHelper::fixArray2(Unidade::orderBy('nome', 'asc')->get(),'id','nome'),
      'tipo_exames'	  => TipoExame::all(),
      'tipo_amostras' => MainHelper::fixArray2(TipoAmostra::orderBy('tipo', 'asc')->get(),'id','tipo'),
      'cidades'       => Cidade::all(),
    ];

    return View::make('pacientes.create', compact('data'))->with('selects', $this->selects);
  }

  public function store() {

    $input = Input::all();

    $validator = PacienteValidator::store($input);

    if ($validator->passes()) {

      try {

        $this->service->store($input);

        return Redirect::route('pacientes.index')
                        ->with('_status', Lang::get('application.msg.status.resource-created-successfully'));

      } catch (Exception $e) {

        Session::flash('_old_input', Input::all());

        return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
      }
    }

    return Redirect::route('pacientes.create')
                    ->withInput()
                    ->withErrors($validator)
                    ->with('_error', Lang::get('application.msg.error.validation-errors'));
  }

  public function show($id) {

    $paciente = $this->paciente->withTrashed()->find($id);

    LoggingHelper::show($paciente);

    return View::make('pacientes.show', compact('paciente'));
  }

  public function edit($id) {

    $paciente = $this->paciente->find($id);

    return View::make('pacientes.edit', compact('paciente'))->with('selects', $this->selects);
  }

  public function update($id) {

    $input = array_except(Input::all(), '_method');

    $validator = PacienteValidator::update($input, $id);

    if ($validator->passes()) {

      try {

        $this->service->update($input, $id);

        return Redirect::route('pacientes.show', $id)
                        ->with('_status', Lang::get('application.msg.status.resource-updated-successfully'));

      } catch (Exception $e) {

        Session::flash('_old_input', Input::all());

        return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
      }
    }

    return Redirect::route('pacientes.edit', $id)
                    ->withInput()
                    ->withErrors($validator)
                    ->with('_error', Lang::get('application.msg.error.validation-errors'));
  }

  public function destroy($id) {

    $paciente = $this->paciente->find($id);

    try {

      $this->service->destroy($id);

      return Redirect::route('pacientes.index')
                      ->with('_status', Lang::get('application.msg.status.resource-deleted-successfully'));

    } catch (Exception $e) {

      return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
    }
  }

  public function restore($id) {

    $paciente = $this->paciente->withTrashed()->find($id);

    try {

      $this->service->restore($id);

      return Redirect::route('pacientes.index')
                      ->with('_status', Lang::get('application.msg.status.resource-restored-successfully'));

    } catch (Exception $e) {

      return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
    }
  }

  public function report() {

    $pacientes = parent::getElements('pacientes', true, 'get');

    return View::make('pacientes.report', compact('pacientes'));
  }

  public function export($type) {

    $pacientes = parent::getElements('pacientes', true, 'get');

    $this->service->export($pacientes, $type);
  }

  public function printOne($id) {

    $paciente = $this->paciente->withTrashed()->find($id);

    LoggingHelper::printing($paciente, 'print-one');

    return View::make('pacientes.print-one', compact('paciente'));
  }

  public function printAll() {

    $parameters = Input::except('_token', '_method');

    $pacientes = parent::getElements('pacientes', true);

    LoggingHelper::printing($this->paciente, 'print-all', $parameters);

    return View::make('pacientes.print-all', compact('pacientes'));
  }

}
