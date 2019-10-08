<?php

class SolicitacaoService extends BaseService {

	protected $solicitacao;

  public function __construct(Solicitacao $solicitacao) {

    $this->solicitacao = $solicitacao;
  }

  public function selects($is_filter = false) {

    // Exames

    $exames = Exame::orderBy('created_at')->lists('solicitacao_id', 'tipo_exame_id', 'tipo_amostra_id', 'id');

    // Return

    return [

      'exames'   => MainHelper::fixArray('exames', $exames),

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

			$medico = new Medico($input);
			$medico->nome = $input['medico'];

			$medico->save();

			$paciente = new Paciente($input);

			$paciente->save();

			$telefone = new Telefone($input);
			$telefone->paciente_id = $paciente->id;
			$telefone->numero = $input['contato1'];
			$telefone->tipo_telefone_id = 1;

			$telefone->save();

			if(isset($input['contato2']) && ($input['contato2'] != '')){
				$telefone = new Telefone($input);
				$telefone->paciente_id = $paciente->id;
				$telefone->numero = $input['contato2'];
				$telefone->tipo_telefone_id = 2;

				$telefone->save();
			}

			$endereço = new Endereco($input);
			$endereço->cep = isset($input['cep'])?$input['cep']:null;
			$endereço->paciente_id = $paciente->id;

			$endereço->save();

      $solicitacao = new Solicitacao($input);
			$solicitacao->numero = $input['num_solicitacao'];
			$solicitacao->data_coleta = $input['data_coleta'];
			$solicitacao->medico_id = $medico->id;
			$solicitacao->paciente_id = $paciente->id;
      $solicitacao->user_id = Auth::user()->id;

      $solicitacao->save();

			foreach($input['tipo_exame_id'] as $key => $value){
				$exame = new Exame($input);
				$exame->solicitacao_id = $solicitacao->id;
				$exame->tipo_status_id = 1;
				$exame->tipo_exame_id = $value;
				$exame->tipo_amostra_id = $input['amostra'][$value-1];

				$exame->save();
			}

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

			$solicitacao	= $this->solicitacao->find($id);
			$paciente = $this->solicitacao->with('paciente')->find($id)->paciente;
			$exames = $this->solicitacao->with('exames')->find($id)->exames;
			$medico = $this->solicitacao->with('medico')->find($id)->medico;
			$usuario = $this->solicitacao->with('user')->find($id)->user;
			$unidade = $this->solicitacao->with('unidade')->find($id)->unidade;

			$medico->nome = $input['medico'];

			$medico->update();

			$verdadeDesafio = true;
			foreach($exames as $key => $value){
				if($value->tipo_status_id != 1){
					$verdadeDesafio = false;
				}
			}

			if($verdadeDesafio){

				$paciente->fill($input);

				$paciente->update();

				$paciente->telefones[0]->numero = $input['contato1'];
				$paciente->telefones[0]->tipo_telefone_id = 1;

				$paciente->telefones[0]->update();

				if( !isset($paciente->telefones[1]) ){
					if(isset($input['contato2']) && ($input['contato2'] != '')){
						$telefone = new Telefone($input);
						$telefone->paciente_id = $paciente->id;
						$telefone->numero = $input['contato2'];
						$telefone->tipo_telefone_id = 2;

						$telefone->save();
					}
				}else{

					$paciente->telefones[1]->numero = $input['contato2'];
					$paciente->telefones[1]->tipo_telefone_id = 2;

					$paciente->telefones[1]->update();

				}

				$paciente->endereco->fill($input);
				$paciente->endereco->cep = isset($input['cep'])?$input['cep']:null;

				$paciente->endereco->save();
			}

			$solicitacao->fill($input);
			$solicitacao->numero = $input['num_solicitacao'];
			$solicitacao->medico_id = $medico->id;
			$solicitacao->paciente_id = $paciente->id;
      $solicitacao->user_id = Auth::user()->id;

      $solicitacao->update();

			foreach ($exames as $key => $value) {
				if (isset($input['tipo_exame_id'][$key])) {
					$value->tipo_exame_id = $input['tipo_exame_id'][$key];
					$value->tipo_amostra_id = $input['amostra'][($input['tipo_exame_id'][$key])-1];

					$value->update();
				}else{
					$value->delete();
				}
			}
			if( isset($input['tipo_exame_id']) ){
				if ( count($exames) < count($input['tipo_exame_id']) ) {
					foreach ($input['tipo_exame_id'] as $key => $value) {
						if ( !isset($exames->tipo_exame_id[$key]) ) {
							$exame = new Exame( array(
															'tipo_exame_id' => $value,
															'tipo_status_id' => 1,
															'tipo_amostra_id' => $input['amostra'][$value-1] ));
							$exame->solicitacao()->associate($solicitacao)->save();
						}
					}
				}
			}

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

      $this->solicitacao->find($id)->delete();

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
