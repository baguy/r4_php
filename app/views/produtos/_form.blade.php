@if (isset($produto->id))

{{
  Form::model(
    $produto,
    array(
      'id' => 'produtoForm',
      'method' => 'PUT',
      'route' => array('produtos.update', $produto->id),
      'data-resource-id' => $produto->id,
      'data-validation-errors' => trans('application.msg.error.validation-errors')
    )
  )
}}

@else

{{
  Form::open(
    array(
      'id' => 'produtoForm',
      'route' => 'produtos.store',
      'data-validation-errors' => trans('application.msg.error.validation-errors')
    )
  )
}}

@endif

  <div id="itens" class="card">
    <div class="card-header">
      <h3 class="card-title">
        @if (isset($produto->id))
          {{ trim(trans('application.action.edit', ['icon' => '<i class="fas fa-edit"></i>'])) }}
        @else
          {{ trim(trans('application.action.create', ['icon' => '<i class="fas fa-save"></i>'])) }}
        @endif
      </h3>
    </div>
    <div class="card-body">

      <div class="form-group {{ ($errors->has('nome')) ? 'has-error' : '' }}">

        {{ Form::label('nome', trans('produtos.lbl.nome')) }}

        <div class="input-group">

          {{
            Form::text(
              'nome',
              isset($produto->nome)?$produto->nome:null,
              array(
                'class'            => ($errors->has('nome')) ? 'form-control has-error__icon' : 'form-control',
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

      <div class='row'>

        <div class="form-group col-6 {{ ($errors->has('lote')) ? 'has-error' : '' }}">

          {{ Form::label('lote', trans('produtos.lbl.lote')) }}

          <div class="input-group">

            {{
              Form::text(
                'lote',
                isset($produto->lote)?$produto->lote:null,
                array(
                  'class' => 'form-control',
                )
              )
            }}

            <div class="input-group-append">
              <span id="nomeAddon" class="input-group-text rounded-right">
                <i class="fas fa-tag fa-fw"></i>
              </span>
            </div>

            @if ($errors->has('lote'))
            <div class="invalid-feedback">
              {{ $errors->first('lote') }}
            </div>
            @endif

          </div>

        </div>

        <div class="form-group col-6 {{ ($errors->has('validade')) ? 'has-error' : '' }}">

          {{ Form::label('validade', trans('produtos.lbl.validade')) }}

          <div class="input-group">

            {{
              Form::text(
                'validade',
                isset($produto->validade)?$produto->validade:null,
                array(
                  'class' => 'form-control data',
                  'placeholder' => trans('solicitacoes.plh.data')
                )
              )
            }}

            <div class="input-group-append">
              <span id="nomeAddon" class="input-group-text rounded-right">
                <i class="fas fa-calendar-times fa-fw"></i>
              </span>
            </div>

            @if ($errors->has('validade'))
            <div class="invalid-feedback">
              {{ $errors->first('validade') }}
            </div>
            @endif

          </div>

        </div>

      </div><!-- .row -->

    </div><!-- .card-body -->

    <div class="card-footer text-right">
      @if (isset($produto->id))

        {{
          link_to_route(
            'produtos.show',
            trans('application.btn.cancel'),
            $produto->id,
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

  </div>

{{ Form::close() }}

<!-- Modal - Add new category -->

{{-- @include('itens/_modal-add', [
  'modal_id'    => 'addCategoryModal',
  'modal_label' => 'addCategoryModalLabel',
  'title'       => trans('categorias.categoria'),
  'resource'    => 'categorias'
]) --}}

<!-- Modal - Add new subcategory -->

{{-- @include('itens/_modal-add', [
  'modal_id'    => 'addSubcategoryModal',
  'modal_label' => 'addSubcategoryModalLabel',
  'title'       => trans('subcategorias.subcategoria'),
  'resource'    => 'subcategorias'
]) --}}

<!-- Modal - Add new unit -->

{{-- @include('itens/_modal-add', [
  'modal_id'    => 'addUnitModal',
  'modal_label' => 'addUnitModalLabel',
  'title'       => trans('unidades.unidade'),
  'resource'    => 'unidades'
]) --}}
