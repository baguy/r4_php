@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('solicitacoes.page.title.show') }}
@stop

@section('MAIN')

  @define $isAdmin   = Auth::user()->hasRole('LAB')

  @define $isTrashed = $solicitacao->trashed()

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
                {{ trans('solicitacoes.solicitacao') }}</a>
            </li>

            <!-- SHOW - Options - Buttons  -->
            @include('templates/parts/_show__options-buttons', [
              'has_min_permission' => Auth::user()->hasRole('LAB'),
              'has_max_permission' => $isAdmin,
              'is_trashed'         => $isTrashed,
              'modal_id'           => $solicitacao->id,
              'route_edit'         => route('solicitacoes.edit', [ $solicitacao->id ]),
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
                  <i class="fas fa-notes-medical fa-fw mr-1"></i> {{ trans('solicitacoes.lbl.numero') }}
                </p>
                <footer class="blockquote-footer">
                  {{ $solicitacao->numero }}
                </footer>
              </blackquote>

              <!-- Dados do Paciente -->
              <blockquote class="blockquote d-block">
                <p class="mb-0">
                  <i class="fas fa-diagnoses fa-fw mr-1"></i> {{ trans('pacientes.paciente') }}
                </p>
                <footer class="blockquote-footer">
                  {{ $solicitacao->paciente->nome }}
                </footer>
                <footer class="blockquote-footer">
                  <b>{{ trans('pacientes.lbl.sus') }}</b> {{ isset($solicitacao->paciente->sus)?$solicitacao->paciente->sus:'Não informado' }}
                </footer>
                <footer class="blockquote-footer">
                  <b>{{ trans('pacientes.lbl.sexo') }}</b> {{ strtolower($solicitacao->paciente->sexo->tipo) }}
                </footer>
                <footer class="blockquote-footer">
                  <b>{{ trans('pacientes.lbl.data') }}</b> {{ isset($solicitacao->paciente->data_nascimento)?$solicitacao->paciente->data_nascimento:'Não informado' }}
                </footer>
                <footer class="blockquote-footer">
                  <b>{{ trans('pacientes.lbl.nome-mae') }}</b> {{ isset($solicitacao->paciente->nome_mae)?$solicitacao->paciente->nome_mae:'Não informado' }}
                </footer>
                <footer class="blockquote-footer">
                  <b>{{ trans('pacientes.lbl.contato.1') }}</b> {{ isset($solicitacao->paciente->telefones[0])?$solicitacao->paciente->telefones[0]->numero:'Não informado' }}
                </footer>
                @if(isset($solicitacao->paciente->telefones[1]))
                  <footer class="blockquote-footer">
                    <b>{{ trans('pacientes.lbl.contato.2') }}</b> {{ $solicitacao->paciente->telefones[1]->numero }}
                  </footer>
                @endif
                <footer class="blockquote-footer">
                  <b>{{ trans('pacientes.lbl.endereco') }}</b> {{ $solicitacao->paciente->endereco->logradouro }}, {{ $solicitacao->paciente->endereco->numero }}<br>
                  {{ isset($solicitacao->paciente->endereco->cep)? $solicitacao->paciente->endereco->cep:null }} {{ $solicitacao->paciente->endereco->bairro }} —
                  {{ $solicitacao->paciente->endereco->cidade->nome }} / {{ $solicitacao->paciente->endereco->estado_uf }}
                </footer>

              </blockquote>

              <!-- Médico -->
              <blockquote class="blockquote d-block">
                <p class="mb-0">
                  <i class="fas fa-stethoscope fa-fw mr-1"></i> {{ trans('solicitacoes.lbl.medico') }}
                </p>
                <footer class="blockquote-footer">
                  {{ $solicitacao->medico->nome }}
                </footer>
              </blockquote>

              <!-- Unidade -->
              <blockquote class="blockquote d-block">
                <p class="mb-0">
                  <i class="fas fa-hospital fa-fw mr-1"></i> {{ trans('solicitacoes.lbl.unidade') }}
                </p>
                <footer class="blockquote-footer">
                  {{ $solicitacao->unidade->nome }}
                </footer>
              </blockquote>

              <!-- Dados da solicitação -->
              <blockquote class="blockquote d-block">
                <p class="mb-0">
                  <i class="fas fa-toggle-on fa-fw mr-1"></i> {{ trans('application.lbl.status') }}
                </p>
                <footer class="blockquote-footer">
                  <span class="badge {{ ($isTrashed) ? 'badge-danger' : 'badge-success' }} badge-pill text-uppercase">
                    {{ ($isTrashed) ? trans('application.lbl.inactive') : trans('application.lbl.active') }}
                  </span>
                </footer>
              </blockquote>

              <blockquote class="blockquote d-block">
                <p class="mb-0">
                  <i class="fas fa-calendar-alt fa-fw mr-1"></i> {{ trans('solicitacoes.lbl.data-coleta') }}
                </p>
                <footer class="blockquote-footer">
                  {{ $solicitacao->data_coleta }}
                </footer>
              </blockquote>

              <blockquote class="blockquote d-block">
                <p class="mb-0">
                  <i class="fas fa-calendar-alt fa-fw mr-1"></i> {{ trans('application.lbl.created-at') }}
                </p>
                <footer class="blockquote-footer">
                  {{ FormatterHelper::dateTimeToPtBR($solicitacao->created_at) }}
                </footer>
              </blockquote>

              @if(strtotime($solicitacao->updated_at) > 0)

                <blockquote class="blockquote d-block">
                  <p class="mb-0">
                    <i class="fas fa-calendar-alt fa-fw mr-1"></i> {{ trans('application.lbl.updated-at') }}
                  </p>
                  <footer class="blockquote-footer">
                    {{ FormatterHelper::dateTimeToPtBR($solicitacao->updated_at) }}
                  </footer>
                </blockquote>

              @endif

              @if(strtotime($solicitacao->deleted_at) > 0)

                <blockquote class="blockquote d-block">
                  <p class="mb-0">
                    <i class="fas fa-calendar-alt fa-fw mr-1"></i> {{ trans('application.lbl.deleted-at') }}
                  </p>
                  <footer class="blockquote-footer">
                    {{ FormatterHelper::dateTimeToPtBR($solicitacao->deleted_at) }}
                  </footer>
                </blockquote>

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
                {{ trans('exames.exames') }}</a>
            </li>

            <li>
               {{
                 link_to_route(
                   'solicitacoes.print-all',
                   trans('application.lbl.print-all'),
                   $solicitacao->id,
                   array(
                     'id'    => 'printAll',
                     'class' => 'btn btn-secondary float-right mr-1'
                   )
                 )
               }}
            </li>

          </ul>

        </div>

        <!-- Card Body -->
        <div class="card-body">

          <!-- Tab Content -->
          <div class="tab-content" id="pills-tabContent">

            <!-- Tab Pane -->
            <div class="tab-pane fade show active" id="solicitacao-tabPanel" role="tabpanel" aria-labelledby="pills-solicitacao-tab">

              <!-- Dados do Paciente -->
              <blockquote class="blockquote d-block">
                <p class="mb-0">
                  <i class="fas fa-flask fa-fw mr-1"></i> {{ trans('exames.exame') }}
                </p>
              </blockquote>

              @foreach ($exames as $exame)

                <blockquote class="blockquote d-block">
                  <footer class="blockquote-footer">
                    {{ $exame->tipoExame->tipo }}
                  </footer>

                  <p class="mb-0">
                    <i class="fas fa-toggle-on fa-fw mr-1"></i> {{ trans('application.lbl.status') }}
                  </p>
                    @if($exame->tipo_status_id != 3)

                      <footer class="blockquote-footer">
                        <span class="badge {{ ($exame->tipo_status_id == 1) ? 'badge-warning' : 'badge-dark' }} badge-pill">
                          <i class="fas fa-clock"></i>
                          {{ ($exame->tipo_status_id == 1) ? trans('exames.status.1') : trans('exames.status.2') }}
                        </span><br>
                      </footer>

                    @else
                      <footer class="blockquote-footer">
                        <span class="badge badge-success badge-pill">
                          <i class="fas fa-pen-fancy"></i>
                          {{ trans('exames.status.3') }}
                        </span><br>
                      </footer>

                        @if(!$exame->trashed())
                          {{-- {{
                            link_to_route(
                              'laudos.print-pdf',
                              trans('application.btn.print'),
                              $exame->laudo->id,
                              array(
                                'class' => 'btn btn-secondary btn-sm'
                              )
                            )
                          }} --}}

                          {{
                            link_to_route(
                              'laudos.download-pdf',
                              trans('application.btn.download'),
                              $exame->laudo->id,
                              array(
                                'class' => 'btn btn-secondary btn-sm'
                              )
                            )
                          }}
                      @endif

                    @endif


                      <footer class="blockquote-footer">

                        @if($exame->trashed())

                          <span class="badge badge-danger badge-pill text-uppercase">
                            {{ trans('application.lbl.deleted') }}
                          </span><br>

                          @if($isAdmin)
                            <a
                              class="dropdown-item"
                              href="#modalRestoreExame_{{ $exame->id }}"
                              data-toggle="modal">
                              <i class="fas fa-recycle fa-fw text-warning"></i> {{ trans('application.btn.restore-exame') }}
                            </a>
                          @endif

                        @else

                          <span class="badge badge-success badge-pill text-uppercase">
                            {{ trans('application.lbl.active') }}
                          </span><br>

                          @if($isAdmin)
                            <a
                              class="dropdown-item"
                              href="#modalDeleteExame_{{ $exame->id }}"
                              data-toggle="modal">
                              <i class="fas fa-trash-alt fa-fw text-danger"></i>{{ trans('application.btn.delete-exame') }}
                            </a>
                          </p>
                          @endif

                        @endif

                      </footer>


                  @if($isAdmin)
                    <footer class="blockquote-footer">
                      @if(!$exame->trashed())
                          {{
                            link_to_route(
                              'exames.laudo',
                              ($exame->tipo_status_id != 1) ? trans('application.btn.laudo-cadastrado') : trans('application.btn.laudo'),
                              $exame->id,
                              array(
                                'class' => 'btn btn-info btn-sm',
                              )
                            )
                          }}
                      @else
                        <i class="fas fa-ban"></i> {{ trans('application.btn.laudo') }}
                      @endif
                    </footer>
                  @endif

                </blockquote>

                <blockquote class="blockquote d-block">
                  <p class="mb-0">
                    <i class="fas fa-calendar-alt fa-fw mr-1"></i> {{ trans('application.lbl.created-at') }}
                  </p>
                  <footer class="blockquote-footer">
                    {{ FormatterHelper::dateTimeToPtBR($solicitacao->created_at) }}
                  </footer>
                </blockquote>

                <hr>

                @if($isAdmin)

                  @if(!$exame->trashed())

                    @include('solicitacoes/_modal-delete-exame')

                  @endif

                  @if($exame->trashed())

                    @include('solicitacoes/_modal-restore-exame')

                  @endif

                @endif

              @endforeach

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



  @if($isAdmin)

    @if(!$isTrashed)

      @include('solicitacoes/_modal-delete')

    @endif

    @if($isTrashed)

      @include('solicitacoes/_modal-restore')

    @endif

  @endif

@stop
