<?php

class ProdutoObserver {

  public function creating($model) {

  }

  public function created($model) {

    LoggingHelper::create($model);
  }

  public function saving($model) {

  }

  public function saved($model) {

  }

  public function updating($model) {

  }

  public function updated($model) {

    if (!Request::is('unidades/*/restore'))

      LoggingHelper::update_nome($model);
  }

  public function deleting($model) {

  }

  public function deleted($model) {

    if($model->forceDeleting)

      LoggingHelper::delete($model);

    else

      LoggingHelper::destroy($model);
  }

  public function restoring($model) {

  }

  public function restored($model) {

    LoggingHelper::restore($model);
  }
}
