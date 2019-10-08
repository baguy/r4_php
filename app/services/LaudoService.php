<?php

class LaudoService extends BaseService {

	protected $laudo;

  public function __construct(Laudo $laudo) {

    $this->laudo = $laudo;
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

			$laudo = new Laudo($input);
      $laudo->exame_id = $input['exame_id'];
      $laudo->referencia = $input['referencia'];
			$laudo->produto_id = $input['produto']->id;

      $laudo->lote = $input['produto']->lote;
      $laudo->validade = ($input['produto']->id != 16) ? FormatterHelper::dateToMySQL($input['produto']->validade) : null;

      $laudo->save();

      $exame = Exame::where('id','=',$input['exame_id'])->first();
      $exame->tipo_status_id = 2;
      $exame->update();

			LoggingHelper::update_exame($laudo->exame,$laudo->exame->solicitacao->numero);
			LoggingHelper::create_laudo($laudo,$laudo->exame->tipoExame->tipo,$laudo->exame->solicitacao->numero);

      DB::commit();

    } catch (Exception $e) {

      MainHelper::printLog($e);

      DB::rollback();

      throw $e;
    }
  }

  public function update($input, $id) {

  	DB::beginTransaction();

    try {

      $laudo = $this->laudo->find($id);
      $laudo->fill($input);
      $laudo->referencia = $input['referencia'];

      $produto = Produto::where('id','=',$input['produto_id'])->first();
      $laudo->lote = $produto->lote;
      $laudo->validade = ($input['produto']->id != 16) ? FormatterHelper::dateToMySQL($input['produto']->validade) : null;

      $laudo->update();

			LoggingHelper::update_laudo($laudo, $laudo->exame->tipoExame->tipo, $laudo->exame->solicitacao->numero);

      DB::commit();

    } catch (Exception $e) {

      MainHelper::printLog($e);

      DB::rollback();

      throw $e;
    }
  }

	public static function update_pdf($titulo, $id) {

  	DB::beginTransaction();

    try {

      $laudo = Laudo::find($id);
      $laudo->pdf = $titulo;
			$laudo->pdf_ativo = 1;

      $laudo->update();

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

      $this->termo->find($id)->delete();

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

      $termo = $this->termo->withTrashed()->find($id);

      $termo->restore();

      DB::commit();

    } catch (Exception $e) {

      MainHelper::printLog($e);

      DB::rollback();

      throw $e;
    }
  }

  public function export($termos, $type) {

    $date       = Date('d-m-Y H-i-s');

    $title      = Lang::get('termos.termo(s)');

    $parameters = Input::except('_token', '_method');

    switch ($type) {

      case 'xls':

        Excel::create($title . ' - ' . $date, function($excel) use ($termos, $title, $parameters) {

            $excel->sheet($title, function($sheet) use ($termos, $parameters) {

              LoggingHelper::report($this->termo, $parameters);

              $sheet->loadView('termos.report', array('termos' => $termos));

            });

            LoggingHelper::export($this->termo, '.xls', $parameters);

        })->download('xls');

        break;

      case 'pdf':

        # code...

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
