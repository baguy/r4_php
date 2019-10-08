@extends('templates.search-panel')

@section('FORM')

  {{ Form::open(array('url' => '', 'id' => 'vigilancia_epidemiologicaFilterForm', 'method' => 'PUT')) }}

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

      <div class="form-group col-md-6">

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

    </div>

    <div class="form-row">


      <div class="form-group col-md-6">

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
                'class' => 'form-control',
                'placeholder' => trans('exames.upper.exame')
              )
            )
          }}

        </div>

      </div>

      <div class="form-group col-md-6">

        <div class="input-group">


          <div class="input-group-prepend">
            <span class="input-group-text">
              <i data-tooltip="tooltip" data-placement="top" title="Resultados" class="fas fa-fill-drip fa-fw"></i>
            </span>
          </div>

          {{
            Form::select(
              'S_resultado',
              $selects['tipo_reagente'],
              null,
              array(
                'class' => 'form-control',
                'placeholder' => trans('exames.upper.exame')
              )
            )
          }}

        </div>

      </div>

    </div>
    

    <div class="form-row">

      <div class="form-group col-md-6">

        <div class="input-group">

          <div class="input-group-prepend">
            <span class="input-group-text">
              <i data-tooltip="tooltip" data-placement="top" title="Data início" class="fas fa-calendar-day fa-fw"></i>
            </span>
          </div>

          {{
            Form::text(
              'S_data_inicio',
              null,
              array(
                'class' => 'form-control datas',
                'placeholder' => trans('exames.upper.data-inicio')
              )
            )
          }}

        </div>

      </div>

      <div class="form-group col-md-6">

        <div class="input-group">


          <div class="input-group-prepend">
            <span class="input-group-text">
              <i data-tooltip="tooltip" data-placement="top" title="Data fim" class="fas fa-calendar-minus fa-fw"></i>
            </span>
          </div>

          {{
            Form::text(
              'S_data_fim',
              null,
              array(
                'class' => 'form-control datas',
                'placeholder' => trans('exames.upper.data-fim')
              )
            )
          }}

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
              'id'       => 'vigilancia_epidemiologicaFilterSubmit',
              'class'    => 'btn btn-info btn-sm float-right',
              'disabled' => true
            )
          )
        }}

        {{
          link_to_route(
            'vigilancia_epidemiologica.index',
            trans('application.btn.clean'),
            null,
            array(
              'id'    => 'vigilancia_epidemiologicaFilterClean',
              'class' => 'btn btn-secondary btn-sm float-right mr-1 disabled'
            )
          )
        }}

        {{-- {{
          link_to_route(
            'vigilancia_epidemiologica.export',
            trans('application.btn.excel'),
            null,
            array(
              'id'    => 'excel',
              'class' => 'btn btn-warning btn-sm float-right mr-1'
            )
          )
        }} --}}

      </div>

    </div>

  {{ Form::close() }}

@stop
