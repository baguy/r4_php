$(document).ready(function () {
  var produto = $('#produto'),
      lote = $('#lote'),
      validade = $('#validade');

  $(produto).change(async function () {
    lote.val("");
    validade.val("");
    mudaDadosProduto(produto, lote, validade);
  });

  /**
  * Seleciona as dados do produto conforme o produto selecionado
  * @param {object} produto elemento select
  * @param {object} lote elemento dinâmico
  * @param {object} validade elemento dinâmico
  * @author Mayra Dantas Bueno
  */
  async function mudaDadosProduto(produto,validade,lote){
    var options = "<option value='' selected>Selecione</option>";
    if(produto.val() !== "") {
      $.get(main_url + "findDadosProduto/" + produto.val(), function (data) {
        document.getElementById('lote').value=(data.lote);
        document.getElementById('validade').value=(data.validade);
      });
    }

  }

});
