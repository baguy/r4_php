<?php

class LaudoController extends \BaseController {

	protected $laudo;

  protected $service;

  protected $selects;

  public function __construct(Laudo $laudo, LaudoService $service) {

    parent::__construct($service);

    $this->laudo   = $laudo;
    $this->service = $service;

    $this->selects = $this->service->selects();

  }

	/**
	 * Encontrar informações sobre Produto
	 * @author Mayra Dantas Bueno
	 * chamado: produto_lote_validade.js
	 */
	public static function findDadosProduto($id){
			return Produto::find($id);;
	}

	public function printPDF($id){
		$laudo = Laudo::find($id);
		$filename = 'uploads/'.$laudo->pdf.'.pdf';
		$path = base_path($filename);

		return Response::make(file_get_contents($path), 200, [
          'Content-Type' => 'application/pdf',
          'Content-Disposition' => 'inline; filename="'.$filename.'"'
        ]);
	}

	public function downloadPDF($id){
		try{
			$laudo = Laudo::find($id);

			$filename = $laudo->pdf.'.pdf';

			$download 				  = new DownloadPDF;
			$download->laudo_id = $laudo->id;
			$download->user_id  = Auth::user()->id;
			$download->pdf 			= $filename;

			$download->save();

			LoggingHelper::export($laudo, '.pdf', $laudo->exame->solicitacao->numero, $laudo->exame->tipoExame->tipo, $laudo->exame->solicitacao->paciente->sus);

			return Response::download(base_path('uploads/' . $filename));
		}catch (ErrorException $e) {
			return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
		}
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
    $input = Input::all();

		$produto = Produto::where('id','=',$input['produto_id'])->first();

		$input['produto'] = $produto;

		if($produto->id != 16){
			$input['validade'] = $input['produto']->validade;
		}

    $validator = LaudoValidator::store($input);

    if ($validator->passes()) {

      try {

        $this->service->store($input);

        return Redirect::back()
                        ->with('_status', Lang::get('application.msg.status.resource-created-successfully'));

      } catch (Exception $e) {

        Session::flash('_old_input', Input::all());

        return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
      }
    }

    return Redirect::back()
                    ->withInput()
                    ->withErrors($validator)
                    ->with('_error', Lang::get('laudos.msg.error.validation'));
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
    $input = Input::all();

		$produto = Produto::where('id','=',$input['produto_id'])->first();

		$input['produto'] = $produto;

		if($produto->id != 16){
			$input['validade'] = $input['produto']->validade;
		}

    $validator = LaudoValidator::update($input, $id);

    if ($validator->passes()) {

      try {

        $this->service->update($input, $id);

        return Redirect::back()
                        ->with('_status', Lang::get('application.msg.status.resource-updated-successfully'));
      } catch (Exception $e) {

        Session::flash('_old_input', Input::all());

        return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
      }
    }

    return Redirect::back()
                    ->withInput()
                    ->withErrors($validator)
                    ->with('_error', Lang::get('laudos.msg.error.validation'));
	}


	public function destroy($id) {

		$laudo = Laudo::find($id);

		$filename = 'uploads/'.$laudo->pdf.'.pdf';
		$path = base_path($filename);

		if( file_exists($path) ){
			File::move($path, base_path('uploads/excluidos/').$laudo->pdf.'.pdf');
			LoggingHelper::move($laudo, $laudo->exame->tipoExame->tipo, $laudo->exame->solicitacao->numero);
		}

		$exame = Exame::find($laudo->exame_id);
		$exame->tipo_status_id = 2;

		$exame->update();

		$laudo->pdf_ativo = 0;
		$laudo->update();

		LoggingHelper::update_exame($exame, $exame->solicitacao->numero);

    return Redirect::to('solicitacoes/'.$exame->solicitacao->id)->with('success', Lang::get('application.msg.status.resource-deleted-successfully'));
  }


	public function destroyPDF($id) {
		try{
			$laudo = Laudo::find($id);

			$filename = 'uploads/'.$laudo->pdf.'.pdf';
			$path = base_path($filename);

			if( file_exists($path) ){
				try{
					File::move($path, base_path('uploads/excluidos/').$laudo->pdf.'.pdf');
					LoggingHelper::move($laudo, $laudo->exame->tipoExame->tipo, $laudo->exame->solicitacao->numero);
				}catch (Exception $e) {
					return Redirect::back()->with('_error', Lang::get('application.msg.status.pdf-open'));
				}
			}

			$laudo->pdf_ativo = 0;

			$laudo->update();

			$exame = Exame::find($laudo->exame_id);
			$exame->tipo_status_id = 2;

			$exame->update();

			LoggingHelper::download($laudo, $laudo->exame->tipoExame->tipo, $laudo->exame->solicitacao->numero);

			return Redirect::back()->with('success', Lang::get('application.msg.status.resource-deleted-successfully'));
		}catch (ErrorException $e) {
			return Redirect::back()->with('_error', Lang::get('application.msg.status.pdf-open'));
		}
	}


  public function restore($id) {

		$laudo = Laudo::withTrashed()->find($id);

		$laudo->restore();

		LoggingHelper::restore($laudo);

		if( !is_null($laudo->pdf) ){

			$filename = 'uploads/excluidos/'.$laudo->pdf.'.pdf';
			$path = base_path($filename);

			if( file_exists($path) ){
				File::move($path, base_path('uploads/').$laudo->pdf.'.pdf');

				LoggingHelper::move($laudo);

				$laudo->pdf_ativo = 1;

				$laudo->update();

				$exame = Exame::find($laudo->exame_id);
				$exame->tipo_status_id = 3;

				$exame->update();
			}else{
				$exame = Exame::find($laudo->exame_id);
				$exame->tipo_status_id = 2;

				$exame->update();

				LoggingHelper::update($exame);
			}

		}

    return Redirect::back()->with('success', Lang::get('application.msg.status.resource-deleted-successfully'));
  }


	public function restorePDF($id) {

		$laudo = Laudo::withTrashed()->find($id);

		if( !is_null($laudo->pdf) ){

			$filename = 'uploads/excluidos/'.$laudo->pdf.'.pdf';
			$path = base_path($filename);

			if( file_exists($path) ){
				File::move($path, base_path('uploads/').$laudo->pdf.'.pdf');

				LoggingHelper::move($laudo);

				$laudo->pdf_ativo = 1;

				$laudo->update();

				$exame = Exame::find($laudo->exame_id);
				$exame->tipo_status_id = 3;

				$exame->update();
			}else{
				$exame = Exame::find($laudo->exame_id);
				$exame->tipo_status_id = 2;

				$exame->update();

				LoggingHelper::update($exame);
			}

		}

		return Redirect::back()->with('success', Lang::get('application.msg.status.resource-deleted-successfully'));
	}


}
