@extends('templates.search-panel')

@section('FORM')

  {{ Form::open(array('url' => '', 'id' => 'produtosFilterForm', 'method' => 'PUT')) }}

    {{ Form::hidden('C_sort', null) }}
    {{ Form::hidden('C_order', null) }}
    {{ Form::hidden('C_per_page', null) }}
    {{ Form::hidden('C_group', null) }}

    <div class="form-row">

      <div class="form-group col-md-8">

        <div class="input-group">

          <div class="input-group-prepend">
            <span class="input-group-text">
              <i class="fas fa-search fa-fw"></i>
            </span>
          </div>

          {{
            Form::text(
              'paciente',
              null,
              array(
                'class' => 'form-control',
                'placeholder' => trans('produtos.upper.produto')
              )
            )
          }}

        </div>

      </div>

      <div class="form-group col-md-4">

        <div class="input-group">

          <div class="input-group-prepend">
            <span class="input-group-text">
              <i class="fas fa-toggle-on fa-fw"></i>
            </span>
          </div>

          {{ Form::select('S_status', $selects['status'], null, array('id' => 'S_status', 'class' => 'custom-select')) }}

        </div>

      </div>

    </div>

    <div class="form-row">

      <div class="form-group col-md-12 text-right">

        {{
          Form::submit(
            trans('application.btn.search'),
            array(
              'id'       => 'produtosFilterSubmit',
              'class'    => 'btn btn-info btn-sm float-right',
              'disabled' => true
            )
          )
        }}

        {{
          link_to_route(
            'produtos.index',
            trans('application.btn.clean'),
            null,
            array(
              'id'    => 'produtosFilterClean',
              'class' => 'btn btn-secondary btn-sm float-right mr-1 disabled'
            )
          )
        }}

      </div>

    </div>

  {{ Form::close() }}

@stop
