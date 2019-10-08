<?php

class SolicitacaoObserver {

  public function creating($model) {

  }

  public function created($model) {

    // LoggingHelper::create($model);
    LoggerHelper::log('CREATE', Lang::get('logs.msg.update.numero', [
      'resource'  => MainHelper::getTable($model),
      'numero'    => $model->numero,
      'id'        => $model->id
    ]));
  }

  public function saving($model) {

  }

  public function saved($model) {

  }

  public function updated($model) {

      // LoggingHelper::update_solicitacao($model);
      LoggerHelper::log('UPDATE', Lang::get('logs.msg.update.numero', [
        'resource'  => MainHelper::getTable($model),
        'numero'    => $model->numero,
        'id'        => $model->id
      ]));

  }

  public function deleting($model) {

  }

  public function deleted($model) {

    if($model->forceDeleting)

      LoggingHelper::delete($model);

    else

      // LoggingHelper::destroy($model);
      LoggerHelper::log('DESTROY', Lang::get('logs.msg.delete.soft.solicitacao', [
        'resource' => MainHelper::getTable($model),
        'numero'     => $model->numero,
        'id'        => $model->id
      ]));
  }

  public function restoring($model) {

  }

  public function restored($model) {

    LoggingHelper::restore($model);
  }
}
