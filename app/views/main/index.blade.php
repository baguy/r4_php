@extends('templates.home')

@section('PAGE_TITLE')

@stop

@section('STYLES')

@stop

@section('MAIN')

<div class="card">

  <div class="card-header">

    <div class="row">
      <img class="" src="assets/img/icone.png" alt="logo" style="height:8%; width:8%; background-color:#7a2100">
      <h1 style='margin-left:10px;margin-top:30px'>{{ trans('home.title.index') }}</h1>
    </div>

  </div>

  <div class="card-body">

    @include('main/_produto')

    <br>

    <div id="mainDataTableContainer" data-datatable-error="{{ trans('application.msg.error.datatable') }}"></div>

  </div>

  <div class="card-footer">

    <span class="float-right">
      {{
        link_to_route(
          'main.create',
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
      var searchPanel = new AdminTR.SearchPanel('MAINS');

      searchPanel.initialize();

      // ()_Datatable - onLoad
      var dataTable = new AdminTR.DataTable('main', $('#mainDataTableContainer'), false, false);

      dataTable.initialize();

      // ()_FilterForm - Disable / Enable filter form buttons and Reset DataTable on submit and on clean
      var filterForm = new AdminTR.FilterForm(
                                    'main',
                                    $('#mainDataTableContainer'),
                                    $('#mainFilterForm'),
                                    $('#mainFilterSubmit'),
                                    $("#mainFilterClean")
                                  );

      filterForm.initialize();
    });

  </script>

@stop