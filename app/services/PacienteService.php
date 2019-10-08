<?php

class PacienteService extends BaseService {

	protected $paciente;

  public function __construct(Paciente $paciente) {

    $this->paciente = $paciente;
  }

  public function selects($is_filter = false) {

    // Return

    return [

      'categorias' => MainHelper::fixArray('categoria', []),

      'status'     => MainHelper::fixArray('status', [
                        '1' => mb_strtoupper(Lang::get('application.lbl.active'), 'UTF-8'),
                        '0' => mb_strtoupper(Lang::get('application.lbl.inactive'), 'UTF-8')
                      ])
    ];
  }

  public function store($input) {

  	DB::beginTransaction();

    try {

      $paciente = new Paciente($input);

      $paciente->save();

      DB::commit();

      return $paciente;

    } catch (Exception $e) {

      MainHelper::printLog($e);

      DB::rollback();

      throw $e;
    }
  }

  public function update($input, $id) {

  	DB::beginTransaction();

    try {

      $subcategoria = $this->subcategoria->find($id);

      $subcategoria->fill($input);

      parent::hasChanges($subcategoria);

      $subcategoria->update();

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

      $this->subcategoria->find($id)->delete();

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

      $subcategoria = $this->subcategoria->withTrashed()->find($id);

      $subcategoria->restore();

      DB::commit();

    } catch (Exception $e) {

      MainHelper::printLog($e);

      DB::rollback();

      throw $e;
    }
  }
}
