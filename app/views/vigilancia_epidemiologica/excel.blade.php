@extends('templates.report')

@section('MAIN')

@if(count($ve) > 0)

  <table class="table-report">
    <thead>
      <tr>
        <th>{{ trans('exames.exame') }}</th>
        <th>{{ trans('ve.resultado') }}</th>
        <th>{{ trans('solicitacoes.lbl.unidade') }}</th>
        <th>{{ trans('solicitacoes.lbl.data-coleta') }}</th>
        <th>{{ trans('pacientes.paciente') }}</th>
        <th>{{ trans('pacientes.lbl.sus') }}</th>
        <th>{{ trans('pacientes.lbl.sexo') }}</th>
        <th>{{ trans('pacientes.lbl.data') }}</th>
        <th>{{ trans('pacientes.lbl.nome-mae') }}</th>
        <th>{{ trans('pacientes.lbl.contato.1') }}</th>
        <th>{{ trans('pacientes.lbl.cep') }}</th>
        <th>{{ trans('pacientes.lbl.logradouro') }}</th>
        <th>{{ trans('pacientes.lbl.numero') }}</th>
        <th>{{ trans('pacientes.lbl.bairro') }}</th>
        <th>{{ trans('pacientes.lbl.municipio') }}</th>
        <th>{{ trans('pacientes.lbl.estado') }}</th>
        <th>{{ trans('solicitacoes.lbl.numero') }}</th>
        <th>{{ trans('solicitacoes.lbl.medico') }}</th>
        <th>{{ trans('application.lbl.created-at') }}</th>
      </tr>
    </thead>

    <tbody>

      @foreach ($ve as $key => $value)

        <tr>
          <td>
            {{ $value->tipoExame->tipo }}
          </td>
          <td>
            {{ $value->laudo->tipoReagente->tipo }}
          </td>
          <td>
            {{ $value->solicitacao->unidade->nome }}
          </td>
          <td>
            {{ $value->solicitacao->data_coleta }}
          </td>
          <td>
            {{ $value->solicitacao->paciente->nome }}
          </td>
          <td>
            {{ $value->solicitacao->paciente->sus }}
          </td>
          <td>
            {{ $value->solicitacao->paciente->sexo->tipo }}
          </td>
          <td>
            {{ $value->solicitacao->paciente->data_nascimento }}
          </td>
          <td>
            {{ $value->solicitacao->paciente->nome_mae }}
          </td>
          <td>
            {{ $value->solicitacao->paciente->telefones[0]->numero }}
          </td>
          <td>
            @if(isset($value->solicitacao->paciente->endereco->cep))
              {{ $value->solicitacao->paciente->endereco->cep }}
            @endif
          </td>
          <td>
            @if(isset($value->solicitacao->paciente->endereco->logradouro))
              {{ $value->solicitacao->paciente->endereco->logradouro }}
            @endif
          </td>
          <td>
            @if(isset($value->solicitacao->paciente->endereco->numero))
              {{ $value->solicitacao->paciente->endereco->numero }}
            @endif
          </td>
          <td>
            @if(isset($value->solicitacao->paciente->endereco->bairro))
              {{ $value->solicitacao->paciente->endereco->bairro }}
            @endif
          </td>
          <td>
            {{ $value->solicitacao->paciente->endereco->cidade->nome }}
          </td>
          <td>
            {{ $value->solicitacao->paciente->endereco->estado_uf }}
          </td>
          <td>
            {{ $value->solicitacao->numero }}
          </td>
          <td>
            {{ $value->solicitacao->medico->nome }}
          </td>
          <td>
            {{ FormatterHelper::dateTimeToPtBR($value->created_at) }}
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
