<div id="modalAprovar" class="modal fade" tabindex="-1" role="dialog">
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

            <div id='modal-content'>
            </div>

          </li>
        </ul>

        <div class="alert alert-warning alert-dismissible alertSolicitacao" role="alert" id="alertSolicitacao">
          {{ trans('exames.aguardando.alert.concordo') }} <input type='checkbox' id='concordo' class='concordo' onclick='habilitar(this)'>
        </div>

      </div>


      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('application.btn.cancel') }}</button>

          {{ Form::model('aprovarForm', array('method' => 'POST', 'route' => array('aguardando.export'))) }}

            {{
              Form::text(
                'selecionarAprovar',
                null,
                array(
                  'id'               => 'selecionarAprovar',
                  'class'            => 'form-control selecionarAprovar',
                  'aria-describedby' => 'selecionarAprovarAddon',
                  'hidden'
                )
              )
            }}

          <button type="submit" id='submitAguardando' class="btn btn-primary" disabled>{{ trans('application.btn.confirm') }}</button>
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>
