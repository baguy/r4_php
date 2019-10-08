<?php

class ExameService extends BaseService {

	protected $laudo;

  public function __construct(Exame $exame) {

    $this->exame = $exame;
  }

  public function selects($is_filter = false) {

    // Exames

    $exames = Exame::orderBy('created_at')->lists('solicitacao_id', 'tipo_exame_id', 'tipo_amostra_id', 'id');

    // Return

    return [

      'exames'   => MainHelper::fixArray('exames', $exames),

      'users'    => MainHelper::fixArray('usuário', []),

      'status'   => MainHelper::fixArray('status', [
                      '1' => mb_strtoupper(Lang::get('application.lbl.active'), 'UTF-8'),
                      '0' => mb_strtoupper(Lang::get('application.lbl.inactive'), 'UTF-8')
                    ])
    ];
  }

  public function store($input) {

  	DB::beginTransaction();

    try {


      DB::commit();

    } catch (Exception $e) {

      MainHelper::printLog($e);

      DB::rollback();

      throw $e;
    }
  }

  public function update($id) {

  	DB::beginTransaction();

    try {

      $exame = $this->exame->find($id);
      $exame->tipo_status_id = 3;
			$exame->laudo->pdf_ativo = 0;

			$exame->laudo->update();
      $exame->update();

			LoggingHelper::update_exame($exame, $exame->solicitacao->numero);

      DB::commit();

    } catch (Exception $e) {

      MainHelper::printLog($e);

      DB::rollback();

      throw $e;
    }
  }

  public function destroy($id) {

    DB::beginTransaction();

    try {

      $exame = $this->exame->findOrFail($id);

			if(isset($exame->laudo->id)){

				if(!is_null($exame->laudo->pdf) && ($exame->laudo->pdf_ativo == 1)){
					$filename = 'uploads/'.$exame->laudo->pdf.'.pdf';
					$path = base_path($filename);

					if( file_exists($path) ){
						File::move($path, base_path('uploads/excluidos/').$exame->laudo->pdf.'.pdf');
						LoggingHelper::move($exame->laudo);

						$exame->tipo_status_id = 2;

						$exame->update();
					}

					$exame->laudo->pdf_ativo = 0;

					$exame->laudo->update();

					$exame->laudo->delete();

				}

			}else{
				$exame->tipo_status_id = 1;

				$exame->update();
			}

			$exame->delete();

      DB::commit();

    } catch (Exception $e) {

      MainHelper::printLog($e);

      DB::rollback();

      throw $e;
    }
  }

  public function restore($id) {

    DB::beginTransaction();

    try {

      $exame = $this->exame->withTrashed()->find($id);

			if($exame->laudo){
				$exame->laudo->restore();

				if(!is_null($exame->laudo->pdf)){

					$filename = 'uploads/excluido'.$exame->laudo->pdf.'.pdf';
					$path = base_path($filename);

					if( file_exists($path) ){
						File::move($path, base_path('uploads/').$exame->laudo->pdf.'.pdf');
						LoggingHelper::move($exame->laudo);

						$exame->laudo->pdf_ativo = 1;

						$exame->laudo->update();
					}
				}

				LoggingHelper::restore($exame->laudo);
			}

			LoggingHelper::restore($exame);

      $exame->restore();

      DB::commit();

    } catch (Exception $e) {

      MainHelper::printLog($e);

      DB::rollback();

      throw $e;
    }
  }

  public function export($exame, $type) {

    $date       = Date('d-m-Y H-i-s');

    $title      = Lang::get('exames.lower.title');

    // $parameters = Input::except('_token', '_method');

    switch ($type) {

      case 'xls':

        Excel::create($title . ' - ' . $date, function($excel) use ($exame, $title, $parameters) {

            $excel->sheet($title, function($sheet) use ($exame, $parameters) {

              LoggingHelper::report($this->exame, $parameters);

              $sheet->loadView('exames.report', array('exame' => $exame));

            });

            LoggingHelper::export($this->exame, '.xls', $parameters);

        })->download('xls');

        break;

      case 'pdf':

				$paciente = FormatterHelper::somenteNumeros($exame->solicitacao->paciente->sus);
				$abreviacao = FormatterHelper::somenteAssinatura($exame->tipoExame->abreviacao);
				$titulo = $title.'-'.$paciente.'-'.$abreviacao.'-'.$date;

				PDF::loadView('exames.pdf', compact('exame'))->save(base_path()."/uploads/$titulo.pdf");

				LaudoService::update_pdf($titulo, $exame->laudo->id);

				LoggingHelper::export($exame, '.pdf', $exame->solicitacao->numero, $exame->tipoExame->tipo, $exame->solicitacao->paciente->sus);

        break;

      case 'word':

        # code...

        break;
    }
  }

  private function syncItems($termo, $itens, $quantidades) {

    $pivotData = [];

    foreach ($quantidades as $item_ID => $quantidade) {

      $pivotData[ $item_ID ] = [ 'quantidade' => $quantidade ];
    }

    $syncData = array_combine($itens, $pivotData);

    $termo->itens()->sync($syncData);
  }
}
