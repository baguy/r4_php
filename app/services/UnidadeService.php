<?php

class UnidadeService extends BaseService {

	protected $unidade;

  public function __construct(Unidade $unidade) {

    $this->unidade = $unidade;
  }

  public function selects() {

    return [

      'status' => MainHelper::fixArray('status', [
                    '1' => mb_strtoupper(Lang::get('application.lbl.active'), 'UTF-8'),
                    '0' => mb_strtoupper(Lang::get('application.lbl.inactive'), 'UTF-8')
                  ])
    ];
  }

  public function store($input) {

  	DB::beginTransaction();

    try {

      $unidade = new Unidade($input);

      $unidade->save();

			LoggingHelper::create_nome($unidade);

      DB::commit();

      return $unidade;

    } catch (Exception $e) {

      MainHelper::printLog($e);

      DB::rollback();

      throw $e;
    }
  }

  public function update($input, $id) {

  	DB::beginTransaction();

    try {

      $unidade = $this->unidade->find($id);

      $unidade->fill($input);

      $unidade->update();

			LoggingHelper::update_nome($unidade);

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

      $this->unidade->find($id)->delete();

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

      $unidade = $this->unidade->withTrashed()->find($id);

      $unidade->restore();

      DB::commit();

    } catch (Exception $e) {

      MainHelper::printLog($e);

      DB::rollback();

      throw $e;
    }
  }
}
