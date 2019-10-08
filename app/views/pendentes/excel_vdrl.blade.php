@extends('templates.protocolo')

@section('MAIN')

@if(count($ve) > 0)

  <table class="table-report">
    <thead>
      <tr style='background-color:#bfbfbf;'>
        <th>{{ trans('exames.exame') }}</th>
        <th>{{ trans('pacientes.paciente') }}</th>
        <th>{{ trans('solicitacoes.solicitacao') }}</th>
        <th>{{ trans('exames.lbl.data') }}</th>
        <th>{{ trans('ve.resultado_exame') }}</th>
      </tr>
    </thead>

    <tbody>

      @foreach ($ve as $key => $value)

        <tr>
          <td>
            {{ $value->tipoExame->abreviacao  }}
          </td>
          <td>
            {{ $value->solicitacao->paciente->nome }}
          </td>
          <td>
            {{ $value->solicitacao->numero }}
          </td>
          <td>
            {{ FormatterHelper::dateToPtBR($value->created_at) }}
          </td>
          <td class="borda">
          </td>
        </tr>

      @endforeach

    </tbody>
  </table>

@else

  <table class="table-report">
    <tbody>
      <tr>
        <td>{{ trans('application.msg.warn.no-records-found') }}</td>
      </tr>
    </tbody>
  </table>

@endif

@stop
