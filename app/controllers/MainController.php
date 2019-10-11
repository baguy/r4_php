<?php

class MainController extends BaseController {

  protected $user;

  protected $service;

  protected $selects;

  public function __construct(Main $user, MainService $service) {

    parent::__construct($service);

    $this->user    = $user;
    $this->service = $service;

    $this->selects = $this->service->selects();

  }

  public function index() {

    $data = [
        'usuarios' => User::all()
    ];

    return View::make('main.index', compact('data'))->with('selects', $this->service->selects(true));
  }

  public function create() {

    return View::make('produtos.create')->with('selects', $this->selects);
  }

  public function store() {

  }

  public function show($id) {

  }

  public function edit($id) {

  }

  public function update($id) {

    $input = Input::all();

    $validator = ProdutoValidator::update($input, $id);

    if ($validator->passes()) {

      try {

        $this->service->update($input, $id);

        return Redirect::route('produtos.index', $id)
                        ->with('_status', Lang::get('application.msg.status.resource-updated-successfully'));

      } catch (Exception $e) {

        Session::flash('_old_input', Input::all());

        return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
      }
    }

    return Redirect::route('produtos.edit', $id)
                    ->withInput()
                    ->withErrors($validator)
                    ->with('_error', Lang::get('application.msg.error.validation-errors'));
  }

  public function destroy($id) {

  }

  public function restore($id) {

    $produto = $this->produto->withTrashed()->find($id);

    try {

      $this->service->restore($id);

      LoggingHelper::restore($produto);

      return Redirect::route('produtos.index')
                      ->with('_status', Lang::get('application.msg.status.resource-restored-successfully'));

    } catch (Exception $e) {

      return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
    }
  }

}
