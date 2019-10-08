function mostraAmostra(objeto){

    var valor = objeto.value;
    var amostra = document.getElementsByClassName('amostra_'+valor);
    if(objeto.checked == true){
      amostra[0].style.display = 'block';
    }else{
      amostra[0].style.display = 'none';
    }

}

$(document).ready(function(){

  var exames = document.getElementsByClassName('exame');
  l = exames.length;
  for (i = 0; i < l; i++) {
    mostraAmostra(exames[i]);
  }

})
