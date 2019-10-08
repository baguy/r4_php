@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('unidades.page.title.edit') }}
@stop

@section('MAIN')

  @include('unidades/_form', ['is_parent' => true])

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
  
@stop