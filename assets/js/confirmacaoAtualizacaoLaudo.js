function atualizaLaudo() {
  var produtoChange = document.getElementById("produto").value;
  var referenciaChange = document.getElementById("referencia").value;
  var reagenteChange = document.getElementById("reagente").value;
  var descricaoChange = document.getElementById("descricao").value;
  var responsavelChange = document.getElementById("responsavel").value;

  document.getElementById("alertAtualizacao").style.display = "block";
  document.getElementById('botaoAprovar').style.display = 'none';

}
