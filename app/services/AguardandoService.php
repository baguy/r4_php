<?php

class AguardandoService extends BaseService {

	protected $aguardando;

  public function __construct(Aguardando $aguardando) {

    $this->aguardando = $aguardando;
  }

  public function selects($is_filter = false) {

    // Exames

    $exames = Exame::orderBy('created_at')->lists('solicitacao_id', 'tipo_exame_id', 'tipo_amostra_id', 'id');

    // Return

    return [

			'exames'   => MainHelper::fixArray2(TipoExame::orderBy('tipo', 'asc')->get(),'id','tipo', 'SELECIONAR EXAME'),

			'unidades' => MainHelper::fixArray2(Unidade::orderBy('nome', 'asc')->get(),'id','nome', 'SELECIONAR UNIDADE'),

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

			$exame = $this->aguardando->find($id);
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

      $this->exame->find($id)->delete();

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
