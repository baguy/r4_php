$(document).ready(function () {

  // Form Validation - Create

  var baseURL     = $('body').data('url');

  var unidadeForm = $('#unidadeForm');

  var unidadeID   = null;

  var rules       = {

    tipo: {

      required  : [ true, 'Tipo' ],
      maxlength : 45, 
      remote    : `${baseURL}/unique/unidades/tipo/NULL`
    }
  };

  var messages = {};

  // Form Validation - Edit

  if(unidadeForm.data('resource-id')) {

    unidadeID = unidadeForm.data('resource-id');

    // Rule modification for update
    rules.tipo.remote = `${baseURL}/unique/unidades/tipo/${unidadeID}`;
  }

  // Form Validation

  unidadeForm.validate({

    rules: rules,

    messages: messages
  });

});