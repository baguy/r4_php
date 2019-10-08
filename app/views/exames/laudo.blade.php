@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('exames.page.title.show') }}
@stop

@section('MAIN')

  @define $isAdmin   = Auth::user()->hasRole('LAB')

  @define $isTrashed = $data['exame']->trashed()

  <?php

  $pdfActive = False;
  if($data['exame']->laudo){
    if($data['exame']->laudo->pdf_ativo == 1){
      $pdfActive = True;
    }
  }

  ?>

  <div class="row">

    <div class="col-6">

      <!-- Nav Tabs Custom -->
      <div class="card">

        <div class="card-header p-2">

          <ul class="nav nav-pills" id="pills-tab" role="tablist">

            <li class="nav-item mr-2">
              <a
                id="solicitacao-tab"
                class="nav-link active"
                href="#solicitacao-tabPanel"
                data-toggle="pill" role="tab" aria-controls="solicitacao" aria-selected="true">
                {{ trans('exames.exame') }}</a>
            </li>

            <!-- SHOW - Options - Buttons  -->
            @include('templates/parts/_show__options-buttons', [
              'has_min_permission' => Auth::user()->hasRole('LAB'),
              'has_max_permission' => $isAdmin,
              'is_trashed'         => $isTrashed,
              'modal_id'           => $data['exame']->id,
              'route_edit'         => route('solicitacoes.edit', [ $data['exame']->solicitacao->id ]),
              'is_printable'       => false
            ])

          </ul>

        </div>

        <!-- Card Body -->
        <div class="card-body">

          <!-- Tab Content -->
          <div class="tab-content" id="pills-tabContent">

            <!-- Tab Pane -->
            <div class="tab-pane fade show active" id="solicitacao-tabPanel" role="tabpanel" aria-labelledby="pills-solicitacao-tab">

              <blockquote class="blockquote d-block">
                <p class="mb-0">
                  <i class="fas fa-flask fa-fw mr-1"></i> {{ trans('exames.exame') }}
                </p>
              </blockquote>

              <!-- Dados do exame -->
              <blockquote class="blockquote d-block">

                <footer class="blockquote-footer">
                  {{ $data['exame']->tipoExame->tipo }}
                </footer>

                <footer class="blockquote-footer">
                  <b>{{ trans('exames.lbl.abreviacao') }}</b> {{ $data['exame']->tipoExame->abreviacao }}
                </footer>

                <footer class="blockquote-footer">
                  <b>{{ trans('exames.lbl.metodo') }}</b> {{ $data['exame']->tipoExame->metodo->nome }}
                </footer>

                <footer class="blockquote-footer">
                  <b>{{ trans('exames.lbl.amostra') }}</b> {{ $data['exame']->tipoAmostra->tipo }}
                </footer>

                <footer class="blockquote-footer">
                  <b>{{ trans('solicitacoes.lbl.numero') }}</b> {{ $data['exame']->solicitacao->numero }}
                </footer>


                <p class="mb-0 mt-2">
                  <i class="fas fa-toggle-on fa-fw mr-1"></i> {{ trans('application.lbl.status') }}
                </p>
                  @if($data['exame']->tipo_status_id != 3)

                    <footer class="blockquote-footer">
                      <span class="badge {{ ($data['exame']->tipo_status_id == 1) ? 'badge-warning' : 'badge-dark' }} badge-pill">
                        <i class="fas fa-clock"></i>
                        {{ ($data['exame']->tipo_status_id == 1) ? trans('exames.status.1') : trans('exames.status.2') }}
                      </span><br>
                    </footer>

                  @else
                    <span class="badge badge-success badge-pill mb-1">
                      <i class="fas fa-pen-fancy"></i>
                      {{ trans('exames.status.3') }}
                    </span>
                    <br>

                    <div class='form-row'>

                    {{-- {{
                      link_to_route(
                        'laudos.print-pdf',
                        trans('application.btn.print'),
                        $data['exame']->laudo->id,
                        array(
                          'class' => 'btn btn-secondary btn-sm'
                        )
                      )
                    }} --}}

                    {{
                      link_to_route(
                        'laudos.download-pdf',
                        trans('application.btn.download'),
                        $data['exame']->laudo->id,
                        array(
                          'class' => 'btn btn-secondary btn-sm'
                        )
                      )
                    }}

                    {{-- {{
                      link_to_route(
                        'modalRestoreExame_{{ $data['exame']->laudo->id }}',
                        trans('laudos.btn.destroy-pdf'),
                        $data['exame']->laudo->id,
                        array(
                          'class' => 'btn btn-danger btn-sm','data-toggle' => 'modal'
                        )
                      )
                    }} --}}

                    @if($isAdmin)
                      <small><a
                          class="dropdown-item"
                          href="#modalDeleteLaudo_{{ $data['exame']->laudo->id }}"
                          data-toggle="modal">
                          <i class="fas fa-trash-alt fa-fw text-danger"></i> {{ trans('laudos.btn.destroy-pdf') }}
                        </a></small>
                    @endif

                      </div>

                  @endif

              </blockquote>

              <!-- Dados do Paciente -->
              <blockquote class="blockquote d-block">
                <p class="mb-0">
                  <i class="fas fa-diagnoses fa-fw mr-1"></i> {{ trans('pacientes.paciente') }}
                </p>
                <footer class="blockquote-footer">
                  {{ $data['exame']->solicitacao->paciente->nome }}
                </footer>
                <footer class="blockquote-footer">
                  <b>{{ trans('pacientes.lbl.sus') }}</b> {{ isset($data['exame']->solicitacao->paciente->sus)?$data['exame']->solicitacao->paciente->sus:'Não informado' }}
                </footer>
                <footer class="blockquote-footer">
                  <b>{{ trans('pacientes.lbl.sexo') }}</b> {{ strtolower($data['exame']->solicitacao->paciente->sexo->tipo) }}
                </footer>
                <footer class="blockquote-footer">
                  <b>{{ trans('pacientes.lbl.data') }}</b> {{ isset($data['exame']->solicitacao->paciente->data_nascimento)?$data['exame']->solicitacao->paciente->data_nascimento:'Não informado' }}
                </footer>
                <footer class="blockquote-footer">
                  <b>{{ trans('pacientes.lbl.contato.1') }}</b> {{ isset($data['exame']->solicitacao->paciente->telefones[0])?$data['exame']->solicitacao->paciente->telefones[0]->numero:'Não informado' }}
                </footer>

              </blockquote>

              <!-- Dados da solicitação -->
              <blockquote class="blockquote d-block">
                <p class="mb-0">
                  <i class="fas fa-calendar-alt fa-fw mr-1"></i> {{ trans('solicitacoes.lbl.data-coleta') }}
                </p>
                <footer class="blockquote-footer">
                  {{ FormatterHelper::dateToPtBR($data['exame']->data_coleta) }}
                </footer>
              </blockquote>


              <blockquote class="blockquote d-block">
                <p class="mb-0">
                  <i class="fas fa-calendar-alt fa-fw mr-1"></i> {{ trans('application.lbl.created-at') }}
                </p>
                <footer class="blockquote-footer">
                  {{ FormatterHelper::dateTimeToPtBR($data['exame']->created_at) }}
                </footer>
              </blockquote>

              @if(strtotime($data['exame']->updated_at) > 0)
              <blockquote class="blockquote d-block">
                <p class="mb-0">
                  <i class="fas fa-calendar-alt fa-fw mr-1"></i> {{ trans('application.lbl.updated-at') }}
                </p>
                <footer class="blockquote-footer">
                  {{ FormatterHelper::dateTimeToPtBR($data['exame']->updated_at) }}
                </footer>
              </blockquote>
              @endif

              @if(isset($data['exame']->laudo->id))
                <blockquote class="blockquote d-block">
                  <p class="mb-0">
                    <i class="fas fa-calendar-alt fa-fw mr-1"></i> {{ trans('laudos.lbl.created-at') }}
                  </p>
                  <footer class="blockquote-footer">
                    {{ FormatterHelper::dateTimeToPtBR($data['exame']->laudo->created_at) }}
                  </footer>
                </blockquote>

                @if(strtotime($data['exame']->updated_at) > 0)
                <blockquote class="blockquote d-block">
                  <p class="mb-0">
                    <i class="fas fa-calendar-alt fa-fw mr-1"></i> {{ trans('laudos.lbl.updated-at') }}
                  </p>
                  <footer class="blockquote-footer">
                    {{ FormatterHelper::dateTimeToPtBR($data['exame']->laudo->updated_at) }}
                  </footer>
                </blockquote>
                @endif
              @endif

            </div>
            <!-- /.Tab Pane -->

          </div>
          <!-- /.Tab Content -->

        </div>
        <!-- /.Card Body -->

      </div>
      <!-- /.Nav Tabs Custom -->

    </div>
    <!-- /.Col -->

    <div class="col-6">

      <!-- Nav Tabs Custom -->
      <div class="card">

        <div class="card-header p-2">

          <ul class="nav nav-pills" id="pills-tab" role="tablist">

            <li class="nav-item mr-2">
              <a
                id="solicitacao-tab"
                class="nav-link active"
                href="#solicitacao-tabPanel"
                data-toggle="pill" role="tab" aria-controls="solicitacao" aria-selected="true">
                {{ trans('exames.laudo') }}</a>
            </li>

            @if($data['exame']->laudo)

              @define $isTrashedLaudo = $data['exame']->laudo->trashed()

            @endif

          </ul>

        </div>

        <!-- Card Body -->
        <div class="card-body">

          <!-- Tab Content -->
          <div class="tab-content" id="pills-tabContent">

            <!-- Tab Pane -->
            <div class="tab-pane fade show active" id="solicitacao-tabPanel" role="tabpanel" aria-labelledby="pills-solicitacao-tab">

              @if (isset($data['exame']->laudo->id))

              {{
                Form::model(
                  $data['exame']->laudo,
                  array(
                    'id' => 'laudoForm',
                    'method' => 'PUT',
                    'route' => array('laudos.update', $data['exame']->laudo->id),
                    'data-resource-id' => $data['exame']->laudo->id,
                    'data-validation-errors' => trans('application.msg.error.validation-errors')
                  )
                )
              }}

              @else

              {{
                Form::open(
                  array(
                    'id' => 'laudoForm',
                    'route' => 'laudos.store',
                    'data-validation-errors' => trans('application.msg.error.validation-errors')
                  )
                )
              }}

              @endif


              {{
                Form::text('exame_id',$data['exame']->id, array('hidden'))
              }}

              <!-- Produto -->

              <div class="form-group col-12 {{ ($errors->has('produto')) ? 'has-error' : '' }}">

                {{ Form::label('produto', trans('laudos.lbl.produto')) }}

                <div class="input-group">

                  {{
                    Form::select(
                      'produto_id',
                      $data['produtos'],
                      isset($data['exame']->laudo->produto_id)?$data['exame']->laudo->produto_id:null,
                      array(
                        'class'            => ($errors->has('produto')) ? 'form-control has-error__icon' : 'form-control produto',
                        'aria-describedby' => 'produtoAddon',
                        'id'               => 'produto',
                        'onchange'         => isset($data['exame']->laudo->tipo_reagente_id)?'atualizaLaudo()':null,
                        ($pdfActive)?"disabled":''
                      )
                    )
                  }}

                  <div class="input-group-append">
                    <span id="produtoAddon" class="input-group-text rounded-right">
                      <i class="fas fa-box fa-fw"></i>
                    </span>
                  </div>

                  @if ($errors->has('produto'))
                  <div class="invalid-feedback">
                    {{ $errors->first('produto') }}
                  </div>
                  @endif

                </div>

              </div>

              <div class='row form-group'>

                <div class="col-6 {{ ($errors->has('lote')) ? 'has-error' : '' }}">

                  {{ Form::label('lote', trans('laudos.lbl.lote')) }}

                    {{
                      Form::text(
                        'lote',
                        isset($data['exame']->laudo->lote)?$data['exame']->laudo->lote:null,
                        array(
                          'class'            => ($errors->has('lote')) ? 'form-control has-error__icon' : 'form-control lote',
                          'aria-describedby' => 'loteAddon',
                          'id'               => 'lote', 'disabled'
                        )
                      )
                    }}

                </div>

              <div class="col-6 {{ ($errors->has('referencia')) ? 'has-error' : '' }}">

                {{ Form::label('validade', trans('laudos.lbl.validade')) }}

                  {{
                    Form::text(
                      'validade',
                      isset($data['exame']->laudo->validade)?$data['exame']->laudo->validade:null,
                      array(
                        'class'            => ($errors->has('validade')) ? 'form-control has-error__icon' : 'form-control data validade',
                        'aria-describedby' => 'validadeAddon',
                        'id'               => 'validade', 'disabled'
                      )
                    )
                  }}

              </div>

            </div><!-- .row -->

            <div class="form-group col-12 {{ ($errors->has('referencia')) ? 'has-error' : '' }}">

              {{ Form::label('referencia', trans('laudos.lbl.referencia')) }}

              <div class="input-group">

                {{
                  Form::select(
                    'referencia',
                    $data['tipo_referencias'],
                    isset($data['exame']->laudo->referencia)?$data['exame']->laudo->referencia:null,
                    array(
                      'class'            => ($errors->has('produto')) ? 'form-control has-error__icon' : 'form-control referencia',
                      'aria-describedby' => 'referenciaAddon',
                      'id'               => 'referencia',
                      'onchange'         => isset($data['exame']->laudo->referencia)?'atualizaLaudo()':null,
                      ($pdfActive)?"disabled":''
                    )
                  )
                }}

                <div class="input-group-append">
                  <span id="referenciaAddon" class="input-group-text rounded-right">
                    <i class="fas fa-fill fa-fw"></i>
                  </span>
                </div>

                @if ($errors->has('referencia'))
                <div class="invalid-feedback">
                  {{ $errors->first('referencia') }}
                </div>
                @endif

              </div>

            </div>

            <div class="form-group col-12 {{ ($errors->has('reagente')) ? 'has-error' : '' }}">

                {{ Form::label('reagente', trans('laudos.lbl.resultado')) }}

                <div class="input-group">

                  {{
                    Form::select(
                      'tipo_reagente_id',
                      $data['tipo_reagentes'],
                      isset($data['exame']->laudo->tipo_reagente_id)?$data['exame']->laudo->tipo_reagente_id:null,
                      array(
                        'class'            => ($errors->has('produto')) ? 'form-control has-error__icon' : 'form-control reagente',
                        'aria-describedby' => 'reagenteAddon',
                        'id'               => 'reagente',
                        'onchange'         => isset($data['exame']->laudo->tipo_reagente_id)?'atualizaLaudo()':null,
                        ($pdfActive)?"disabled":''
                      )
                    )
                  }}

                  <div class="input-group-append">
                    <span id="reagenteAddon" class="input-group-text rounded-right">
                      <i class="fas fa-fill-drip fa-fw"></i>
                    </span>
                  </div>

                  @if ($errors->has('reagente'))
                  <div class="invalid-feedback">
                    {{ $errors->first('reagente') }}
                  </div>
                  @endif

                </div>

              </div>

              <div class="form-group col-12 {{ ($errors->has('laudo')) ? 'has-error' : '' }}">

                {{ Form::label('laudo', trans('laudos.parecer')) }}

                  {{
                    Form::textarea(
                      'descricao',
                      isset($data['exame']->laudo->descricao)?$data['exame']->laudo->descricao:null,
                      array(
                        'class'            => ($errors->has('laudo')) ? 'form-control has-error__icon' : 'form-control',
                        'aria-describedby' => 'laudoAddon',
                        'rows'             => 4,
                        'id'               => 'descricao',
                        'onkeypress'       => isset($data['exame']->laudo->descricao)?'atualizaLaudo()':null,
                        ($pdfActive)?"disabled":''
                      )
                    )
                  }}

                  @if ($errors->has('laudo'))
                  <div class="invalid-feedback">
                    {{ $errors->first('laudo') }}
                  </div>
                  @endif

                </div>

                <div class="form-group col-12 {{ ($errors->has('responsavel')) ? 'has-error' : '' }}">

                  {{ Form::label('responsavel', trans('laudos.lbl.responsavel')) }}

                  <div class="input-group">

                    {{
                      Form::select(
                        'user_id',
                        $data['responsaveis'],
                        isset($data['exame']->laudo->user_id)?$data['exame']->laudo->user_id:2,
                        array(
                          'class'            => ($errors->has('responsavel')) ? 'form-control has-error__icon' : 'form-control responsavel',
                          'aria-describedby' => 'responsavelAddon',
                          'id'               => 'responsavel',
                          'onchange'         => 'atualizaLaudo()',
                          'required',
                          ($pdfActive)?"disabled":''
                        )
                      )
                    }}

                    <div class="input-group-append">
                      <span id="responsavelAddon" class="input-group-text rounded-right">
                        <i class="fas fa-user-tag fa-fw"></i>
                      </span>
                    </div>

                    @if ($errors->has('responsavel'))
                    <div class="invalid-feedback">
                      {{ $errors->first('responsavel') }}
                    </div>
                    @endif

                  </div>

                </div>

                <div class="alert alert-warning alert-dismissible alertAtualizacao" role="alert" id="alertAtualizacao" style="display:none">
                  {{ trans('laudos.alert.confirma') }} <a href="#" class="close" data-dismiss="alert" aria-label="close" style="text-decoration:none">x</a>
                </div>

              <div class="card-footer text-right">

              @if($isAdmin)

                @if($data['exame']->tipo_status_id != 3)

                    @if($data['exame']->tipo_status_id == 1)

                      {{ Form::submit(trans('application.btn.save'), array('class' => 'btn btn-primary')) }}

                    @elseif($data['exame']->tipo_status_id == 2)
                      {{
                        link_to_route(
                          'exames.export',
                          trans('application.btn.aprovar'),
                          $data['exame']->id,
                          array(
                            'id'    => 'botaoAprovar',
                            'class' => (Auth::user()->responsavel != 1)?'btn btn-info disabled': 'btn btn-info'
                          )
                        )
                      }}

                      {{ Form::submit(trans('application.btn.update'), array('class' => 'btn btn-primary')) }}

                    @endif
                @endif

                @if( $data['exame']->tipo_status_id == 3 )
                  @if( $data['exame']->laudo->pdf_ativo != 1 )

                    {{ Form::submit(trans('application.btn.update'), array('class' => 'btn btn-primary')) }}

                  @else

                    <span class='obrigatorio'><small>
                      {{ trans('laudos.txt.atualizar-pdf') }}
                    </small></span>

                  @endif
                @endif

              @endif <!-- .isAdmin -->

              {{
                link_to_route(
                  'solicitacoes.show',
                  trans('application.btn.back'),
                  $data['exame']->solicitacao->id,
                  array(
                    'class' => 'btn btn-default'
                  )
                )
              }}

              {{-- {{
                link_to_route(
                  'exames.export',
                  trans('application.btn.aprovar'),
                  $data['exame']->id,
                  array(
                    'class' => 'btn btn-info'
                  )
                )
              }} --}}

            </div>

              {{ Form::close() }}

            </div>
            <!-- /.Tab Pane -->

          </div>
          <!-- /.Tab Content -->

        </div>
        <!-- /.Card Body -->

      </div>
      <!-- /.Nav Tabs Custom -->

    </div>
    <!-- /.Col -->

  </div><!-- .row -->


  @if(!$isTrashed)

    @include('exames/_modal-delete')

  @endif

  @if($data['exame']->laudo)
    @if(!$isTrashedLaudo)

      @include('exames/_modal-delete-laudo')

    @endif

    @if($isTrashedLaudo)

      @include('exames/_modal-restore-laudo')

    @endif
  @endif

@stop

<!-- JQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>

<!-- Mudança dinâmica de dados do produto [lote] [validade] -->
<script src="{{ asset('assets/js/produto_lote_validade.js') }}"></script>

<!-- Confirmação de atualização de laudo -->
<script src="{{ asset('assets/js/confirmacaoAtualizacaoLaudo.js') }}"></script>
