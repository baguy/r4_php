@if (isset($unidade->id))

{{
  Form::model(
    $unidade,
    array(
      'id' => 'unidadeForm',
      'method' => 'PUT',
      'route' => array('unidades.update', $unidade->id),
      'data-resource-id' => $unidade->id,
      'data-validation-errors' => trans('application.msg.error.validation-errors')
    )
  )
}}

@else

{{
  Form::open(
    array(
      'id' => 'unidadeForm',
      'route' => 'unidades.store',
      'data-validation-errors' => trans('application.msg.error.validation-errors')
    )
  )
}}

@endif

  <div class="{{ $is_parent ? 'card' : '' }}">

    @if ($is_parent)
    <div class="card-header">
      <h3 class="card-title">
        @if (isset($unidade->id))
          {{ trim(trans('application.action.edit', ['icon' => '<i class="fas fa-edit"></i>'])) }}
        @else
          {{ trim(trans('application.action.create', ['icon' => '<i class="fas fa-save"></i>'])) }}
        @endif
      </h3>
    </div>
    @endif

    <div class="{{ $is_parent ? 'card-body' : '' }}">

      <div class="form-group {{ ($errors->has('nome')) ? 'has-error' : '' }} {{ $is_parent ? '' : 'mb-0' }}">

        {{ Form::label('nome', trans('unidades.lbl.nome')) }}

        <div class="input-group">

          {{
            Form::text(
              'nome',
              isset($unidade->nome)?$unidade->nome:null,
              array(
                'class'            => ($errors->has('unidade')) ? 'form-control has-error__icon' : 'form-control',
                'placeholder'      => trans('unidades.lbl.nome'),
                'aria-describedby' => 'nomeAddon'
              )
            )
          }}

          <div class="input-group-append">
            <span id="nomeAddon" class="input-group-text rounded-right">
              <i class="fas fa-font fa-fw"></i>
            </span>
          </div>

          @if ($errors->has('nome'))
          <div class="invalid-feedback">
            {{ $errors->first('nome') }}
          </div>
          @endif

        </div>

      </div>

      <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }} {{ $is_parent ? '' : 'mb-0' }}">

        {{ Form::label('email', trans('unidades.lbl.email')) }}

        <div class="input-group">

          {{
            Form::text(
              'email',
              isset($unidade->email)?$unidade->email:null,
              array(
                'class'            => ($errors->has('email')) ? 'form-control has-error__icon' : 'form-control',
                'placeholder'      => trans('unidades.plh.email'),
                'aria-describedby' => 'emailHelp',
                'aria-describedby' => 'emailAddon'
              )
            )
          }}

          <div class="input-group-append">
            <span id="emailAddon" class="input-group-text rounded-right">
              <i class="fas fa-at fa-fw"></i>
            </span>
          </div>

          @if ($errors->has('email'))
          <div class="invalid-feedback">
            {{ $errors->first('email') }}
          </div>
          @endif

        </div>

        <small id="emailHelp" class="form-text text-muted">
          {{ trans('application.misc.institutional-email') }} - <code class="text-info"
          data-tooltip="tooltip"
          data-placement="bottom"
          data-container="small"
          title="{{ trans('application.misc.click-to-copy') }}" style="cursor: pointer;">
            {{'@'}}{{ trans('application.config.site-domain') }}
          </code>
        </small>

      </div>

    </div>

    @if ($is_parent)
    <div class="card-footer text-right">
      @if (isset($unidade->id))

        {{
          link_to_route(
            'unidades.show',
            trans('application.btn.cancel'),
            $unidade->id,
            array(
              'class' => 'btn btn-default'
            )
          )
        }}

        {{ Form::submit(trans('application.btn.update'), array('class' => 'btn btn-primary')) }}

      @else

        {{ Form::submit(trans('application.btn.save'), array('class' => 'btn btn-primary')) }}

      @endif
    </div>
    @endif

  </div>

{{ Form::close() }}
