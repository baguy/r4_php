<?php

class SolicitacaoController extends \BaseController {

  protected $solicitacao;

  protected $service;

  protected $selects;

  public function __construct(Solicitacao $solicitacao, SolicitacaoService $service) {

    parent::__construct($service);

    $this->solicitacao = $solicitacao;
    $this->service = $service;

    $this->selects = $this->service->selects();

  }

  /**
   * Encontrar informações sobre Solicitação
   * @author Mayra Dantas Bueno
   * chamado: buscaSolicitacao.js
   */
  public static function findSolicitacao($num){

    $num = FormatterHelper::somenteNumeros($num);
    $result = null;
    if( is_numeric($num) ){
      $result = Solicitacao::withTrashed()->where('numero', '=', $num)
                             ->get();
    }
    return $result;
  }

  public function index() {

    return View::make('solicitacoes.index')->with('selects', $this->service->selects(true));
  }

  public function create() {

    $data=[
      'anterior'      => Solicitacao::withTrashed()->orderBy('created_at','desc')->first(),
      'unidades'      => MainHelper::fixArray2(Unidade::orderBy('nome', 'asc')->get(),'id','nome'),
      'tipo_exames'	  => TipoExame::all(),
      'tipo_exames_predefinidos' => TipoExamePredefinido::all(),
      'tipo_amostras' => MainHelper::fixArray2(TipoAmostra::orderBy('tipo', 'asc')->get(),'id','tipo'),
      'tipo_sexos'    => MainHelper::fixArray2(TipoSexo::orderBy('tipo', 'asc')->get(),'id','tipo'),
      'estados'		 		=> 	MainHelper::fixArray2(Estado::orderBy('uf', 'asc')->get(), 'uf', 'nome'),
			'cidades'				=> 	MainHelper::fixArray2(Cidade::orderBy('nome', 'asc')->where('estado_id','=', 35)->get(), 'id', 'nome'),
    ];

    $resultado=false;

    return View::make('solicitacoes.create', compact('data','resultado'))->with('selects', $this->selects);
  }

  public function store() {

    $input = Input::all();

    $validator = SolicitacaoValidator::store($input);

    if ($validator->passes()) {

      try {

        $this->service->store($input);


        return Redirect::route('solicitacoes.index')
                        ->with('_status', Lang::get('application.msg.status.resource-created-successfully'));

        LoggingHelper::create($solicitacao);
      } catch (Exception $e) {

        Session::flash('_old_input', Input::all());

        return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
      }

    }

    return Redirect::route('solicitacoes.create')
                    ->withInput()
                    ->withErrors($validator)
                    ->with('_error', Lang::get('application.msg.error.validation-errors'));
  }

  public function show($id) {

    $solicitacao = $this->solicitacao->withTrashed()->find($id);

    $exames = Exame::withTrashed()->where('solicitacao_id','=',$solicitacao->id)->get();

    LoggingHelper::show($solicitacao);

    return View::make('solicitacoes.show', compact('solicitacao','exames'));
  }

  public function edit($id) {

    $data=[
      'anterior'      => Solicitacao::withTrashed()->orderBy('created_at','desc')->first(),
      'solicitacao'   => $this->solicitacao->find($id),
      'exames'        => $this->solicitacao->with('exames')->find($id)->exames,
      'unidades'      => MainHelper::fixArray2(Unidade::orderBy('nome', 'asc')->get(),'id','nome'),
      'tipo_exames'	  => TipoExame::all(),
      'tipo_exames_predefinidos' => TipoExamePredefinido::all(),
      'tipo_amostras' => MainHelper::fixArray2(TipoAmostra::orderBy('tipo', 'asc')->get(),'id','tipo'),
      'tipo_sexos'    => MainHelper::fixArray2(TipoSexo::orderBy('tipo', 'asc')->get(),'id','tipo'),
      'estados'		 		=> 	MainHelper::fixArray2(Estado::orderBy('uf', 'asc')->get(), 'uf', 'nome'),
      'cidades'				=> 	MainHelper::fixArray2(Cidade::orderBy('nome', 'asc')->where('estado_id','=', 35)->get(), 'id', 'nome'),
    ];

    $resultado=false;
    foreach($data['exames'] as $key => $exame) {
      if($exame->tipo_status_id != 1) {
        $resultado=true;
      }
    }

    return View::make('solicitacoes.edit', compact('data','resultado'))->with('selects', $this->selects);
  }

  public function update($id) {

    $input = Input::all();

    $validator = SolicitacaoValidator::update($input, $id);

    if ($validator->passes()) {

      try {

        $this->service->update($input, $id);

        return Redirect::route('solicitacoes.show', $id)
                        ->with('_status', Lang::get('application.msg.status.resource-updated-successfully'));

      } catch (Exception $e) {

        Session::flash('_old_input', Input::all());

        return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
      }
    }

    return Redirect::route('solicitacoes.edit', $id)
                    ->withInput()
                    ->withErrors($validator)
                    ->with('_error', Lang::get('application.msg.error.validation-errors'));
  }

  public function destroy($id) {

    $solicitacao = Solicitacao::findOrFail($id);

    $paciente = Solicitacao::with('paciente')->find($id)->paciente;
    $endereco = $paciente->with('endereco')->find($id)->endereco;
    $endereco->delete();
    $telefone = $paciente->with('telefones')->find($id)->telefones;
    foreach($telefone as $key => $value){
      $value->delete();
    }

    $paciente->delete();

    LoggingHelper::destroy($paciente);

    $exames = Exame::where('solicitacao_id', '=', $id)->get();

    foreach($exames as $key => $exame){

      if(isset($exame->laudo->id)){

        $filename = 'uploads/'.$exame->laudo->pdf.'.pdf';
    		$path = base_path($filename);

    		if( file_exists($path) ){
    			File::move($path, base_path('uploads/excluidos/').$exame->laudo->pdf.'.pdf');

          $exame->laudo->pdf_ativo = 0;

          $exame->laudo->update();

          $exame->tipo_status_id = 2;

          $exame->update();
    		}

        $exame->laudo->delete();

      }

      $exame->delete();

    }

    $solicitacao->delete();

    LoggingHelper::destroy($solicitacao);

    return Redirect::to('solicitacoes')->with('success', Lang::get('application.msg.status.resource-deleted-successfully'));
  }

  public function restore($id) {
    $solicitacao = Solicitacao::withTrashed()->findOrFail($id);

    // Restaura paciente, endereço e telefones
    $paciente = Paciente::withTrashed()->where('id','=',$solicitacao->paciente->id)->first();
    Endereco::withTrashed()->where('paciente_id','=',$paciente->id)->restore();
    $telefone = Telefone::withTrashed()->where('paciente_id','=',$paciente->id)->get();
    foreach($telefone as $key => $value){
      $value->restore();
    }

    $paciente->restore();

    // Restaura solicitação
    $solicitacao->restore();

    LoggingHelper::restore($solicitacao);

    LoggingHelper::restore($paciente);

    // Restaura exame
    Exame::withTrashed()->where('solicitacao_id', '=', $id)->withTrashed()->restore();
    $exames = Exame::where('solicitacao_id', '=', $id)->get();

    foreach($exames as $key => $exame){

      // Restaura laudos, se houver
      $laudo = Laudo::withTrashed()->where('exame_id','=',$exame->id)->first();

      if(isset($laudo)){

  			$laudo->restore();

        // Move PDF da pasta de excluídos para uploads (restaura pdfs)
  			// if( !is_null($laudo->pdf) ){
        //
  			// 	$filename = 'uploads/excluidos/'.$laudo->pdf.'.pdf';
  			// 	$path = base_path($filename);
        //
  			// 	if( file_exists($path) ){
  			// 		File::move($path, base_path('uploads/').$laudo->pdf.'.pdf');
        //
  			// 		LoggingHelper::move($laudo);
        //
  			// 		$exame = Exame::find($laudo->exame_id);
  			// 		$exame->tipo_status_id = 3;
        //
  			// 		$exame->update();
        //
        //     $exame->laudo->pdf_ativo = 1;
        //
        //     $exame->laudo->update();
        //
  			// 	}else{
  			// 		$exame = Exame::find($laudo->exame_id);
  			// 		$exame->tipo_status_id = 2;
        //
  			// 		$exame->update();
        //
  			// 		LoggingHelper::update($exame);
  			// 	}
        //
  			// }

  		}

      LoggingHelper::restore($exame);
    }

    return Redirect::to('solicitacoes')->with('success', Lang::get('application.msg.status.resource-restored-successfully'));
  }

  public function report() {

    $solicitacoes = parent::getElements('solicitacoes', true, 'get');

    return View::make('solicitacoes.report', compact('solicitacoes'));
  }

  public function export($type) {

    $solicitacoes = parent::getElements('solicitacoes', true, 'get');

    $this->service->export($solicitacoes, $type);
  }

  public function printOne($id) {

    $solicitacao = $this->solicitacao->withTrashed()->find($id);

    LoggingHelper::printing($solicitacao, 'print-one');

    return View::make('solicitacoes.print-one', compact('solicitacao'));
  }

  public function printAll($id) {

    $pdf = new PDFMerger();

    $solicitacao = $this->solicitacao->find($id);

    $paths = [];
    foreach($solicitacao->exames as $key => $value){
      if($value->tipo_status_id == 3){
        if($value->laudo->pdf_ativo == 1){
          $paths[$key] = $value->laudo->pdf;
        }
      }
    }

    foreach($paths as $key => $value){
      $pdf->addPDF(base_path()."/uploads/$value.pdf", 'all');
    }

    $title = "resultados_solicitacao_".$solicitacao->numero;

    try{
      return $pdf->merge('download', "$title.pdf");
    }catch(Exception $e){
      return Redirect::back();
    }
  }

  public function getItems($id) {

    $itens = $this->solicitacao
                        ->findOrFail($id)
                        ->itens()
                        ->withTrashed()
                        ->with('subcategoria', 'subcategoria.categoria', 'unidade')
                        ->orderBy('descricao', 'ASC')
                        ->get();

    $headers = ['Content-type'=> 'application/json; charset=utf-8'];

    return Response::json($itens, 200, $headers, JSON_UNESCAPED_UNICODE);
  }

}
