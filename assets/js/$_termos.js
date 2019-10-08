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

  // jQuery Validation - Custom Methods

  jQuery.validator.addMethod("enum", function(value, element, params) {

    return this.optional(element) || value === 'AQUISIÇÃO' || value === 'SERVIÇOS' || value === 'AQUISIÇÃO & SERVIÇOS';

  }, jQuery.validator.format("O campo {0} não contém um valor válido"));

  // Form Validation - Create / Edit

  var baseURL  = $('body').data('url');

  var termoForm = $('#termoForm');

  var itens = jQuery.map($('input:hidden[name^="itens"]'), function (n, i) {

    return n.name;

  }).join(' ');

  var groups = {

    itens: itens
  }

  var rules    = {

    texto: {

      required  : [ true, 'Texto' ]
    },

    tipo: {

      required  : [ true, 'Tipo' ], 
      enum      : [ 'Tipo' ]
    },

    origem_id: {

      required  : [ true, 'Origem' ]
    },

    destino_id: {

      required  : [ true, 'Destino' ]
    }
  };

  var messages = {};

  // Form Validation

  termoForm.validate({

    onfocusout: false,

    groups: groups,

    rules: rules,

    messages: messages
  });

  // Add rules to checkbox roles if exists
  $('input:hidden[name^="itens"]').each(function() {

    $(this).rules('add', {

      at_least_one : [ true, 'Item(ns)' ]
    });
  });

  // ()_Select2TemplateResultBuilder
  var select2TemplateResultBuilder = new AdminTR.Select2TemplateResultBuilder(false, $('#termoForm'));
  
  select2TemplateResultBuilder.initialize();

  // ()_ItemsContainer
  var itemsContainer = new AdminTR.ItemsContainer(select2TemplateResultBuilder);
  
  itemsContainer.initialize();

  // Prepare popover content - Handlebars

  var source = $('#help__contentReplacement--vars').html();

  var hbsContentReplacement = Handlebars.compile(source);

  var html = hbsContentReplacement();

  // Reset Bootstrap Popover
  $('[data-popover="reset"]').popover({
    container : 'body',
    placement : 'right',
    html      : true,
    content   : $(html)

  });

  $('[data-popover="reset"]').on('click', function (e) {

    $('[data-popover="reset"]').not(this).popover('hide');
    
  });

  $('[data-popover="reset"]').on('shown.bs.popover', function () {

    // Reset Bootstrap Tooltip
    $('[data-tooltip="reset"]').tooltip();
    
    $('code.js-copy').click(function() {

      var $temp = $("<input>");

      $('body').append($temp);

      $temp.val($.trim($(this).text())).select();

      document.execCommand("copy");

      $temp.remove();

      doBounce($(this), 2, '3px', 100);
    });
  });

  function doBounce(element, times, distance, speed) {

    for(i = 0; i < times; i++) {

        element.animate({ marginLeft: '-=' + distance }, speed)
            .animate({ marginLeft: '+=' + distance }, speed);
    }
  }

  // JQuery Model Switcher - Updates CKEditor's instance on '.js-model-switcher' change

  $(".js-model-switcher").on('change',  function() {

    var url = $(this).data('action-model-switcher');

    var id  = $(this).val();

    $.get(`${url}/${id}`, function(data) {

      CKEditor5.setData(data.texto);

    }).fail(function() {
      
      CKEditor5.setData('');

    });

  });
  
});