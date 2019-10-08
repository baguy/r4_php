@if( Auth::user()->hasRole('LAB') )

  @if(isset($checkbox))
    @if($checkbox)
      @if( Auth::user()->hasRole('GERENTE') )

        <label class="btn btn-default mt-2">
          {{
            Form::checkbox(
              'selecionar[]',
              $exame->id,
              Input::old(),
              array(
                'id'            => 'selecionar',
                'name'          => 'selecionar',
                'class'         => 'selecionar'
              )
            )
          }}
        </label>

      @endif
    @endif
  @endif

  <a
    href="{{ $route_laudo }}"
    class="btn btn-secondary {{ ($is_trashed) ? 'disabled' : '' }}"
    data-tooltip="tooltip" data-placement="top" title="{{ trans('exames.laudo') }}">
    <i class="fas fa-signature fa-fw"></i>
  </a>

@endif

<a
  href="{{ $route_show }}"
  class="btn btn-default"
  data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.show') }}">
  <i class="fas fa-search fa-fw"></i>
</a>

@if($is_printable)
  @if(Auth::user()->hasRole('UNIDADE'))

    <a
      href="{{ $route_print_one }}"
      class="btn btn-dark"
      data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.download') }}">
      <i class="fas fa-download fa-fw"></i>
    </a>

  @endif
@endif
