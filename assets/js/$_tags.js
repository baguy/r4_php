$(document).ready(function () {

  // Form Validation - Create

  var baseURL  = $('body').data('url');

  var tagForm = $('#tagForm');

  var tagID   = null;

  var rules    = {

    nome: {

      required  : [ true, 'Nome' ],
      maxlength : 60, 
      remote    : `${baseURL}/unique/tags/nome/NULL`
    }
  };

  var messages = {};

  // Form Validation - Edit

  if(tagForm.data('resource-id')) {

    tagID = tagForm.data('resource-id');

    // Rule modification for update
    rules.nome.remote = `${baseURL}/unique/tags/nome/${tagID}`;
  }

  // Form Validation

  tagForm.validate({

    rules: rules,

    messages: messages
  });

});