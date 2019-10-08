var AdminTR = AdminTR || {};

AdminTR.ItemsContainer = (function() {
    
  function ItemsContainer(select2TemplateResultBuilder) {
    
    this.select2TemplateResultBuilder = select2TemplateResultBuilder;

    var source       = $('#select2__onSelect--item').html();

    this.hbsOnSelect = Handlebars.compile(source);

    this.item        = null;

    this.$_container = $('.js-table-items-container');
    this.$_temp      = this.$_container.contents();
    this.$_alert     = this.$_container.children('.alert');
  }
  
  ItemsContainer.prototype.initialize = function() {

    this.select2TemplateResultBuilder.on('item-selected', onItemSelected.bind(this));
  }

  function onItemSelected(event, item) {

    this.item   = item;

    var html    = this.hbsOnSelect(this.item);

    var $_items = this.$_container.find('.hbs-selected-item');

    var exists  = false

    // If alert exists remove it
    if (this.$_alert)

      this.$_alert.remove();

    // If items size is greater than 0
    if ($_items.length > 0)

      exists = $_items.filter(_filter.bind(this)).length;

    // If item doesn't exist append it
    if (!exists) {

      // If items size is equals 0 container is cleaned
      if ($_items.length === 0)

        this.$_container.html('');

      this.$_container.append($(html));

      bindRemoveItemClick.call(this);
    }

    // Reset Tooltip
    $('[data-tooltip="tooltip"]').tooltip();
  }

  function _filter(index, element) {

    if ($(element).data('resource-id') === this.item.id) {

      var $_quantity = $(element).find('.js-txt-item-quantity');

      var $_quantity__val = $_quantity.val();

      $_quantity.val(parseInt($_quantity__val) + 1);

      return true;
    }

    return false;
  }

  function bindRemoveItemClick() {

    $('.js-btn-remove-item').on('click', onRemoveItemClick.bind(this));
  }

  function onRemoveItemClick(event) {

    var $_target = $(event.target);

    $_target.parents('.hbs-selected-item').addClass('remove-confirmation');

    $('.js-btn-confirm-remove-action').on('click', onConfirmActionClick.bind(this));

    $('.js-btn-cancel-remove-action').on('click', onCancelActionClick.bind(this));
  }

  function onConfirmActionClick(event) {

    var $_target = $(event.target).parents('.hbs-selected-item');

    $_target.hide(350, function() {

      var $_items = $_target.siblings('.hbs-selected-item');
      
      $_target.remove();

      if ($_items.length === 0)

        this.$_container.html(this.$_temp);

    }.bind(this));
  }

  function onCancelActionClick(event) {

    var $_target = $(event.target);

    $_target.parents('.hbs-selected-item').removeClass('remove-confirmation');
  }
  
  return ItemsContainer;
    
}());