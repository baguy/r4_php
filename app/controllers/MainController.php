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

    $input = Input::all();

    $validator = ProdutoValidator::store($input);

    if ($validator->passes()) {

      try {

        $this->service->store($input);

        return Redirect::route('produtos.index')
                        ->with('_status', Lang::get('application.msg.status.resource-created-successfully'));

      } catch (Exception $e) {

        Session::flash('_old_input', Input::all());

        if ($e instanceof AlreadyExistsException)

          return Redirect::back()->with('_warn', $e->getMessage());

        return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
      }
    }

    return Redirect::route('produtos.create')
                    ->withInput()
                    ->withErrors($validator)
                    ->with('_error', Lang::get('application.msg.error.validation-errors'));
  }

  public function show($id) {

    $produto = $this->produto->withTrashed()->find($id);

    LoggingHelper::show($produto);

    return View::make('produtos.show', compact('produto'));
  }

  public function edit($id) {

    $produto = $this->produto->find($id);

    return View::make('produtos.edit', compact('produto'));
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

    $produto = $this->produto->find($id);

    try {

      $this->service->destroy($id);

      LoggingHelper::destroy($produto);

      return Redirect::route('produtos.index')
                      ->with('_status', Lang::get('application.msg.status.resource-deleted-successfully'));

    } catch (Exception $e) {

      return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
    }
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

  public function report() {

    $produtos = parent::getElements('produtos', true, 'get');

    return View::make('produtos.report', compact('produtos'));
  }

  public function export($type) {

    $produtos = parent::getElements('produtos', true, 'get');

    $this->service->export($produtos, $type);
  }

  public function printOne($id) {

    $produto = $this->produto->withTrashed()->find($id);

    LoggingHelper::printing($produto, 'print-one');

    return View::make('produtos.print-one', compact('produto'));
  }

  public function printAll() {

    $parameters = Input::except('_token', '_method');

    $produtos = parent::getElements('produtos', true);

    LoggingHelper::printing($this->produto, 'print-all', $parameters);

    return View::make('produtosprodutos.print-all', compact('produtos'));
  }

  public function findByDescription($term) {

    $term = ($term === 'null') ? null : $term;

    $is_filter  = Input::get('is_filter');

    $itens = $this->produto->with('subcategoria', 'subcategoria.categoria', 'unidade');

    if ($is_filter === 'true')

      $itens = $itens->withTrashed();

    $itens = $itens->where('descricao', 'LIKE', "%$term%")->orderBy('descricao', 'ASC')->paginate(25);

    $headers = ['Content-type'=> 'application/json; charset=utf-8'];

    return Response::json($itens, 200, $headers, JSON_UNESCAPED_UNICODE);
  }
}
