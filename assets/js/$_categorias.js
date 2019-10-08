$(document).ready(function () {

  // Form Validation - Create

  var baseURL       = $('body').data('url');

  var categoriaForm = $('#categoriaForm');

  var categoriaID   = null;

  var rules         = {

    nome: {

      required  : [ true, 'Nome' ],
      maxlength : 100, 
      remote    : `${baseURL}/unique/categorias/nome/NULL`
    }
  };

  var messages = {};

  // Form Validation - Edit

  if(categoriaForm.data('resource-id')) {

    categoriaID = categoriaForm.data('resource-id');

    // Rule modification for update
    rules.nome.remote = `${baseURL}/unique/categorias/nome/${categoriaID}`;
  }

  // Form Validation

  categoriaForm.validate({

    rules: rules,

    messages: messages
  });

});