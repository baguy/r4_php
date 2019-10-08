$(function() {

  // ()_SearchPanel - Show / Hide
  var searchPanel = new AdminTR.SearchPanel('TERMOS');
  
  searchPanel.initialize();
  
  // ()_Datatable - onLoad
  var dataTable = new AdminTR.DataTable('termos', $('#termosDataTableContainer')); 

  dataTable.initialize();

  // ()_FilterForm - Disable / Enable filter form buttons and Reset DataTable on submit and on clean
  var filterForm = new AdminTR.FilterForm(
                                'termos', 
                                $('#termosDataTableContainer'), 
                                $('#termosFilterForm'), 
                                $('#termosFilterSubmit'), 
                                $("#termosFilterClean")
                              );
  
  filterForm.initialize();

  // ()_Select2TemplateResultBuilder
  
  new AdminTR.Select2TemplateResultBuilder(true).initialize();

  // ()_DependentDropdown
  
  var dependentDropdown = new AdminTR.DependentDropdown($('#S_origem_id'), $('#S_user_id'), null, true, 'SELECIONE UMA ORIGEM', 'SELECIONAR USUÁRIO');
  
  dependentDropdown.initialize();

  // JQuery Select2 - Reset on filter clean click

  $("#termosFilterClean").on('click',  function() {

    $('#S_origem_id').val('').trigger('change');

    $('#S_destino_id').val('').trigger('change');

    $('#S_itens').val('').trigger('change');
  });

  // ()_DatePickerYear
  
  var datePickerYear = new AdminTR.DatePickerYear();
  
  datePickerYear.initialize();
});