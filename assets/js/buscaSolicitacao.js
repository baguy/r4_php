$(document).ready(function(){
/**
* Verificar se número da Solicitação é único
* @author Mayra Dantas Bueno
*/
var num = $('#numeroSolicitacao');

$(num).change(async function () {
  var value = jQuery.trim($(num).val());
  value = value.replace(/[^\d]+/g,'');
  procuraSolicitacao(num,value);
});

async function procuraSolicitacao(num,value) {
  var retorno = false;
  if(value !== "") {
    $.get(main_url + "findSolicitacao/" + value, function (data) {
      if(data.length){
              document.getElementById("alertSolicitacao").style.display = "block";
              $(".alertSolicitacao").fadeTo(2000, 500).slideUp(500, function(){
                  $(".alertSolicitacao").alert('close');
              });
              document.getElementById('numeroSolicitacao').value=(''); // zera o campo da soliicitação
            }
    });
  }
};

function toggleAlert(){
    $(".alert").toggleClass('in out');
    return false; // Keep close.bs.alert event from removing from DOM
}

}); // .$(documento).ready
