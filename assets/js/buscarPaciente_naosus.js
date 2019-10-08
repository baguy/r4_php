function buscarPaciente_naosus(){
    var tempnaosus = $('#nao_sus').val();
    var nao_sus = (tempnaosus).split(' ').join('');

    $.get(ROOT + "/paciente_naosus/" + nao_sus, function (data) {

      document.getElementById('nome').value=(data.nome);
      document.getElementById('nomeMae').value=(data.nomeMae);
      document.getElementById('dataNascimento').value=(data.dataNascimento);
      $(".sexo[value='" + data.ajaxSexo + "']").prop("checked", true);
      document.getElementById('telefone').value=(data.telefone);
      document.getElementById('celular').value=(data.celular);
      document.getElementById('endereco').value=(data.endereco.endereco);
      document.getElementById('cep').value=(data.endereco.cep);
      document.getElementById('numero').value=(data.endereco.numero);
    });

}
