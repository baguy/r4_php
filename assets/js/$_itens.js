$(document).ready(function () {

  // CKEditor

  toolbar = [
    'heading',
    '|',
    'bold',
    'italic',
    'underline',
    'strikethrough',
    'code',
    'subscript',
    'superscript',
    '|',
    'fontSize',
    'fontFamily',
    'alignment',
    'highlight',
    'link',
    'bulletedList',
    'numberedList',
    'blockQuote',
    'insertTable',
    'undo',
    'redo'
  ];
  
  ClassicEditor.create(document.querySelector('#especificacao'), {

    toolbar: toolbar

  }).then(editor => {

    window.editor = editor;

    editor.ui.focusTracker.on('change:isFocused', (evt, name, isFocused) => {

      if (!isFocused)

        editor.updateSourceElement();

    });

  }).catch(error => {

    console.error(error);
  });

  // jQuery Validation - Custom Methods

  jQuery.validator.addMethod("enum", function(value, element, params) {

    return this.optional(element) || value === 'BENS DE CONSUMO' || value === 'BENS PERMANENTES' || value === 'SERVIÇOS';

  }, jQuery.validator.format("O campo {0} não contém um valor válido"));

  // Form Validation - Create

  var baseURL  = $('body').data('url');

  var itemForm = $('#itemForm');

  var itemID   = null;

  var rules    = {

    descricao: {

      required  : [ true, 'Nome' ],
      maxlength : 255, 
      remote    : `${baseURL}/unique/itens/descricao/NULL`
    }, 
    especificacao: {

      required  : [ true, 'Especificação' ]
    }, 
    tipo: {

      required  : [ true, 'Tipo' ], 
      enum      : [ 'Tipo' ]
    }, 
    categoria_id: {

      required  : [ true, 'Categoria' ]
    }, 
    subcategoria_id: {

      required  : [ true, 'Subcategoria' ]
    }, 
    unidade_id: {

      required  : [ true, 'Unidade' ]
    }
  };

  var messages = {};

  // Form Validation - Edit

  if(itemForm.data('resource-id')) {

    itemID = itemForm.data('resource-id');

    // Rule modification for update
    rules.descricao.remote = `${baseURL}/unique/itens/descricao/${itemID}`;
  }

  // Form Validation

  itemForm.validate({

    onfocusout: false,

    rules: rules,

    messages: messages
  });

  // Dependent Dropdown
  
  var dependentDropdown = new AdminTR.DependentDropdown($('#categoria_id'), $('#subcategoria_id'), $('#subcategoriaSelecionada'), false, 'SELECIONE UMA CATEGORIA', 'SELECIONAR SUBCATEGORIA');
  
  dependentDropdown.initialize();

  // Select 2 Pages

  new AdminTR.select2Builder($('.select2__pages'), 'action-select2-pages', 'pages');

  // Select 2 Tags

  new AdminTR.select2Builder($('.select2__tags'), 'action-select2-tags', 'tags', false, true, true);

  // Quick Registration

  // Categoria

  var rules    = {

    nome: {

      required  : [ true, 'Nome' ],
      maxlength : 100, 
      remote    : `${baseURL}/unique/categorias/nome/NULL`
    }
  };

  var quickRegistration_Category = new AdminTR.QuickRegistration(
    $('#categoria_id'), 
    $('#addCategoryButton'), 
    $('#addCategoryModal'), 
    rules, 
    messages, 
    {
      '$_addButton' : $('#addSubcategoryButton'), 
      '$_modal'     : $('#addSubcategoryModal'), 
      '$_form'      : $('#subcategoriaForm'), 
      '$_field'     : $('#categoria_id__hidden')
    }
  );
  
  quickRegistration_Category.initialize();



  // Subcategoria

  var rules    = {

    nome: {

      required  : [ true, 'Nome' ],
      maxlength : 255, 
      remote    : `${baseURL}/unique/subcategorias/nome/NULL`
    }, 
    categoria_id: {

      required  : [ true, 'Categoria' ]
    }
  };

  var quickRegistration_Subcategory = new AdminTR.QuickRegistration(
    $('#subcategoria_id'), 
    $('#addSubcategoryButton'), 
    $('#addSubcategoryModal'), 
    rules, 
    messages
  );
  
  quickRegistration_Subcategory.initialize();



  // Unidade

  var rules    = {

    tipo: {

      required  : [ true, 'Tipo' ],
      maxlength : 45, 
      remote    : `${baseURL}/unique/unidades/tipo/NULL`
    }
  };

  var quickRegistration_Unit = new AdminTR.QuickRegistration(
    $('#unidade_id'), 
    $('#addUnitButton'), 
    $('#addUnitModal'), 
    rules, 
    messages
  );
  
  quickRegistration_Unit.initialize();

});