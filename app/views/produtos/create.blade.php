@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('produtos.page.title.create') }}
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

  <!-- ()_Select2Builder -->
  <script src="{{ asset('assets/js/()_select2.builder.js') }}"></script>

  <!-- ()_QuickRegistration -->
  <script src="{{ asset('assets/js/()_quick.registration.js') }}"></script>

  <!-- Máscaras -->
  <script src="{{ asset('assets/js/masks_validators.js') }}"></script>
  <script src="{{ asset('assets/js/validate-methods.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

@stop
