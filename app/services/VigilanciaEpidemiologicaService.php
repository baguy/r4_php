<?php

class VigilanciaEpidemiologicaService extends BaseService {

	protected $ve;

  public function __construct(VigilanciaEpidemiologica $ve) {

    $this->ve = $ve;
  }

  public function selects($is_filter = false) {

    // Exames

    $exames = Exame::orderBy('created_at')->lists('solicitacao_id', 'tipo_exame_id', 'tipo_amostra_id', 'id');

    // Return

    return [

      'exames'   => MainHelper::fixArray2(TipoExame::orderBy('tipo', 'asc')->get(),'id','tipo','SELECIONAR EXAME'),

			'unidades' => MainHelper::fixArray2(Unidade::orderBy('nome', 'asc')->get(),'id','nome', 'SELECIONAR UNIDADE'),

			'tipo_reagente' => MainHelper::fixArray2(TipoReagente::orderBy('tipo', 'asc')->get(),'id','tipo','SELECIONAR RESULTADO'),

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

  public function update($input, $id) {

  	DB::beginTransaction();

    try {

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

  public function export($ve, $type) {

    $date       = Date('d-m-Y H-i-s');

    $title      = Lang::get('ve.title');

    $parameters = Input::except('_token', '_method');

    switch ($type) {

      case 'xls':

			LoggingHelper::export($this->ve, '.xls', $parameters, $title.$date);

        Excel::create($title . ' - ' . $date, function($excel) use ($ve, $title, $parameters) {

            $excel->sheet($title, function($sheet) use ($ve, $parameters) {

              LoggingHelper::report($this->ve, $parameters);

              $sheet->loadView('vigilancia_epidemiologica.excel', array('ve' => $ve));

            });


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

}
