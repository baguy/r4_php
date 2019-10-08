function buscarPaciente_sus(){
    var tempsus = $('#sus').val();
    var sus = (tempsus).split(' ').join('');

    $.get(main_url + "busca_sus/" + sus, function (data) {

      if(typeof data.nome != "undefined"){
        document.getElementById('nome').value=(data.nome);
        document.getElementById('nomeHidden').value=(data.nome);
        document.getElementById('susHidden').value=(sus);
      }else{
        document.getElementById("alertPaciente").style.display = "block";
        $(".alertPaciente").fadeTo(2000, 500).slideUp(500, function(){
            $(".alertPaciente").alert('close');
        });
      }
      if(typeof data.nome_mae != "undefined"){
        document.getElementById('nome_mae').value=(data.nome_mae);
      }
      if(typeof data.data_nascimento != "undefined"){
        document.getElementById('data_nascimento').value=(data.data_nascimento);
        document.getElementById('data_nascimentoHidden').value=(data.data_nascimento);
      }
      document.getElementById('sexo').value=(data.tipo_sexo_id);
      document.getElementById('contato1').value=(data.telefones[0].numero);
      if(typeof data.endereco.cep != "undefined"){
        document.getElementById('cep').value=(data.endereco.cep);
      }
      document.getElementById('logradouro').value=(data.endereco.logradouro);
      document.getElementById('numero').value=(data.endereco.numero);
      document.getElementById('bairro').value=(data.endereco.bairro);
      document.getElementById('estado').value=(data.endereco.estado_uf);
      document.getElementById('cidade').value=(data.endereco.cidade_id);
      if(typeof data.telefones[1] != "undefined"){
        document.getElementById('contato2').value=(data.telefones[1].numero);
      }
    });
}

function dataFormatada(data_recebida){
        var res = data_recebida.split("-");
        var ano = res[0];
        var mes = res[1];
        var dia = res[2];
    return dia+"/"+mes+"/"+ano;
}
