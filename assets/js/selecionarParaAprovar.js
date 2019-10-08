function selecionarParaAprovar(){

  document.getElementById('modal-content').innerHTML = "";
  var objeto = document.getElementsByName('selecionar');

    for(var i=0, n=objeto.length;i<n;i++) {
      if(objeto[i].checked == true){
        var valor = objeto[i].value;
        $.get(main_url + "findExame/" + valor, function (data) {
          $.get(main_url + "findPaciente/" + data.solicitacao.paciente_id, function (dataP) {
            $.get(main_url + "findTipoReagente/" + data.laudo.tipo_reagente_id, function (dataTR) {

              document.getElementById('modal-content').innerHTML += "<span class='badge badge-primary badge-pill'>Solicitação</span> " +  "<small>" + data.solicitacao.numero + "</small>" + " <span class='badge badge-secondary badge-pill'>Exame</span> " + "<small><b>" + data.tipo_exame.abreviacao + "</b></small>" + " <span class='badge badge-secondary badge-pill'>Resultado</span> " + "<small><b>" + dataTR.tipo + "</b></small>" +
              "<br>" +
              " <span class='badge badge-secondary badge-pill'>Paciente</span> " +"<small><b>"+ dataP.nome +"</b> "+ dataP.sus + "</small>" +
              "<br>" +
              " <span class='badge badge-secondary badge-pill'>Validade produto</span> " +"<small>"+ data.laudo.validade + "</small>" +
              " <span class='badge badge-secondary badge-pill'>Coleta</span> " +"<small>"+ data.solicitacao.data_coleta + "</small>"
              + " <br><hr> ";

            });
          });
        });
        document.getElementById('selecionarAprovar').value += (valor + ",");
      }
    }

}

function selecionarTodos(objeto){

  var checkboxes = document.getElementsByName('selecionar');

  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = objeto.checked
  }

}

function habilitar(objeto){

  if(objeto.checked == true){
    document.getElementById('submitAguardando').disabled = false;
  }else{
    document.getElementById('submitAguardando').disabled = true;
  }

}
