@if ($elements->count())

  @define $isAdmin = Auth::user()->hasRole('ADMIN')

  @define $C_sort  = Input::get('C_sort')

  @define $C_group = Input::get('C_group')

  <div class="text-center text-secondary border-top py-3">
    {{
      trans('pagination.table.caption', [
        'total' => $elements->getTotal(),
        'currentPage' => $elements->getCurrentPage(),
        'lastPage' => $elements->getLastPage(),
        'perPage' => $elements->getPerPage()
      ])
    }}
  </div>

  <div class="table-responsive">

    <table class="table table-hover table-sm table-collapse datatable">

      <caption class="text-center border-top">
        {{
          trans('pagination.table.caption', [
            'total' => $elements->getTotal(),
            'currentPage' => $elements->getCurrentPage(),
            'lastPage' => $elements->getLastPage(),
            'perPage' => $elements->getPerPage()
          ])
        }}
      </caption>

      <thead>

        <tr>

          <!-- BEGIN - Show only when is not grouping -->

          @if (!$C_group)

            <!-- DATATABLE - table > th - Collapse All  -->
            @include('templates/parts/datatable/_datatable__collapse--all')

            @include('templates/parts/datatable/_datatable__ordering', [
              'classes' => 'w-auto',
              'sort'    => 'created_at',
              'order'   => $C_sort && !$C_group ? 'ASC' : 'DESC',
              'label'   => trans('exames.exame'),
              'icon'    => $C_sort && !$C_group ? 'fa-sort text-muted' : 'fa-sort-down'
            ])

            @include('templates/parts/datatable/_datatable__ordering', [
              'classes' => 'w-auto',
              'sort'    => 'created_at',
              'order'   => $C_sort && !$C_group ? 'ASC' : 'DESC',
              'label'   => trans('solicitacoes.solicitacao'),
              'icon'    => $C_sort && !$C_group ? 'fa-sort text-muted' : 'fa-sort-down'
            ])

            @include('templates/parts/datatable/_datatable__ordering', [
              'classes' => 'w-auto',
              'sort'    => 'created_at',
              'order'   => $C_sort && !$C_group ? 'ASC' : 'DESC',
              'label'   => trans('pacientes.paciente'),
              'icon'    => $C_sort && !$C_group ? 'fa-sort text-muted' : 'fa-sort-down'
            ])

            @include('templates/parts/datatable/_datatable__ordering', [
              'classes' => 'w-auto',
              'sort'    => 'created_at',
              'order'   => $C_sort && !$C_group ? 'ASC' : 'DESC',
              'label'   => trans('pacientes.lbl.sus'),
              'icon'    => $C_sort && !$C_group ? 'fa-sort text-muted' : 'fa-sort-down'
            ])


          @endif

          <!-- END - Show only when is not grouping -->

          <!-- BEGIN - Show only when is not grouping OR when is the specific group -->

          @if (!$C_group || $C_group === 'status')

            @include('templates/parts/datatable/_datatable__ordering', [
              'classes' => !$C_group ? 'd-none d-sm-table-cell col-status' : '',
              'sort'    => 'status',
              'label'   => trans('application.lbl.status'),
              'group'   => 'status'
            ])

          @endif

          <!-- END - Show only when is not grouping OR when is the specific group -->

          <!-- BEGIN - Show whenever is grouping -->

          @if ($C_group)

            <!-- DATATABLE - table > th - Total  -->
            @include('templates/parts/datatable/_datatable__total--th')

          @endif

          <!-- END - Show whenever is grouping -->

          <!-- BEGIN - Show only when is not grouping -->

          @if (!$C_group)

            <th class="col-options-3">

              <!-- DATATABLE - Options - List  -->
              @include('templates/parts/datatable/_datatable__options--list', array(
                'show_tools'   => true,
                'show_print'   => false,
                'show_export'  => false,
                'is_groupable' => true,
                'groupables'   => [
                  [
                    'group' => 'status',
                    'label' => trans('application.lbl.status')
                  ]
                ]
              ))

            </th>

          @endif

          <!-- END - Show only when is not grouping -->

        </tr>

      </thead>

      <tbody>

        @foreach ($elements as $exame)

          @define $isTrashed = $exame->trashed()

          <tr class="{{ ($isTrashed) ? 'table-danger' : '' }}">

            <!-- BEGIN - Show only when is not grouping -->

            @if (!$C_group)

              <!-- DATATABLE - table > td - Collapse One  -->
              @include('templates/parts/datatable/_datatable__collapse--one', [
                'collapse_id' => "collapseUnidade_$exame->id"
              ])

              <td class="align-middle w-auto">
                <span class="ellipsis">{{ isset($exame->tipoExame->tipo)?$exame->tipoExame->tipo:null }}</span>
              </td>

              <td class="align-middle w-auto">
                <span class="ellipsis">{{ $exame->solicitacao->numero }}</span>
              </td>

              <td class="align-middle w-auto">
                <span class="ellipsis">{{ isset($exame->solicitacao->paciente->nome)?$exame->solicitacao->paciente->nome:'Não informado' }}</span>
              </td>

              <td class="align-middle w-auto">
                <span class="ellipsis">{{ isset($exame->solicitacao->paciente->sus)?$exame->solicitacao->paciente->sus:'Não informado' }}</span>
              </td>

            @endif

            <!-- END - Show only when is not grouping -->

            <!-- BEGIN - Show only when is not grouping OR when is the specific group -->

            @if (!$C_group || $C_group === 'status')

              <!-- DATATABLE - table > td - Status  -->
              @include('templates/parts/datatable/_datatable__status--td', [
                'is_grouped' => $C_group,
                'is_trashed' => $isTrashed
              ])

            @endif

            <!-- END - Show only when is not grouping OR when is the specific group -->

            <!-- BEGIN - Show whenever is grouping -->

            @if ($C_group)

              <!-- DATATABLE - table > td - Total  -->
              @include('templates/parts/datatable/_datatable__total--td', [ 'model' => $exame ])

            @endif

            <!-- END - Show whenever is grouping -->

            <!-- BEGIN - Show only when is not grouping -->

            @if (!$C_group)

              <td class="align-middle col-options-3">

                @include('templates/parts/datatable/_datatable__options--buttons-exames', [
                  'is_trashed'      => $isTrashed,
                  'has_permission'  => $isAdmin,
                  'modal_id'        => $exame->id,
                  'route_edit'      => route('solicitacoes.edit', [ $exame->solicitacao_id ]),
                  'route_show'      => route('solicitacoes.show', [ $exame->solicitacao_id ]),
                  'route_laudo'     => route('exames.laudo', [ $exame->id ]),
                  'is_printable'    => true,
                  'route_print_one' => route('laudos.download-pdf', [ $exame->laudo->id ]),
                ])

              </td>

            @endif

            <!-- END - Show only when is not grouping -->

          </tr>

          <!-- BEGIN - Show only when is not grouping -->

          @if (!$C_group)

          <tr>

            <td class="description">

              <div class="collapse" id="collapseUnidade_{{ $exame->id }}">

                <div class="pt-3 px-3 pb-0">

                  <div class="row">

                    <div class="col-12">

                      <blockquote class="blockquote d-block">
                        <p class="mb-0">
                          <i class="fas fa-notes-medical fa-fw mr-1"></i> {{ trans('solicitacoes.solicitacao') }}
                        </p>
                        <footer class="blockquote-footer">
                          {{ $exame->solicitacao->numero }}
                        </footer>
                      </blockquote>

                      <blockquote class="blockquote d-block">
                        <p class="mb-0">
                          <i class="fas fa-hospital fa-fw mr-1"></i> {{ trans('solicitacoes.lbl.unidade') }}
                        </p>
                        <footer class="blockquote-footer">
                          {{ $exame->solicitacao->unidade->nome }}
                        </footer>
                      </blockquote>

                      <blockquote class="blockquote d-block">
                        <p class="mb-0">
                          <i class="fas fa-calendar-alt fa-fw mr-1"></i> {{ trans('solicitacoes.lbl.data-coleta') }}
                        </p>
                        <footer class="blockquote-footer">
                          {{ $exame->solicitacao->data_coleta }}
                        </footer>
                      </blockquote>

                      <blockquote class="blockquote d-block d-sm-none">
                        <p class="mb-0">
                          <i class="fas fa-signal fa-fw mr-1"></i> {{ trans('application.lbl.status') }}
                        </p>
                        <footer class="blockquote-footer">
                          <span class="badge {{ ($isTrashed) ? 'badge-danger' : 'badge-success' }} badge-pill text-uppercase">
                            {{ ($isTrashed) ? trans('application.lbl.inactive') : trans('application.lbl.active') }}
                          </span>
                        </footer>
                      </blockquote>

                      <blockquote class="blockquote d-block">
                        <p class="mb-0">
                          <i class="fas fa-calendar-alt fa-fw mr-1"></i> {{ trans('application.lbl.created-at') }}
                        </p>
                        <footer class="blockquote-footer">
                          {{ FormatterHelper::dateTimeToPtBR($exame->created_at) }}
                        </footer>
                      </blockquote>

                      @if(strtotime($exame->updated_at) > 0)
                      <blockquote class="blockquote d-block">
                        <p class="mb-0">
                          <i class="fas fa-calendar-alt fa-fw mr-1"></i> {{ trans('application.lbl.updated-at') }}
                        </p>
                        <footer class="blockquote-footer">
                          {{ FormatterHelper::dateTimeToPtBR($exame->updated_at) }}
                        </footer>
                      </blockquote>
                      @endif

                      @if(strtotime($exame->deleted_at) > 0)
                      <blockquote class="blockquote d-block">
                        <p class="mb-0">
                          <i class="fas fa-calendar-alt fa-fw mr-1"></i> {{ trans('application.lbl.deleted-at') }}
                        </p>
                        <footer class="blockquote-footer text-danger">
                          {{ FormatterHelper::dateTimeToPtBR($exame->deleted_at) }}
                        </footer>
                      </blockquote>
                      @endif

                    </div>

                  </div>

                </div>

              </div>

            </td>

          </tr>

          @endif

          <!-- END - Show only when is not grouping -->

        @endforeach

      </tbody>

    </table>

  </div>

  {{ $elements->links() }}

  @if ($isAdmin)

    @foreach ($elements as $exame)

      @define $isTrashed = $exame->trashed()

      @if(!$isTrashed)

        {{-- @include('exames/_modal-delete') --}}

      @endif

    @endforeach

  @endif

@else

  <div class="alert alert-warning mb-0">{{ trans('application.msg.warn.no-records-found') }}</div>

@endif
