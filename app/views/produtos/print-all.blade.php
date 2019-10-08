@extends('templates.print')

@section('PAGE_TITLE')
  {{ trans('itens.item(ns)') }}
@stop

@section('STYLES')

  <!-- &_Itens -->
  <link rel="stylesheet" href="{{ asset('assets/css/&_itens.css') }}">

@stop

@section('MAIN')

	@define $C_group = Input::get('C_group')

	@foreach ($itens as $key => $item)

		@include('itens/_print')

	@endforeach

	<div class="text-center text-secondary pt-2 pb-3 d-print-none">
	  {{ 
	    trans('pagination.table.caption', [
	      'total' => $itens->getTotal(), 
	      'currentPage' => $itens->getCurrentPage(), 
	      'lastPage' => $itens->getLastPage(), 
	      'perPage' => $itens->getPerPage()
	    ]) 
	  }}
	</div>

	{{ $itens->appends(Input::get())->links() }}

@stop

@section('SCRIPTS')

	<!-- ()_PageBreaker -->
  <script src="{{ asset('assets/js/()_page.breaker.js') }}"></script>

	<script type="text/javascript">

		$(function() {

      // Verify if elements are not crossing the edge of printing page
      var pageBreaker = new AdminTR.PageBreaker(1360);
      
      pageBreaker.initialize();
    });

	</script>
  
@stop