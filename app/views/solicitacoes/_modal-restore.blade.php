<div id="modalRestore_{{ $solicitacao->id }}" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ trans('application.modal.confirmation.title') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="fas fa-times align-text-bottom"></i></span>
        </button>
      </div>
      <div class="modal-body">
        <p><strong>{{ trans('application.modal.confirmation.text') }}</strong></p>
        <ul class="list-group list-group-flush">
          <li class="list-group-item d-flex justify-content-between align-items-center p-1">
            {{ FormatterHelper::dateTimeToPtBR($solicitacao->deleted_at) }}
            <span class="badge badge-dark badge-pill">{{ trans('application.lbl.deleted-at') }}</span>
          </li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('application.btn.cancel') }}</button>
        {{ Form::model($solicitacao, array('method' => 'PATCH', 'route' => array('solicitacoes.restore', $solicitacao->id))) }}
          <button type="submit" class="btn btn-warning">{{ trans('application.btn.confirm') }}</button>
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>
