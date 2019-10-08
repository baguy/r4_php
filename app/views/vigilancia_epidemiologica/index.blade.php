@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('ve.relatorio') }}
@stop

@section('STYLES')

  <!-- &_Categorias -->
  <!-- <link rel="stylesheet" href="{{ asset('assets/css/&_unidades.css') }}"> -->

@stop

@section('MAIN')

<div class="card">

  <div class="card-header">

    <div class="alert alert-secondary alert-dismissible alertVE" role="alert" id="alertVE" style="display:block">
      {{ trans('ve.alert.excel') }} <a href="#" class="close" data-dismiss="alert" aria-label="close" style="text-decoration:none">x</a>
    </div>

  </div>

  <div class="card-body">

    @include('vigilancia_epidemiologica/_filter-form')

    <div id="vigilancia_epidemiologicaDataTableContainer" data-datatable-error="{{ trans('application.msg.error.datatable') }}"></div>

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

  <!-- JQuery Validation -->
  <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>

  <!-- Máscaras -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
  <script src="{{ asset('assets/js/masks_validators.js') }}"></script>

  <!-- ()_DataTable - Initialize -->
  <script type="text/javascript">

    $(function() {

      // ()_SearchPanel - Show / Hide
      var searchPanel = new AdminTR.SearchPanel('APROVADOS');

      searchPanel.initialize();

      // ()_Datatable - onLoad
      var dataTable = new AdminTR.DataTable('vigilancia_epidemiologica', $('#vigilancia_epidemiologicaDataTableContainer'), false, false);

      dataTable.initialize();

      // ()_FilterForm - Disable / Enable filter form buttons and Reset DataTable on submit and on clean
      var filterForm = new AdminTR.FilterForm(
                                    'vigilancia_epidemiologica',
                                    $('#vigilancia_epidemiologicaDataTableContainer'),
                                    $('#vigilancia_epidemiologicaFilterForm'),
                                    $('#vigilancia_epidemiologicaFilterSubmit'),
                                    $("#vigilancia_epidemiologicaFilterClean")
                                  );

      filterForm.initialize();
    });

  </script>

@stop
