<?php

class TermoObserver {

  public function creating($model) {

  }

  public function created($model) {

    LoggingHelper::create($model);
  }

  public function saving($model) {

    // Update

    if (Request::is('termos/*') && Request::isMethod('put')) {

      // Edit Items - Add

      $itens = Input::get('itens');

      if ($itens) {

        $quantidades = Input::get('quantidades');

        $OLD_ITEMS = $model->itens()->getRelatedIds();

        $ADDED_ITEMS = array_diff($itens, $OLD_ITEMS);

        if (count($ADDED_ITEMS) > 0) {

          foreach ($ADDED_ITEMS as $id) {

            $item = Item::find($id);

            LoggerHelper::log('EDIT', Lang::get('termos.log.edit.items.add', [
              'item_id'         => $item->id,
              'item_descricao'  => $item->descricao,
              'item_quantidade' => $quantidades[$id],
              'id'              => $model->id
            ]));
          }
        }
      }
    }
  }

  public function saved($model) {

    // Update

    if (Request::is('termos/*') && Request::isMethod('put')) {

      // Edit Items - Remove

      $itens = Input::get('itens');

      if ($itens) {

        $OLD_ITEMS = $model->itens()->getRelatedIds();

        $REMOVED_ITEMS = array_diff($OLD_ITEMS, $itens);

        if (count($REMOVED_ITEMS) > 0) {

          foreach ($model->itens as $key => $item) {

            if (array_key_exists($key, $REMOVED_ITEMS) && ($REMOVED_ITEMS[$key] === $item->id))

              LoggerHelper::log('EDIT', Lang::get('termos.log.edit.items.remove', [
                'item_id'         => $item->id,
                'item_descricao'  => $item->descricao,
                'item_quantidade' => $item->pivot->quantidade,
                'id'              => $model->id
              ]));
          }
        }
      }
    }
  }

  public function updating($model) {

  }

  public function updated($model) {

    if (!Request::is('termos/*/restore'))

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
}
