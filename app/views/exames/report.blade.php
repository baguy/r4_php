@extends('templates.report')

@section('MAIN')

  <table class="table-report">

    <thead>

      <tr>

          <th>{{ trans('laudos.lbl.resultado') }}</th>
          <th>{{ trans('laudos.parecer') }}</th>
          <th>{{ trans('solicitacoes.lbl.unidade') }}</th>

          <th>{{ trans('application.lbl.status') }}</th>

          <th>{{ trans('application.lbl.created-at') }}</th>
          <th>{{ trans('application.lbl.updated-at') }}</th>

      </tr>

    </thead>

    <tbody>

      <tr>

          <td>{{ $exame->laudo->tipoReagente->tipo }}</td>
          <td>{{ $exame->laudo->descricao }}</td>
          <td>{{ $exame->solicitacao->unidade->nome }}</td>

          <td>
            {{ ($exame->trashed()) ? trans('application.lbl.inactive') : trans('application.lbl.active') }}
          </td>

          <td>{{ FormatterHelper::dateTimeToPtBR($exame->created_at) }}</td>

          <td>
              {{ FormatterHelper::dateTimeToPtBR($exame->updated_at) }}
          </td>

      </tr>

    </tbody>

  </table>


@stop
