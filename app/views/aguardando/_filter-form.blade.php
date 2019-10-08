@extends('templates.search-panel')

@section('FORM')

  {{ Form::open(array('url' => '', 'id' => 'aguardandoFilterForm', 'method' => 'PUT')) }}

    {{ Form::hidden('C_sort', null) }}
    {{ Form::hidden('C_order', null) }}
    {{ Form::hidden('C_per_page', null) }}
    {{ Form::hidden('C_group', null) }}

    <div class="form-row">

      <div class="form-group col-md-6">

        <div class="input-group">

          <div class="input-group-prepend">
            <span class="input-group-text">
              <i data-tooltip="tooltip" data-placement="top" title="Cliente ou SUS" class="fas fa-diagnoses fa-fw"></i>
            </span>
          </div>

          {{
            Form::text(
              'S_paciente',
              null,
              array(
                'class' => 'form-control',
                'placeholder' => trans('pacientes.upper.paciente_sus')
              )
            )
          }}

        </div>

      </div>

      <div class="form-group col-md-">

        <div class="input-group">

          <div class="input-group-prepend">
            <span class="input-group-text">
              <i data-tooltip="tooltip" data-placement="top" title="Solicitação" class="fas fa-notes-medical fa-fw"></i>
            </span>
          </div>

          {{
            Form::text(
              'S_solicitacao',
              null,
              array(
                'class' => 'form-control',
                'placeholder' => trans('solicitacoes.upper.solicitacao')
              )
            )
          }}

        </div>

      </div>

      <div class="form-group col-md-3">

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

      <div class="form-group col-md-12">

        <div class="input-group">

          <div class="input-group-prepend">
            <span class="input-group-text">
              <i data-tooltip="tooltip" data-placement="top" title="Exames" class="fas fa-flask fa-fw"></i>
            </span>
          </div>

          {{
            Form::select(
              'S_exame',
              $selects['exames'],
              null,
              array(
                'class' => 'custom-select',
                'placeholder' => trans('exames.upper.exame'),
                'id'    => 'S_exame',
              )
            )
          }}

        </div>

      </div>

    </div>

    <div class="form-row">

    @if(Auth::user()->hasRole('GERENTE'))

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

      @else


      <div class="form-group col-md-12 text-right">

      @endif

        {{
          Form::submit(
            trans('application.btn.search'),
            array(
              'id'       => 'aguardandoFilterSubmit',
              'class'    => 'btn btn-info btn-sm float-right',
              'disabled' => true
            )
          )
        }}

        {{
          link_to_route(
            'aguardando.index',
            trans('application.btn.clean'),
            null,
            array(
              'id'    => 'aguardandoFilterClean',
              'class' => 'btn btn-secondary btn-sm float-right mr-1 disabled'
            )
          )
        }}

      </div>

    </div>

  {{ Form::close() }}

@stop
