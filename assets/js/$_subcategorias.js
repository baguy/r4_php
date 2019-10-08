$(document).ready(function () {

  // Form Validation - Create

  var baseURL          = $('body').data('url');

  var subcategoriaForm = $('#subcategoriaForm');

  var subcategoriaID   = null;

  var rules            = {

    nome: {

      required  : [ true, 'Nome' ],
      maxlength : 255, 
      remote    : `${baseURL}/unique/subcategorias/nome/NULL`
    }, 
    categoria_id: {

      required  : [ true, 'Categoria' ]
    }
  };

  var messages = {};

  // Form Validation - Edit

  if(subcategoriaForm.data('resource-id')) {

    subcategoriaID = subcategoriaForm.data('resource-id');

    // Rule modification for update
    rules.nome.remote = `${baseURL}/unique/subcategorias/nome/${subcategoriaID}`;
  }

  // Form Validation

  subcategoriaForm.validate({

    rules: rules,

    messages: messages
  });

  // Select 2 Pages

  new AdminTR.select2Builder($('.select2__pages'), 'action-select2-pages', 'pages');

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
    messages
  );
  
  quickRegistration_Category.initialize();

});