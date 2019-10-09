<?php

class MainService extends BaseService {

	protected $user;

  public function __construct(Main $user) {

    $this->user = $user;

  }

  public function selects($is_filter = false) {

    // Return

    return [

      'status'        => MainHelper::fixArray('status', [
                          '1' => mb_strtoupper(Lang::get('application.lbl.active'), 'UTF-8'),
                          '0' => mb_strtoupper(Lang::get('application.lbl.inactive'), 'UTF-8')
                        ])
    ];
  }

  public function store($input) {

  	DB::beginTransaction();

    try {

      $produto = new Produto($input);

      $produto->save();

			LoggingHelper::create_nome($produto);

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

      $produto = $this->produto->find($id);

      $produto->fill($input);

      $produto->update();

			LoggingHelper::update_nome($produto);

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

      $this->produto->find($id)->delete();

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

      $produto = $this->produto->withTrashed()->find($id);

      $produto->restore();

      DB::commit();

    } catch (Exception $e) {

      MainHelper::printLog($e);

      DB::rollback();

      throw $e;
    }
  }

  public function export($itens, $type) {

  }

  private function syncTags($input, $produto) {

    if (!empty($input['tags'])) {

      $tags = $input['tags'];

      foreach ($tags as $key => $value) {

        if (!is_numeric($value)) {

          $exists = Tag::withTrashed()->where('nome', $value)->first();

          if (!empty($exists))

            throw new AlreadyExistsException(Lang::get('tags.exception.already-exists', ['value' => $value]));

          $input      = FormatterHelper::filter(['nome' => $value], array('nome'), 'strtolower');

          $tag        = Tag::firstOrCreate($input);

          $tags[$key] = $tag->id;
        }
      }

      $produto->tags()->sync($tags);
    }
  }
}
