@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('unidades.page.title.show') }}
@stop

@section('MAIN')

  @define $isAdmin   = Auth::user()->hasRole('ADMIN')

  @define $isTrashed = $unidade->trashed()

  <div class="row">

    <div class="col-12">

      <!-- Nav Tabs Custom -->
      <div class="card">

        <div class="card-header p-2">

          <ul class="nav nav-pills" id="pills-tab" role="tablist">

            <li class="nav-item mr-2">
              <a
                id="unidade-tab"
                class="nav-link active"
                href="#unidade-tabPanel"
                data-toggle="pill" role="tab" aria-controls="unidade" aria-selected="true">
                {{ trans('unidades.unidade') }}</a>
            </li>

            <!-- SHOW - Options - Buttons  -->
            @include('templates/parts/_show__options-buttons', [
              'has_min_permission' => Auth::user()->hasRole('WORKER'),
              'has_max_permission' => $isAdmin,
              'is_trashed'         => $isTrashed,
              'modal_id'           => $unidade->id,
              'route_edit'         => route('unidades.edit', [ $unidade->id ]),
              'is_printable'       => false
            ])

          </ul>

        </div>

        <!-- Card Body -->
        <div class="card-body">

          <!-- Tab Content -->
          <div class="tab-content" id="pills-tabContent">

            <!-- Tab Pane -->
            <div class="tab-pane fade show active" id="unidade-tabPanel" role="tabpanel" aria-labelledby="pills-unidade-tab">

              <blockquote class="blockquote d-block">
                <p class="mb-0">
                  <i class="fas fa-font fa-fw mr-1"></i> {{ trans('unidades.lbl.nome') }}
                </p>
                <footer class="blockquote-footer">
                  {{ $unidade->nome }}
                </footer>
              </blockquote>

              <blockquote class="blockquote d-block">
                <p class="mb-0">
                  <i class="fas fa-at fa-fw mr-1"></i> {{ trans('unidades.lbl.email') }}
                </p>
                <footer class="blockquote-footer">
                  {{ $unidade->email }}
                </footer>
              </blockquote>

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
                  <i class="fas fa-calendar-alt fa-fw mr-1"></i> {{ trans('application.lbl.created-at') }}
                </p>
                <footer class="blockquote-footer">
                  {{ FormatterHelper::dateTimeToPtBR($unidade->created_at) }}
                </footer>
              </blockquote>

              @if(strtotime($unidade->updated_at) > 0)

                <blockquote class="blockquote d-block">
                  <p class="mb-0">
                    <i class="fas fa-calendar-alt fa-fw mr-1"></i> {{ trans('application.lbl.updated-at') }}
                  </p>
                  <footer class="blockquote-footer">
                    {{ FormatterHelper::dateTimeToPtBR($unidade->updated_at) }}
                  </footer>
                </blockquote>

              @endif

              @if(strtotime($unidade->deleted_at) > 0)

                <blockquote class="blockquote d-block">
                  <p class="mb-0">
                    <i class="fas fa-calendar-alt fa-fw mr-1"></i> {{ trans('application.lbl.deleted-at') }}
                  </p>
                  <footer class="blockquote-footer">
                    {{ FormatterHelper::dateTimeToPtBR($unidade->deleted_at) }}
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

  </div>

  @if($isAdmin)

    @if(!$isTrashed)

      @include('unidades/_modal-delete')

    @endif

    @if($isTrashed)

      @include('unidades/_modal-restore')

    @endif

  @endif

@stop
