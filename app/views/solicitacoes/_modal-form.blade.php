<div id="modalForm" class="modal fade" tabindex="-1" role="dialog">
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

        <div class="alert alert-secondary modalContinuar" role="alert" id="modalContinuar">
          {{ trans('solicitacoes.modal.continuar') }}
        </div>

        <div class="alert alert-warning" role="alert" id="modalAviso" style="display:none">
          {{ trans('solicitacoes.modal.aviso') }}
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('application.btn.cancel') }}</button>
        {{ Form::model('solicitacaoForm', array('method' => 'POST', 'route' => array('solicitacoes.store'))) }}
          <button type="submit" class="btn btn-primary">{{ trans('application.btn.confirm') }}</button>
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>
