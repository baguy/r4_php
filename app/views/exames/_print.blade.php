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

  @if (isset($exames) && $exames->count())

    {{ $exames->appends(Input::get())->links() }}

    <div class="text-center text-secondary pt-0 pb-3 d-print-none">
      {{
        trans('pagination.table.caption', [
          'total' => $exames->getTotal(),
          'currentPage' => $exames->getCurrentPage(),
          'lastPage' => $exames->getLastPage(),
          'perPage' => $exames->getPerPage()
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
        {{ trans('exames.exame') }}
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
                {{-- {{ ($C_group === 'categorias')    ? trans('itens.lbl.categoria').':'    : '' }}
                {{ ($C_group === 'subcategorias') ? trans('itens.lbl.subcategoria').':' : '' }}
                {{ ($C_group === 'status')        ? trans('application.lbl.status').':' : '' }}
                {{ ($C_group === 'tipos')         ? trans('itens.lbl.tipo').':'         : '' }}
                {{ ($C_group === 'unidades')      ? trans('itens.lbl.unidade').':'      : '' }} --}}
              </label>

              {{-- {{ ($C_group === 'categorias')    ? $exame->subcategoria->categoria->nome : '' }}
              {{ ($C_group === 'subcategorias') ? $exame->subcategoria->nome            : '' }}
              {{ ($C_group === 'tipos')         ? $exame->tipo                          : '' }}
              {{ ($C_group === 'unidades')      ? $exame->unidade->tipo                 : '' }} --}}

              @if ($C_group === 'status')
                <span class="{{ ($exame->trashed()) ? 'text-danger' : 'text-success' }} text-uppercase mb-0">
                  {{ ($exame->trashed()) ? trans('application.lbl.inactive') : trans('application.lbl.active') }}
                </span>
              @endif
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <label class="mb-0 font-italic">{{ trans('application.lbl.total') }}:</label>
              {{ $exame->total    ? $exame->total    : null }}

              {{ $exame->active   ? $exame->active   : null }}
              {{ $exame->inactive ? $exame->inactive : null }}
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
        {{ trans('exames.exame') }}
        <span class="badge badge-light float-right">{{ trans('solicitacoes.solicitacao') }} {{ $exame->solicitacao->id }}</span>
      </h4>

      <!-- ### INFORMAÇÕES GERAIS ### -->

      <table class="table table-bordered table-printable border-0 mb-2">
        <tbody>
          <tr>
            <td class="py-1 text-center align-middle font-weight-bold bg-gray w-50px">
              {{-- {{ $index++ }} --}}
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
              <label class="mb-0 font-italic">{{ trans('exames.exame') }}:</label> {{ $exame->tipoExame->tipo }}
            </td>
            <td>
              <label class="mb-0 font-italic">{{ trans('exames.lbl.abreviacao') }}:</label> {{ $exame->tipoExame->abreviacao }}
            </td>
            <td>
              <label class="mb-0 font-italic">{{ trans('exames.lbl.metodo') }}:</label> {{ $exame->tipoExame->metodo->nome }}
            </td>
          </tr>

          <tr>
            <td colspan="4">
              <label class="mb-0 font-italic">{{ trans('pacientes.lbl.nome') }}:</label> {{ $exame->solicitacao->paciente->nome }}
            </td>
            <td>
              <label class="mb-0 font-italic">{{ trans('pacientes.lbl.sus') }}:</label> {{ $exame->solicitacao->paciente->sus }}
            </td>
          </tr>

          <tr>
            <td colspan="3">
              <label class="mb-0 font-italic">{{ trans('pacientes.lbl.data') }}:</label> {{ $exame->solicitacao->paciente->data_nascimento }}
            </td>
            <td>
              <label class="mb-0 font-italic">{{ trans('pacientes.lbl.sexo') }}:</label> {{ $exame->solicitacao->paciente->sexo->tipo }}
            </td>
            <td>
              <label class="mb-0 font-italic">{{ trans('pacientes.lbl.nome-mae') }}:</label> {{ $exame->solicitacao->paciente->nome_mae }}
            </td>
          </tr>

          <tr>
            <td colspan="2">
              <label class="mb-0 font-italic">{{ trans('pacientes.lbl.contato.1') }}:</label> {{ $exame->solicitacao->paciente->telefones[0]->numero }}
            </td>
            <td>
              <label class="mb-0 font-italic">{{ trans('pacientes.lbl.bairro') }}:</label> {{ $exame->solicitacao->paciente->endereco->bairro }}
            </td>
            <td>
              <label class="mb-0 font-italic">{{ trans('pacientes.lbl.cidade') }}:</label> {{ $exame->solicitacao->paciente->endereco->cidade->nome }}
            </td>
            <td>
              <label class="mb-0 font-italic">{{ trans('pacientes.lbl.estado') }}:</label> {{ $exame->solicitacao->paciente->endereco->estado_uf }}
            </td>
          </tr>

          <tr>
            <td colspan="4">
              <label class="mb-0 font-italic">{{ trans('pacientes.lbl.endereco') }}:</label> {{ $exame->solicitacao->paciente->endereco->logradouro }}
            </td>
            <td>
              {{ $exame->solicitacao->paciente->endereco->numero }}
            </td>
          </tr>

        </tbody>
      </table>

      <!-- ### LAUDO ### -->

      <table class="table table-bordered table-printable border-0 mb-2">
        <tbody>
          <tr>
            <td class="py-1 text-center align-middle font-weight-bold bg-gray w-50px">
              {{-- {{ $index++ }} --}}
            </td>
            <td class="p-1 text-center text-uppercase">
              <strong><i>{{ trans('laudos.laudo') }}</i></strong>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- ### QUADRO 2 ### -->

      <table class="table table-bordered table-printable border-0 mb-2">
        <tbody>

          <tr>
            <td class="py-1 text-center align-middle font-weight-bold bg-gray w-50px" rowspan="5">
              <i class="fas fa-info"></i>
            </td>
            <td>
              <label class="mb-0 font-italic">{{ trans('laudos.lbl.produto') }}:</label> {{ $exame->laudo->produto->nome }}
            </td>
            <td>
              <label class="mb-0 font-italic">{{ trans('laudos.lbl.lote') }}:</label> {{ $exame->laudo->lote }}
            </td>
            <td>
              <label class="mb-0 font-italic">{{ trans('laudos.lbl.validade') }}:</label> {{ FormatterHelper::dateToPtBR($exame->laudo->validade) }}
            </td>
          </tr>

          <tr>
            <td colspan='4'>
              <label class="mb-0 font-italic">{{ trans('laudos.lbl.resultado') }}:</label> {{ $exame->laudo->tipoReagente->tipo }}
            </td>
          </tr>

          <tr>
            <td colspan='3'>
              {{ $exame->laudo->descricao }}
            </td>
          </tr>

        </tbody>
      </table>

      <!-- ### QUADRO 3 ### -->

      <table class="table table-bordered table-printable border-0 mb-2">
        <tbody>

          <tr>
            <td class="py-1 text-center align-middle font-weight-bold bg-gray w-50px" rowspan="3">
              <i class="fas fa-calendar-alt"></i>
            </td>
            <td>
              <label class="mb-0 font-italic">{{ trans('solicitacoes.lbl.data-coleta') }}:</label>
              {{ $exame->solicitacao->data_coleta }}
            </td>
            <td>
              <label class="mb-0 font-italic">{{ trans('application.lbl.created-at') }}:</label>
              {{ FormatterHelper::dateTimeToPtBR($exame->created_at) }}
            </td>
          </tr>

        </tbody>
      </table>

      <!-- ### ASSINATURA ### -->

      <table class="table table-bordered table-printable border-0 mb-2">
        <tbody>

          <tr>
            <tr>
              <td class="py-1 text-center align-middle font-weight-bold bg-gray w-50px" rowspan="5">
              </td>
              <td colspan='3' class="text-center">
                <img src="{{ asset('assets/_dist/img/assinaturas/marines_crbio3961401d.png') }}" alt="ASSINATURA" style="width: 80px;">
              </td>
            </tr>
            <td>
              <label class="mb-0 font-italic">{{ trans('laudos.lbl.responsavel') }}:</label> {{ $exame->laudo->user->name }}
            </td>
            <td>
              <label class="mb-0 font-italic">{{ trans('users.lbl.registro') }}:</label> {{ $exame->laudo->user->registro }}
            </td>
          </tr>

        </tbody>
      </table>



    </div>

  </div>

@endif
