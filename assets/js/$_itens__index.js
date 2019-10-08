$(function() {

  // ()_SearchPanel - Show / Hide
  var searchPanel = new AdminTR.SearchPanel('ITENS');
  
  searchPanel.initialize();
  
  // ()_Datatable - onLoad
  var dataTable = new AdminTR.DataTable('itens', $('#itensDataTableContainer')); 

  dataTable.initialize();

  // ()_FilterForm - Disable / Enable filter form buttons and Reset DataTable on submit and on clean
  var filterForm = new AdminTR.FilterForm(
                                'itens', 
                                $('#itensDataTableContainer'), 
                                $('#itensFilterForm'), 
                                $('#itensFilterSubmit'), 
                                $("#itensFilterClean")
                              );
  
  filterForm.initialize();

  // ()_DependentDropdown
  
  var dependentDropdown = new AdminTR.DependentDropdown($('#S_categoria_id'), $('#S_subcategoria_id'), null, true, 'SELECIONE UMA CATEGORIA', 'SELECIONAR SUBCATEGORIA');
  
  dependentDropdown.initialize();

  // Select 2 Pages

  new AdminTR.select2Builder($('.select2__pages'), 'action-select2-pages', 'pages', true);

  // Select 2 Tags

  new AdminTR.select2Builder($('.select2__tags'), 'action-select2-tags', 'tags', true, false, true);

  // JQuery Select2 - Reset on filter clean click

  $("#itensFilterClean").on('click',  function() {

    $('#S_categoria_id').val('').trigger('change');

    $('#S_subcategoria_id').empty().append($('<option>').text('SELECIONE UMA CATEGORIA').val('')).trigger('change');

    $('#S_tags').empty().trigger('change');
  });
});