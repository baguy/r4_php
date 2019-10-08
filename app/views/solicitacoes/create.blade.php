@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('solicitacoes.page.title.create') }}
@stop

@section('MAIN')

	@include('solicitacoes/_form', ['is_parent' => true])

@stop

@section('SCRIPTS')

  <!-- JQuery Validation -->
  <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>

  <!-- JQuery Validation - Additional Methods -->
  <script src="{{ asset('assets/plugins/jquery-validation/additional-methods.min.js') }}"></script>

  <!-- JQuery Validation - Localization pt_BR -->
  <script src="{{ asset('assets/plugins/jquery-validation/localization/messages_pt_BR.min.js') }}"></script>

  <!-- JQuery Form Validator -->
  <script src="{{ asset('assets/js/jQuery.form.validator.js') }}"></script>

  <!-- $_Unidades -->
  <script src="{{ asset('assets/js/$_unidades.js') }}"></script>

  <!-- Buscar paciente -->
  <script src="{{ asset('assets/js/buscarPaciente_sus.js') }}"></script>

  <!-- Buscar cidade dependente de estado -->
  <script src="{{ asset('assets/js/estado_cidade.js') }}"></script>

  <!-- CEP automático -->
  <script src="{{ asset('assets/js/cep_automatico.js') }}"></script>

  <!-- Máscaras -->
  <script src="{{ asset('assets/js/masks_validators.js') }}"></script>
  <script src="{{ asset('assets/js/validate-methods.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

  <!-- Função de seleção de exibição de amostras condicionada por checkbox de exames -->
  <script src="{{ asset('assets/js/mostraAmostra.js') }}"></script>

  <!-- Função para seleção automática de exames predefinidos -->
  <script src="{{ asset('assets/js/examePredefinido.js') }}"></script>

  <!-- Função para validação de número da Solicitação -->
  <script src="{{ asset('assets/js/buscaSolicitacao.js') }}"></script>

  <!-- Função para confirmar cadastro de solicitação -->
  <script src="{{ asset('assets/js/confimacaoSolicitacao.js') }}"></script>

  <!-- Função para selecionar exames predefinidos -->
  <script src="{{ asset('assets/js/examePredefinido.js') }}"></script>

@stop
