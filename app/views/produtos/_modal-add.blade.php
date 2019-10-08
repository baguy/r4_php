<div class="modal fade" id="{{ $modal_id }}" tabindex="-1" role="dialog" aria-labelledby="{{ $modal_label }}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="{{ $modal_label }}">{{ trans('application.btn.add') }} {{ $title }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" data-error="{{ trans('application.msg.error.something-went-wrong') }}">

        <div class="alert alert-success mb-2" role="alert" style="display: none;">
          
        </div>

        <div class="alert alert-danger mb-2 session-flash" role="alert" style="display: none;">
          <ul class="list-unstyled"></ul>
        </div>

        @if ($resource === 'categorias')

            @include('categorias/_form', ['is_parent' => false])

        @elseif ($resource === 'subcategorias')

            @include('subcategorias/_form', ['is_parent' => false])

        @elseif ($resource === 'unidades')

            @include('unidades/_form', ['is_parent' => false])

        @endif
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('application.btn.close') }}</button>
        <button type="button" class="btn btn-primary js-modal-save-button">{{ trans('application.btn.save') }}</button>
      </div>
    </div>
  </div>
</div>