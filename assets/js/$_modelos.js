$(document).ready(function () {

  // CKEditor

  var toolbar = [
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

  var allEditors = document.querySelectorAll('.ckeditor');

  for (var i = 0; i < allEditors.length; ++i) {
    
    ClassicEditor.create(allEditors[i], {

      toolbar: toolbar

    }).then(editor => {

      window.CKEditor5 = editor;

      CKEditor5.ui.focusTracker.on('change:isFocused', (evt, name, isFocused) => {

        if (!isFocused)

          CKEditor5.updateSourceElement();

      });

    }).catch(error => {

      console.error(error);
    });
  }

  // Form Validation - Create

  var baseURL    = $('body').data('url');

  var modeloForm = $('#modeloForm');

  var rules      = {

    nome: {

      required  : [ true, 'Nome' ],
      maxlength : 45, 
      remote    : `${baseURL}/unique/modelos/nome/NULL`
    },

    texto: {

      required  : [ true, 'Texto' ]
    }
  };

  var messages = {};

  // Form Validation - Edit

  if(modeloForm.data('resource-id')) {

    modeloID = modeloForm.data('resource-id');

    // Rule modification for update
    rules.nome.remote = `${baseURL}/unique/modelos/nome/${modeloID}`;
  }

  // Form Validation

  modeloForm.validate({

    onfocusout: false,

    rules: rules,

    messages: messages
  });

});