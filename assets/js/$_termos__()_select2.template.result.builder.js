var AdminTR = AdminTR || {};

AdminTR.Select2TemplateResultBuilder = (function() {
    
  function Select2TemplateResultBuilder(is_filter, $_form = null) {
    
    this.$_element         = $('.select2__templates');
    this.url               = this.$_element.data('action-select2-templates');
    this.is_filter         = is_filter;
    this.$_form            = $_form;

    var source             = $('#select2__templateResult--item').html();

    this.hbsTemplateResult = Handlebars.compile(source);

    this.$_container       = $('.js-table-items-container');
    this.$_alert           = this.$_container.children('.alert');

    this.emitter           = $({});
    this.on                = this.emitter.on.bind(this.emitter);
  }
  
  Select2TemplateResultBuilder.prototype.initialize = function() {

    var settings = {

      ajax: {

        url: ajax_URL.bind(this), 

        dataType: 'json', 

        delay: 250, 

        data: ajax_Data.bind(this), 

        processResults: ajax_ProcessResults.bind(this),

        cache: true
      }, 

      minimumInputLength: 3, 

      templateResult: templateResult.bind(this), 

      templateSelection: templateSelection.bind(this)
    }

    this.$_element.select2(settings);

    this.$_element.on('select2:select', select2_Select.bind(this));

    // Edit - Get Items 

    if (this.$_form && this.$_form.data('resource-id'))

      $.get(this.$_form.data('action-get-items'), getItems.bind(this));
  }

  function ajax_URL(params) {
          
    return `${ this.url }/${ params.term || 'null' }`;
  }

  function ajax_Data(params) {

    return {
      is_filter : this.is_filter, 
      term      : params.term, 
      _type     : params._type, 
      q         : params.term, 
      page      : params.page || 1
    };
  }

  function ajax_ProcessResults(response) {

    return {

      results: $.map(response.data, function (item) {

        return { 
          id: item.id, 
          descricao: item.descricao, 
          subcategoria: item.subcategoria, 
          tipo: item.tipo, 
          unidade: item.unidade, 
          especificacao: item.especificacao
        };
      }),

      pagination: {

        more: (response.current_page * 25) < response.total
      }
    };
  }

  function templateResult(item) {

    if (item.loading)

      return item.text;

    if (item.id) {

      var html = this.hbsTemplateResult(item);
      
      return $(html);
    }

  }

  function templateSelection(item) {

    return item.descricao || item.text;
  }

  function select2_Select(e) {

    var item = e.params.data;

    item.pivot = { quantidade: 1 };

    this.emitter.trigger('item-selected', item);

    if (!this.is_filter)

      this.$_element.val(null).trigger('change');
  }

  // Edit - Get Items
  
  function getItems(data) {
        
    if (data.valueOf().toString() !== '')
      
      $.each(data, appendItems.bind(this));
  }
  
  function appendItems(index, element) {
    
    this.emitter.trigger('item-selected', element);
  }
  
  return Select2TemplateResultBuilder;
    
}());