@extends('templates.pdf')

@section('MAIN')

      <!-- ### HEADER ### -->
<div>

      <!-- ### INFORMAÇÕES GERAIS ### -->

      <!-- ### QUADRO 1 ### -->

      <table class="table mb-5">
        <thead>
          <tr>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row"> <b>{{ trans('unidades.unidade') }}:</b> </th>
            <td colspan="2"> {{ $exame->solicitacao->unidade->nome }} </td>
            <td> <b>{{ trans('solicitacoes.solicitacao') }}:</b> {{ $exame->solicitacao->numero }} </td>
          </tr>
        </tbody>
      </table>

      <!-- ### Paciente ### -->

      <table class="table mb-5">
        <thead>
          <tr>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row"> <b>{{ trans('pacientes.paciente') }}:</b> </th>
            <td colspan="3"> {{ $exame->solicitacao->paciente->nome }} </td>
          </tr>
          <tr>
            <th scope="row"> <b>{{ trans('pacientes.lbl.data') }}:</b> </th>
            <td> {{ $exame->solicitacao->paciente->data_nascimento }} </td>
            <td> <b>{{ trans('pacientes.lbl.sus') }}</b>: </td>
            <td> {{ $exame->solicitacao->paciente->sus }} </td>
          </tr>
          <tr>
            <th scope="row"> <b>{{ trans('pacientes.lbl.contato.1') }}:</b> </th>
            <td> {{ $exame->solicitacao->paciente->telefones[0]->numero }} </td>
            <td> <b>{{ trans('pacientes.lbl.sexo') }}:</b> </td>
            <td> {{ $exame->solicitacao->paciente->sexo->tipo }} </td>
          </tr>
          <tr>
            <th scope="row"></th>
            <td></td>
          </tr>
          <tbody>
            <tr>
              <th class="resultado"> <b>{{ trans('solicitacoes.lbl.cadastro') }}:</b> </th>
              <td colspan="3" class="resultado"> {{ $exame->solicitacao->user->name }} </td>
            </tr>
            <tr>
            </th>
              <th class="resultado"> <b>{{ trans('solicitacoes.lbl.medico') }}:</b> </th>
              <td colspan="3" class="resultado"> {{ $exame->solicitacao->medico->nome }} </td>
            </tr>
        </tbody>
      </table>

      <!-- ### RESULTADO ### -->

      <table class="table">
        <thead>
          <tr>
            <th scope="col"></th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan='4' bgcolor="#C8C8C8"> {{ $exame->tipoExame->tipo }} </td>
          </tr>
          <tr>
            <td colspan='2' class="resultado"> <b>{{ trans('laudos.lbl.produto') }}:</b> {{ $exame->laudo->produto->nome }} </td>
            <td class="resultado"> <b>{{ trans('laudos.lbl.lote') }}:</b> {{ $exame->laudo->lote }} </td>
            <td class="resultado"> <b>{{ trans('laudos.lbl.validade') }}:</b> {{ $exame->laudo->validade }} </td>
          </tr>
          <tr>
            <td colspan='2' class="resultado"> <b>{{ trans('exames.lbl.metodo') }}:</b> {{ $exame->tipoExame->metodo->nome }} </td>
          </tr>
          <tr>
            <td colspan='4' class="resultado"> <b>{{ trans('laudos.lbl.referencia') }}:</b> {{ $exame->laudo->referencia }} </td>
          </tr>
          <tr>
            <td colspan='4'> <b>{{ trans('laudos.lbl.resultado') }}:</b> <u>{{ $exame->laudo->tipoReagente->tipo }}</u> </td>
          </tr>
          <tr>
            <td colspan='4' class="resultado"> <b>{{ trans('laudos.laudo') }}:</b> {{ $exame->laudo->descricao }} </td>
          </tr>
        </tbody>
      </table>

</div>

<!-- ### ASSINATURA ### -->

<footer class='fixed'>

  <div>
    <center>

      @define $assinatura = FormatterHelper::somenteAssinatura($exame->laudo->user->registro)

      <img src="{{ base_path() }}/assets/_dist/img/assinaturas/{{$assinatura}}.png" height="80" width="80">

      <div>
        <p>{{ $exame->laudo->user->name }} — {{ $exame->laudo->user->registro }}</p>
        <p>Caraguatatuba, {{ date("d/m/Y") }}</p>
      </div>

    </center>
  </div>

</footer>

@stop
