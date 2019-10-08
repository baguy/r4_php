<?php

class UnidadeController extends BaseController {

  protected $unidade;

  protected $service;

  protected $selects;

  public function __construct(Unidade $unidade, UnidadeService $service) {

    parent::__construct($service);

    $this->unidade = $unidade;
    $this->service = $service;

    $this->selects = $this->service->selects();

    $this->beforeFilter('role:GERENTE', array('only' => array(
      'destroy', 'restore'
    )));

    $this->beforeFilter('role:UNIDADE', array('only' => array(
      'index', 'create', 'store', 'show', 'edit', 'update', 'report', 'export', 'printOne', 'printAll'
    )));
  }


  public function index() {

    return View::make('unidades.index')->with('selects', $this->selects);
  }


  public function create() {

    return View::make('unidades.create');
  }


  public function store() {

    $input = Input::all();

    $validator = UnidadeValidator::store($input);

    if ($validator->passes()) {

      try {

        $this->service->store($input);

        return Redirect::route('unidades.index')
                        ->with('_status', Lang::get('application.msg.status.resource-created-successfully'));

      } catch (Exception $e) {

        Session::flash('_old_input', Input::all());

        return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
      }
    }

    return Redirect::route('unidades.create')
                    ->withInput()
                    ->withErrors($validator)
                    ->with('_error', Lang::get('application.msg.error.validation-errors'));
  }


  public function show($id) {

    $unidade = $this->unidade->withTrashed()->find($id);

    LoggingHelper::show($unidade);

    return View::make('unidades.show', compact('unidade'));
  }


  public function edit($id) {

    $unidade = $this->unidade->find($id);

    return View::make('unidades.edit', compact('unidade'));
  }


  public function update($id) {

    $input = FormatterHelper::filter(array_except(Input::all(), '_method'), array('tipo'));

    $validator = UnidadeValidator::update($input, $id);

    if ($validator->passes()) {

      try {

        $this->service->update($input, $id);

        return Redirect::route('unidades.show', $id)
                        ->with('_status', Lang::get('application.msg.status.resource-updated-successfully'));

      } catch (Exception $e) {

        Session::flash('_old_input', Input::all());

        return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
      }
    }

    return Redirect::route('unidades.edit', $id)
                    ->withInput()
                    ->withErrors($validator)
                    ->with('_error', Lang::get('application.msg.error.validation-errors'));
  }


  public function destroy($id) {

    $unidade = $this->unidade->find($id);

    try {

      $this->service->destroy($id);

      LoggingHelper::destroy($unidade);

      return Redirect::route('unidades.index')
                      ->with('_status', Lang::get('application.msg.status.resource-deleted-successfully'));

    } catch (Exception $e) {

      return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
    }
  }


  public function restore($id) {

    $unidade = $this->unidade->withTrashed()->find($id);

    try {

      $this->service->restore($id);

      LoggingHelper::restore($unidade);

      return Redirect::route('unidades.index')
                      ->with('_status', Lang::get('application.msg.status.resource-restored-successfully'));

    } catch (Exception $e) {

      return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
    }
  }
}
