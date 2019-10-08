@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('unidades.page.title.index') }}
@stop

@section('STYLES')

  <!-- &_Categorias -->
  <!-- <link rel="stylesheet" href="{{ asset('assets/css/&_unidades.css') }}"> -->

@stop

@section('MAIN')

<div class="card">

  <div class="card-header">

    <span class="float-right">
      {{ 
        link_to_route(
          'unidades.create', 
          trans('application.btn.add-new'), 
          null,
          array(
            'class' => 'btn btn-success btn-sm'
          )
        ) 
      }}
    </span>
    
  </div>
  
  <div class="card-body">

    @include('unidades/_filter-form')

    <div id="unidadesDataTableContainer" data-datatable-error="{{ trans('application.msg.error.datatable') }}"></div>

  </div>

  <div class="card-footer">

    <span class="float-right">
      {{ 
        link_to_route(
          'unidades.create', 
          trans('application.btn.add-new'), 
          null,
          array(
            'class' => 'btn btn-success btn-sm'
          )
        )
      }}
    </span>

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

  <!-- ()_DataTable - Initialize -->
  <script type="text/javascript">
    
    $(function() {

      // ()_SearchPanel - Show / Hide
      var searchPanel = new AdminTR.SearchPanel('UNIDADES');
      
      searchPanel.initialize();
      
      // ()_Datatable - onLoad
      var dataTable = new AdminTR.DataTable('unidades', $('#unidadesDataTableContainer'), false, false); 

      dataTable.initialize();

      // ()_FilterForm - Disable / Enable filter form buttons and Reset DataTable on submit and on clean
      var filterForm = new AdminTR.FilterForm(
                                    'unidades', 
                                    $('#unidadesDataTableContainer'), 
                                    $('#unidadesFilterForm'), 
                                    $('#unidadesFilterSubmit'), 
                                    $("#unidadesFilterClean")
                                  );
      
      filterForm.initialize();
    });

  </script>

@stop