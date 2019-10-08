<?php

class ExameObserver {

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

      LoggingHelper::update($model);

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

  public function aproved($model) {

    LoggingHelper::aprove($model);
  }
}
