<?php

class PendenteService extends BaseService {

	protected $pendente;

  public function __construct(Pendente $pendente) {

    $this->pendente = $pendente;
  }

  public function selects($is_filter = false) {

    // Exames

    $exames = Exame::orderBy('created_at')->lists('solicitacao_id', 'tipo_exame_id', 'tipo_amostra_id', 'id');

    // Return

    return [

      'exames'   => MainHelper::fixArray2(TipoExame::orderBy('tipo', 'asc')->get(),'id','tipo','SELECIONAR EXAME'),

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

  public function export($pendente, $pendente2, $pendente3, $type) {

    $date       = Date('d-m-Y H-i-s');

    $title      = Lang::get('pendentes.title.protocolo');

    $parameters = Input::except('_token', '_method');

    switch ($type) {

      case 'vdrl':

				$title = Lang::get('exames.title.vdrl');

				LoggingHelper::export($this->pendente, '.xls', $parameters, $title.$date);

        Excel::create($title . ' - ' . $date, function($excel) use ($pendente, $title, $parameters) {

            $excel->sheet($title, function($sheet) use ($pendente, $parameters) {

              LoggingHelper::report($this->pendente, $parameters);

              $sheet->loadView('pendentes.excel_vdrl', array('ve' => $pendente));

            });

        })->download('xls');

        break;

			case 'protocolo':

				$title = Lang::get('exames.title.protocolo');

				LoggingHelper::export($this->pendente, '.xls', $parameters, $title.$date);

				Excel::create($title . ' - ' . $date, function($excel) use ($pendente, $pendente2, $pendente3, $title, $parameters) {

						$excel->sheet($title, function($sheet) use ($pendente, $parameters) {

							$sheet->loadView('pendentes.excel_protocolo', array('ve' => $pendente));

						});

						if(!empty($pendente2)){
							$excel->sheet($title, function($sheet) use ($pendente2, $parameters) {

								$sheet->loadView('pendentes.excel_protocolo', array('ve' => $pendente2));

							});
						}

						if(!empty($pendente3)){
							$excel->sheet($title, function($sheet) use ($pendente3, $parameters) {

								$sheet->loadView('pendentes.excel_protocolo', array('ve' => $pendente3));

							});
						}

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
