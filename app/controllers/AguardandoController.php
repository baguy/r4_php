<?php

class AguardandoController extends BaseController {

  protected $aguardando;

  protected $service;

  protected $selects;

  public function __construct(Aguardando $aguardando, AguardandoService $service) {

    parent::__construct($service);

    $this->aguardando   = $aguardando;
    $this->service = $service;

    $this->selects = $this->service->selects();

  }

  /**
   * Encontrar dados do exame
   * Recebe id do exame
   * @author Mayra Dantas Bueno
   * chamado: selecionarParaAprovar.js
   */
  public static function findExame($id){
      return Exame::where('id', '=', $id)->with('solicitacao','laudo','tipoExame')->first();
  }

  /**
   * Encontrar dados do paciente
   * Recebe id do paciente
   * @author Mayra Dantas Bueno
   * chamado: selecionarParaAprovar.js
   */
  public static function findPaciente($id){
      return Paciente::find($id);
  }

  /**
   * Encontrar tipo do reagente (resultado do exame)
   * Recebe id tipo_reagente
   * @author Mayra Dantas Bueno
   * chamado: selecionarParaAprovar.js
   */
  public static function findTipoReagente($id){
      return TipoReagente::find($id);
  }

  public function index() {

    return View::make('aguardando.index')->with('selects', $this->service->selects(true));

  }

  public function create() {

  }

  public function store() {

  }

  public function show($id) {

    $solicitacao = $this->solicitacao->withTrashed()->find($id);

    LoggingHelper::show($solicitacao);

    return View::make('aguardando.show', compact('solicitacao'))->with('exames');
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

    $aguardando = parent::getElements('aguardando', true, 'get');

    return View::make('aguardando.report', compact('aguardando'));
  }

  public function export() {

    $input = Input::all();
    $vetor = explode(",", $input['selecionarAprovar']);
    $result = array_filter($vetor);

    foreach($result as $key => $value){

  		$this->service->update($value);

  		$type = 'pdf';
  		$exame = $this->aguardando->find($value);

  		$this->service->export($exame, $type);

    }

		return Redirect::back()
										->with('_status', Lang::get('application.msg.status.pdf-created-successfully'));
	}


  public function printOne($id) {

    $solicitacao = $this->solicitacao->withTrashed()->find($id);

    LoggingHelper::printing($solicitacao, 'print-one');

    return View::make('aguardando.print-one', compact('solicitacao'));
  }

  public function printAll() {

    $parameters = Input::except('_token', '_method');

    $aguardando = parent::getElements('aguardando', true);

    LoggingHelper::printing($this->solicitacao, 'print-all', $parameters);

    return View::make('aguardando.print-all', compact('aguardando'));
  }

}
