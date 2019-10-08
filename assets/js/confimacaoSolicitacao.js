function comparaSus() {
  var nomeHidden = document.getElementById("nomeHidden").value;
  var nomeForm = document.getElementById("nome").value;
  var dataHidden = document.getElementById("data_nascimentoHidden").value;
  var dataForm = document.getElementById("data_nascimento").value;
  var susHidden = document.getElementById("susHidden").value;
  var susForm = document.getElementById("sus").value;

  var susFormStripped = susForm.replace(/\s/g, "")

  if(susFormStripped == susHidden){
    if( nomeHidden != nomeForm || dataHidden != dataForm){
      document.getElementById("modalContinuar").style.display = "none";
      document.getElementById("modalAviso").style.display = "block";
    }
  }

}
