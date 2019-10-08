<?php

class ExameController extends \BaseController {

	protected $exame;

  protected $service;

  protected $selects;

  public function __construct(Exame $exame, ExameService $service) {

    parent::__construct($service);

    $this->exame   = $exame;
    $this->service = $service;

    $this->selects = $this->service->selects();

  }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$exame = Exame::find($id);
		$solicitacao = $exame->solicitacao_id;

		$this->service->destroy($id);

		return Redirect::to('solicitacoes/'.$solicitacao)->with('success', Lang::get('application.msg.status.resource-deleted-successfully'));
	}

	/**
	 * Restore the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function restore($id)
	{
		$exame = $this->exame->withTrashed()->find($id);

		$exame->restore();

		LoggingHelper::restore($exame);

		$laudo = Laudo::withTrashed()->where('exame_id','=',$exame->id)->first();

		if(isset($laudo)){

			$laudo->restore();

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
			// 		$laudo->pdf_ativo = 1;
			//
			// 		$laudo->update();
			//
			// 		$exame = Exame::find($laudo->exame_id);
			// 		$exame->tipo_status_id = 3;
			//
			// 		$exame->update();
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

		return Redirect::back()->with('success', Lang::get('application.msg.status.resource-restored-successfully'));
	}


	/**
	 * View laudo
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function laudo($id)
	{
		$data = [
			'exame' => $this->exame->find($id),
			'laudo' => $this->exame->with('laudo')->find($id)->laudo,
			'produtos' => MainHelper::fixArray2(Produto::orderBy('nome', 'asc')->get(),'id','nome'),
			'tipo_reagentes' => MainHelper::fixArray2(TipoReagente::orderBy('tipo', 'asc')->get(),'id','tipo'),
			'tipo_referencias' => MainHelper::getEnumValues('laudos','referencia'),
			'responsaveis' => MainHelper::fixArray2(User::orderBy('name', 'asc')->where('responsavel','=',1)->get(),'id','name'),
		];

		LoggingHelper::show($data['exame']);

		return View::make('exames.laudo', compact('data'));
	}

	/**
	 * View aprovar
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function aprovar($id)
	{
		$this->service->update($id);

		$exame = $this->exame->withTrashed()->find($id);

		return Redirect::back()
										->with('_status', Lang::get('application.msg.status.resource-updated-successfully'));

		LoggingHelper::aprove($exame);
	}


	/**
	 * View print
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function printOne($id) {

		$exame = $this->exame->withTrashed()->find($id);

		LoggingHelper::printing($exame, 'print-one');

		return View::make('exames.print-one', compact('exame'));
	}


	public function export($id) {

		$this->service->update($id);

		$type = 'pdf';
		$exame = $this->exame->withTrashed()->find($id);

		$this->service->export($exame, $type);

		return Redirect::back()
										->with('_status', Lang::get('application.msg.status.pdf-created-successfully'));
	}


}
