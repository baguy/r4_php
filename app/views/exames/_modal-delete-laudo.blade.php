<div id="modalDeleteLaudo_{{ $data['exame']->laudo->id }}" class="modal fade" tabindex="-1" role="dialog">
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
            {{ trans('laudos.pdf') }} {{ $data['exame']->tipoExame->tipo }}
            <span class="badge badge-black badge-pill">{{ trans('laudos.laudo') }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center p-1">
            <span class="text-secondary">{{ $data['exame']->laudo->tipoReagente->tipo }}</span>
            <span class="badge badge-black badge-pill">{{ trans('laudos.lbl.resultado') }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center p-1">
            <span class="text-secondary">{{ $data['exame']->solicitacao->paciente->nome }}</span>
            <span class="badge badge-black badge-pill">{{ trans('pacientes.paciente') }}</span>
          </li>

          @if(isset($data['exame']->laudo->download[0]))
            <li class="list-group-item list-group-item-info d-flex justify-content-between align-items-center p-1">
              <span class="text-secondary">{{count($data['exame']->laudo->download)}}</span>
              <span class="badge badge-info badge-pill">{{ trans('application.btn.download') }}</span>
            </li>

            @foreach( $data['exame']->laudo->download as $key => $value )

              <li class="list-group-item justify-content-between align-items-center p-1">
                <span class="text-secondary">{{ ($value->pdf) }}</span>
                <span class="badge badge-secondary badge-pill">{{ trans('laudos.pdf.created-at') }}</span>
                <span class="text-secondary">{{ FormatterHelper::dateTimeToPtBR($value->created_at) }}</span>
                <span class="badge badge-secondary badge-pill">{{ trans('unidades.unidade') }}</span>
                <span class="text-secondary">{{ ($value->user->unidade->nome) }}</span>
              </li>

            @endforeach
          @endif

        </ul>
      </div>
      <div class="modal-footer">
        {{ Form::model($data['exame']->laudo, array('method' => 'DELETE', 'route' => array('laudos.destroy', $data['exame']->laudo->id))) }}
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('application.btn.cancel') }}</button>
          <button type="submit" class="btn btn-danger">{{ trans('application.btn.confirm') }}</button>
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>
