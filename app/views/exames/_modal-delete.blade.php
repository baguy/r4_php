<div id="modalDelete_{{ $data['exame']->id }}" class="modal fade" tabindex="-1" role="dialog">
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
            {{ $data['exame']->tipoExame->tipo }}
            <span class="badge badge-dark badge-pill">{{ trans('exames.exame') }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center p-1">
            <span class="text-secondary">{{ $data['exame']->solicitacao->paciente->nome }}</span>
            <span class="badge badge-secondary badge-pill">{{ trans('pacientes.paciente') }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center p-1">
            <span class="text-secondary">{{ $data['exame']->solicitacao->numero }}</span>
            <span class="badge badge-secondary badge-pill">{{ trans('solicitacoes.solicitacao') }}</span>
          </li>
        </ul>
      </div>
      <div class="modal-footer">
        {{ Form::model($data['exame']->laudo, array('method' => 'DELETE', 'route' => array('exames.destroy', $data['exame']->id))) }}
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('application.btn.cancel') }}</button>
          <button type="submit" class="btn btn-danger">{{ trans('application.btn.confirm') }}</button>
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>
