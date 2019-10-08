@define $index = 1

@if ($key === 0)

  <div class="row my-2 d-print-none">
    <div class="col text-right">
      <button type="button" class="btn btn-warning" onclick="window.print();">
        <i class="fas fa-print fa-fw"></i>
        {{ trans('application.btn.print') }}
      </button>
    </div>
  </div>

  @if (isset($itens) && $itens->count())

    {{ $itens->appends(Input::get())->links() }}

    <div class="text-center text-secondary pt-0 pb-3 d-print-none">
      {{
        trans('pagination.table.caption', [
          'total' => $itens->getTotal(),
          'currentPage' => $itens->getCurrentPage(),
          'lastPage' => $itens->getLastPage(),
          'perPage' => $itens->getPerPage()
        ])
      }}
    </div>

  @endif

@endif

@if ($C_group)

  <div class="row page-header {{ ($key > 0) ? ($key%12 === 0) ? 'page-break__before' : 'mt-0' : '' }}">

    <div class="col">

      @if ($key === 0)

      <!-- ### HEADER ### -->

      <h4 class="bg-dark p-2">
        <i class="fas fa-file-alt"></i>
        {{ trans('itens.item(ns)') }}
        <span class="badge badge-light float-right">
          {{ trans('application.lbl.grouped-by', ['attribute' => ucfirst($C_group)]) }}
        </span>
      </h4>

      @endif

      <!-- ### QUADRO ### -->

      <table class="table table-bordered table-printable border-0 mb-2">
        <tbody>
          <tr>
            <td class="py-1 text-center align-middle font-weight-bold bg-gray w-50px" rowspan="2">
              {{ ++$key }}
            </td>
            <td>
              <label class="mb-0 font-italic">
                {{ ($C_group === 'categorias')    ? trans('itens.lbl.categoria').':'    : '' }}
                {{ ($C_group === 'subcategorias') ? trans('itens.lbl.subcategoria').':' : '' }}
                {{ ($C_group === 'status')        ? trans('application.lbl.status').':' : '' }}
                {{ ($C_group === 'tipos')         ? trans('itens.lbl.tipo').':'         : '' }}
                {{ ($C_group === 'unidades')      ? trans('itens.lbl.unidade').':'      : '' }}
              </label>

              {{ ($C_group === 'categorias')    ? $item->subcategoria->categoria->nome : '' }}
              {{ ($C_group === 'subcategorias') ? $item->subcategoria->nome            : '' }}
              {{ ($C_group === 'tipos')         ? $item->tipo                          : '' }}
              {{ ($C_group === 'unidades')      ? $item->unidade->tipo                 : '' }}

              @if ($C_group === 'status')
                <span class="{{ ($item->trashed()) ? 'text-danger' : 'text-success' }} text-uppercase mb-0">
                  {{ ($item->trashed()) ? trans('application.lbl.inactive') : trans('application.lbl.active') }}
                </span>
              @endif
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <label class="mb-0 font-italic">{{ trans('application.lbl.total') }}:</label>
              {{ $item->total    ? $item->total    : null }}

              {{ $item->active   ? $item->active   : null }}
              {{ $item->inactive ? $item->inactive : null }}
            </td>
          </tr>
        </tbody>
      </table>

    </div>

  </div>

@else

  <div class="row js-print-block mx-0 page-break__inside--avoid">

    <div class="col">

      <!-- ### HEADER ### -->

      <h4 class="bg-dark p-2">
        <i class="fas fa-file-alt"></i>
        {{ trans('itens.item') }}
        <span class="badge badge-light float-right">{{ trans('application.lbl.code') }} {{ $item->id }}</span>
      </h4>

      <!-- ### INFORMAÇÕES GERAIS ### -->

      <table class="table table-bordered table-printable border-0 mb-2">
        <tbody>
          <tr>
            <td class="py-1 text-center align-middle font-weight-bold bg-gray w-50px">
              {{ $index++ }}
            </td>
            <td class="p-1 text-center text-uppercase">
              <strong><i>{{ trans('application.print.board.info') }}</i></strong>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- ### QUADRO 1 ### -->

      <table class="table table-bordered table-printable border-0 mb-2">
        <tbody>
          <tr>
            <td class="py-1 text-center align-middle font-weight-bold bg-gray w-50px" rowspan="5">
              <i class="fas fa-info"></i>
            </td>
            <td colspan="3">
              <label class="mb-0 font-italic">{{ trans('itens.lbl.descricao') }}:</label> {{ $item->descricao }}
            </td>
          </tr>
          <tr>
            <td id="especificacoes_{{ $item->id }}" colspan="3">
              <label class="mb-0 font-italic">{{ trans('itens.lbl.especificacao') }}:</label> {{ $item->especificacao }}
            </td>
          </tr>
          <tr>
            <td>
              <label class="mb-0 font-italic">{{ trans('itens.lbl.tipo') }}:</label> {{ $item->tipo }}
            </td>
            <td>
              <label class="mb-0 font-italic">{{ trans('itens.lbl.categoria') }}:</label> {{ $item->subcategoria->categoria->nome }}
            </td>
            <td>
              <label class="mb-0 font-italic">{{ trans('itens.lbl.subcategoria') }}:</label> {{ $item->subcategoria->nome }}
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <label class="mb-0 font-italic">{{ trans('itens.lbl.unidade') }}:</label> {{ $item->unidade->tipo }}
            </td>
            <td>
              <label class="mb-0 font-italic">{{ trans('application.lbl.status') }}:</label>
              <span class="{{ ($item->trashed()) ? 'text-danger' : 'text-success' }} text-uppercase mb-0">
                {{ ($item->trashed()) ? trans('application.lbl.inactive') : trans('application.lbl.active') }}
              </span>
            </td>
          </tr>
          <tr>
            <td colspan="3">
              <label class="mb-0 font-italic">{{ trans('itens.lbl.tags') }}:</label>
              @foreach ($item->tags()->select('tags.id', 'tags.nome')->orderBy('nome', 'ASC')->get() as $tag)
                <span class="badge badge-secondary badge-pill">{{ $tag->nome }}</span>
              @endforeach
            </td>
          </tr>
        </tbody>
      </table>

      <!-- ### ATIVIDADES ### -->

      <table class="table table-bordered table-printable border-0 mb-2">
        <tbody>
          <tr>
            <td class="py-1 text-center align-middle font-weight-bold bg-gray w-50px">
              {{ $index++ }}
            </td>
            <td class="p-1 text-center text-uppercase">
              <strong><i>{{ trans('application.print.board.last-activity') }}</i></strong>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- ### QUADRO 2 ### -->

      <table class="table table-bordered table-printable border-0 mb-2">
        <tbody>
          <tr>
            <td class="py-1 text-center align-middle font-weight-bold bg-gray w-50px" rowspan="3">
              <i class="fas fa-info"></i>
            </td>
            <td>
              <label class="mb-0 font-italic">{{ trans('application.lbl.created-at') }}:</label>
              {{ FormatterHelper::dateTimeToPtBR($item->created_at) }}
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <label class="mb-0 font-italic">{{ trans('application.lbl.updated-at') }}:</label>
              @if(strtotime($item->updated_at) > 0)
                {{ FormatterHelper::dateTimeToPtBR($item->updated_at) }}
              @endif
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <label class="mb-0 font-italic">{{ trans('application.lbl.deleted-at') }}:</label>
              @if(strtotime($item->deleted_at) > 0)

                {{ FormatterHelper::dateTimeToPtBR($item->deleted_at) }}

              @else

                 00/00/0000 00:00:00

              @endif
            </td>
          </tr>
        </tbody>
      </table>

    </div>

  </div>

@endif
