$(document).ready(function () {

  // Form Validation - Create

  var baseURL        = $('body').data('url');

  var secretariaForm = $('#secretariaForm');

  var secretariaID   = null;

  var rules          = {

    nome: {

      required  : [ true, 'Nome' ],
      maxlength : 100, 
      remote    : `${baseURL}/unique/secretarias/nome/NULL`
    },

    endereco: {

      maxlength : 100
    }
  };

  var messages = {};

  // Form Validation - Edit

  if(secretariaForm.data('resource-id')) {

    secretariaID = secretariaForm.data('resource-id');

    // Rule modification for update
    rules.nome.remote = `${baseURL}/unique/secretarias/nome/${secretariaID}`;
  }

  // Form Validation

  secretariaForm.validate({

    rules: rules,

    messages: messages
  });

});