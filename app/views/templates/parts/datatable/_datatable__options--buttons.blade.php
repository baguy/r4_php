@if( $is_trashed && Auth::user()->hasRole('LAB') )

  <a
    class="btn btn-warning {{ !$has_permission ? 'disabled' : '' }}"
    href="#modalRestore_{{ $modal_id }}"
    data-toggle="modal"
    data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.restore') }}">
    <i class="fas fa-recycle fa-fw"></i>
  </a>

@elseif( Auth::user()->hasRole('LAB') )

  <a
    class="btn btn-danger"
    href="#modalDelete_{{ $modal_id }}"
    data-toggle="modal"
    data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.delete') }}">
    <i class="fas fa-trash-alt fa-fw"></i>
  </a>

@endif

@if( Auth::user()->hasRole('LAB') )
  <a
    href="{{ $route_edit }}"
    class="btn btn-info {{ ($is_trashed) ? 'disabled' : '' }}"
    data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.edit') }}">
    <i class="fas fa-pencil-alt fa-fw"></i>
  </a>
@endif

<a
  href="{{ $route_show }}"
  class="btn btn-default {{ ($is_trashed) ? 'disabled' : '' }}"
  data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.show') }}">
  <i class="fas fa-search fa-fw"></i>
</a>

@if($is_printable)

  <a
    href="{{ $route_print_one }}"
    class="btn btn-dark"
    target="_blank"
    data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.print') }}">
    <i class="fas fa-print fa-fw"></i>
  </a>

@endif
