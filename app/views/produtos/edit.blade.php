@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('produtos.page.title.edit') }}
@stop

@section('STYLES')



@stop

@section('MAIN')

  @include('produtos/_form')

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

  <!-- JQuery CKEditor -->
  <script src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}"></script>

  <!-- ()_DependentDropdown -->
  <script src="{{ asset('assets/js/()_dependent.dropdown.js') }}"></script>

  <!-- ()_Select2Builder -->
  <script src="{{ asset('assets/js/()_select2.builder.js') }}"></script>

  <!-- ()_QuickRegistration -->
  <script src="{{ asset('assets/js/()_quick.registration.js') }}"></script>

  <!-- $_Itens -->
  <script src="{{ asset('assets/js/$_itens.js') }}"></script>

@stop
