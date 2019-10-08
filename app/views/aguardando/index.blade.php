@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('exames.page.title.index.aguardando') }}
@stop

@section('STYLES')

  <!-- &_Categorias -->
  <!-- <link rel="stylesheet" href="{{ asset('assets/css/&_unidades.css') }}"> -->

@stop

@section('MAIN')

<div class="card">

  <div class="card-header">

    @if(Auth::user()->hasRole('GERENTE'))

      <div class="alert alert-secondary alert-dismissible alertAguardando" role="alert" id="alertAguardando" style="display:block">
        {{ trans('exames.alert.gerente.ag') }} <a href="#" class="close" data-dismiss="alert" aria-label="close" style="text-decoration:none">x</a>
      </div>

    @else

      <div class="alert alert-secondary alert-dismissible alertAguardando" role="alert" id="alertAguardando" style="display:block">
        {{ trans('exames.alert.unidade') }} <a href="#" class="close" data-dismiss="alert" aria-label="close" style="text-decoration:none">x</a>
      </div>

    @endif

  </div>

  <div class="card-body">

    @include('aguardando/_filter-form')

    <div id="aguardandoDataTableContainer" data-datatable-error="{{ trans('application.msg.error.datatable') }}"></div>

  </div>

  <div class="card-footer">

  </div>

</div>

@stop

@section('SCRIPTS')

  <!-- ()_SearchPanel -->
  <script src="{{ asset('assets/js/()_search.panel.js') }}"></script>

  <!-- ()_FilterForm -->
  <script src="{{ asset('assets/js/()_filter.form.js') }}"></script>

  <!-- ()_TableDescription -->
  <script src="{{ asset('assets/js/()_table.description.js') }}"></script>

  <!-- ()_DataTable -->
  <script src="{{ asset('assets/js/()_datatable.js') }}"></script>

  <!-- selecionarParaAprovar -->
  <script src="{{ asset('assets/js/selecionarParaAprovar.js') }}"></script>

  <!-- ()_DataTable - Initialize -->
  <script type="text/javascript">

    $(function() {

      // ()_SearchPanel - Show / Hide
      var searchPanel = new AdminTR.SearchPanel('AGUARDANDO');

      searchPanel.initialize();

      // ()_Datatable - onLoad
      var dataTable = new AdminTR.DataTable('aguardando', $('#aguardandoDataTableContainer'), false, false);

      dataTable.initialize();

      // ()_FilterForm - Disable / Enable filter form buttons and Reset DataTable on submit and on clean
      var filterForm = new AdminTR.FilterForm(
                                    'aguardando',
                                    $('#aguardandoDataTableContainer'),
                                    $('#aguardandoFilterForm'),
                                    $('#aguardandoFilterSubmit'),
                                    $("#aguardandoFilterClean")
                                  );

      filterForm.initialize();
    });

  </script>

@stop
