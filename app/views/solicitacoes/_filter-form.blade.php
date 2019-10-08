@extends('templates.search-panel')

@section('FORM')

  {{ Form::open(array('url' => '', 'id' => 'solicitacoesFilterForm', 'method' => 'PUT')) }}

    {{ Form::hidden('C_sort', null) }}
    {{ Form::hidden('C_order', null) }}
    {{ Form::hidden('C_per_page', null) }}
    {{ Form::hidden('C_group', null) }}

    <div class="form-row">

      <div class="form-group col-md-5">

        <div class="input-group">

          <div class="input-group-prepend">
            <span class="input-group-text">
              <i data-tooltip="tooltip" data-placement="top" title="Cliente ou SUS" class="fas fa-user fa-fw"></i>
            </span>
          </div>

          {{
            Form::text(
              'S_paciente',
              null,
              array(
                'class' => 'form-control',
                'placeholder' => trans('pacientes.upper.paciente_sus'),
                'id' => 'S_paciente'
              )
            )
          }}

        </div>

      </div>

      <div class="form-group col-md-3">

        <div class="input-group">

          <div class="input-group-prepend">
            <span class="input-group-text">
              <i data-tooltip="tooltip" data-placement="top" title="Número da solicitação" class="fas fa-arrow-right fa-fw"></i>
            </span>
          </div>

          {{
            Form::text(
              'S_numero',
              null,
              array(
                'class' => 'form-control',
                'placeholder' => trans('solicitacoes.upper.solicitacao'),
                'id' => 'S_numero'
              )
            )
          }}

        </div>

      </div>

      <div class="form-group col-md-4">

        <div class="input-group">

          <div class="input-group-prepend">
            <span class="input-group-text">
              <i data-tooltip="tooltip" data-placement="top" title="Status" class="fas fa-toggle-on fa-fw"></i>
            </span>
          </div>

          {{ Form::select('S_status', $selects['status'], null, array('id' => 'S_status', 'class' => 'custom-select')) }}

        </div>

      </div>

    </div>

    <div class="form-row">

      <div class="form-group col-md-10">

        <div class="input-group">

          <div class="input-group-prepend">
            <span class="input-group-text">
              <i data-tooltip="tooltip" data-placement="top" title="Unidades" class="fas fa-hospital fa-fw"></i>
            </span>
          </div>

          {{
            Form::select(
              'S_unidade',
              $selects['unidades'],
              null,
              array(
                'class'       => 'form-control',
                'placeholder' => strtoupper(trans('solicitacoes.lbl.unidade')),
                'id'          => 'S_unidade'
              )
            )
          }}

        </div>

      </div>

      <div class="form-group col-md-2 text-right">

        {{
          Form::submit(
            trans('application.btn.search'),
            array(
              'id'       => 'solicitacoesFilterSubmit',
              'class'    => 'btn btn-info btn-sm float-right',
              'disabled' => true
            )
          )
        }}

        {{
          link_to_route(
            'solicitacoes.index',
            trans('application.btn.clean'),
            null,
            array(
              'id'    => 'solicitacoesFilterClean',
              'class' => 'btn btn-secondary btn-sm float-right mr-1 disabled'
            )
          )
        }}

      </div>

    </div>

  {{ Form::close() }}

@stop
