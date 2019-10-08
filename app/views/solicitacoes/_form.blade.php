@if (isset($data['solicitacao']->id))

{{
  Form::model(
    $data['solicitacao'],
    array(
      'id' => 'solicitacaoForm',
      'method' => 'PUT',
      'route' => array('solicitacoes.update', $data['solicitacao']->id),
      'data-resource-id' => $data['solicitacao']->id,
      'data-validation-errors' => trans('application.msg.error.validation-errors')
    )
  )
}}

@else

{{
  Form::open(
    array(
      'id' => 'solicitacaoForm',
      'route' => 'solicitacoes.store',
      'data-validation-errors' => trans('application.msg.error.validation-errors')
    )
  )
}}

@endif

  <div class="{{ $is_parent ? 'card' : '' }}">

    @if ($is_parent)
    <div class="card-header">
      <h3 class="card-title">
        @if (isset($solicitacao->id))
          {{ trim(trans('application.action.edit', ['icon' => '<i class="fas fa-edit"></i>'])) }}
        @else
          {{ trim(trans('application.action.create', ['icon' => '<i class="fas fa-save"></i>'])) }}
        @endif
      </h3>
    </div>
    @endif

    <div class="{{ $is_parent ? 'card-body' : '' }}">

      <div class="alert alert-warning alert-dismissible alertSolicitacao" role="alert" id="alertSolicitacao" style="display:none">
        {{ trans('solicitacoes.alert.num') }} <a href="#" class="close" data-dismiss="alert" aria-label="close" style="text-decoration:none">x</a>
      </div>

      @if($resultado)
        <div class="alert alert-info alert-dismissible alertEditar" role="alert" id="alertEditar">
          {{ trans('solicitacoes.alert.editar') }} <a href="#" class="close" data-dismiss="alert" aria-label="close" style="text-decoration:none">x</a>
        </div>
      @endif

      <div class='card'>

        <div class='card-body'>

          <h5 class='card-title'>{{ trans('solicitacoes.lbl.dados') }}</h5>


          <div class='row'>
            <!-- Número de cadastro anterior -->
            <div class="form-group col-4 {{ ($errors->has('tipo')) ? 'has-error' : '' }} {{ $is_parent ? '' : 'mb-0' }}">

              {{ Form::label('numero_anterior', trans('solicitacoes.lbl.numero_anterior')) }}

              <div class="input-group">

                <?php
                  $num_anterior=0;
                  if(isset($data['anterior']->numero)){
                    if($data['anterior']->numero != null){
                      $num_anterior = $data['anterior']->numero;
                    }
                  }
                ?>

                {{
                  Form::text(
                    'numero_anterior',
                    $num_anterior,
                    array(
                      'class'            => 'form-control numero_anterior',
                      'aria-describedby' => 'numero_anteriorAddon',
                      'disabled'
                    )
                  )
                }}

                <div class="input-group-append">
                  <span id="numero_anteriorAddon" class="input-group-text rounded-right">
                    <i class="fas fa-arrow-left fa-fw"></i>
                  </span>
                </div>

                @if ($errors->has('numero_anterior'))
                <div class="invalid-feedback">
                  {{ $errors->first('numero_anterior') }}
                </div>
                @endif

              </div>

            </div><!-- Número de cadastro anterior -->

            <!-- Número de cadastro -->
            <div class="form-group col-8 {{ ($errors->has('numeroSolicitacao')) ? 'has-error' : '' }} {{ $is_parent ? '' : 'mb-0' }}">

              {{ Form::label('numeroSolicitacao', trans('solicitacoes.lbl.numero')) }}<span class="obrigatorio">*</span>

              <div class="input-group">

                {{
                  Form::text(
                    "num_solicitacao",
                    isset($data['solicitacao']->numero)?$data['solicitacao']->numero: ($num_anterior+1),
                    array(
                      'class'            => ($errors->has('numero')) ? 'form-control has-error__icon' : 'form-control numero',
                      'placeholder'      => trans('solicitacoes.plh.numero'),
                      'aria-describedby' => 'numeroSolicitacaoAddon',
                      'id'               => 'numeroSolicitacao',
                      'required', ($resultado)?'disabled':'',
                    )
                  )
                }}

                <div class="input-group-append">
                  <span id="numeroSolicitacaoAddon" class="input-group-text rounded-right">
                    <i class="fas fa-arrow-right fa-fw"></i>
                  </span>
                </div>

                @if ($errors->has('numeroSolicitacao'))
                <div class="invalid-feedback">
                  {{ $errors->first('numeroSolicitacao') }}
                </div>
                @endif

              </div>

            </div><!-- .Número de cadastro -->

          </div><!-- .row -->


          <div class='row'>
            <!-- Data coleta -->
            <div class="form-group col-4 {{ ($errors->has('data_coleta')) ? 'has-error' : '' }} {{ $is_parent ? '' : 'mb-0' }}">

              {{ Form::label('data_coleta', trans('solicitacoes.lbl.data-coleta')) }}<span class="obrigatorio">*</span>

              <div class="input-group">

                {{
                  Form::text(
                    'data_coleta',
                    isset($data['solicitacao']->data_coleta)?$data['solicitacao']->data_coleta:null,
                    array(
                      'class'            => ($errors->has('data_coleta')) ? 'form-control has-error__icon' : 'form-control data data_coleta',
                      'aria-describedby' => 'data_coletaAddon',
                      'placeholder'      => trans('pacientes.plh.data'),
                      'required', ($resultado)?'disabled':''
                    )
                  )
                }}

                <div class="input-group-append">
                  <span id="data-coletaAddon" class="input-group-text rounded-right">
                    <i class="fas fa-calendar-day fa-fw"></i>
                  </span>
                </div>

                @if ($errors->has('data-coleta'))
                <div class="invalid-feedback">
                  {{ $errors->first('data-coleta') }}
                </div>
                @endif

              </div>

            </div><!-- Data coleta -->

            <!-- Médico -->
            <div class="form-group col-8 {{ ($errors->has('tipo')) ? 'has-error' : '' }} {{ $is_parent ? '' : 'mb-0' }}">

              {{ Form::label('medico', trans('solicitacoes.lbl.medico')) }}<span class="obrigatorio">*</span>

              <div class="input-group">

                {{
                  Form::text(
                    "medico",
                    isset($data['solicitacao']->medico->nome)?$data['solicitacao']->medico->nome:null,
                    array(
                      'class'            => ($errors->has('medico')) ? 'form-control has-error__icon' : 'form-control nome',
                      'placeholder'      => trans('solicitacoes.plh.nome'),
                      'aria-describedby' => 'medicoAddon',
                      'required', ($resultado)?'disabled':''
                    )
                  )
                }}

                <div class="input-group-append">
                  <span id="medicoAddon" class="input-group-text rounded-right">
                    <i class="fas fa-stethoscope fa-fw"></i>
                  </span>
                </div>

                @if ($errors->has('medico'))
                <div class="invalid-feedback">
                  {{ $errors->first('medico') }}
                </div>
                @endif

              </div>

            </div><!-- .Médico -->

          </div><!-- .row -->

          <!-- Unidades -->
          <div class="form-group {{ ($errors->has('tipo')) ? 'has-error' : '' }} {{ $is_parent ? '' : 'mb-0' }}">

            {{ Form::label('unidades', trans('solicitacoes.lbl.unidade')) }}<span class="obrigatorio">*</span>

            <div class="input-group">

              {{
                Form::select(
                  'unidade_id',
                  $data['unidades'],
                  isset($data['solicitacao']->unidade_id)?$data['solicitacao']->unidade_id:null,
                  array(
                    'class'            => ($errors->has('unidade')) ? 'form-control has-error__icon' : 'form-control',
                    'placeholder'      => trans('solicitacoes.lbl.nome'),
                    'aria-describedby' => 'unidadeAddon',
                    'required', ($resultado)?'disabled':''
                  )
                )
              }}

              <div class="input-group-append">
                <span id="unidadeAddon" class="input-group-text rounded-right">
                  <i class="fas fa-hospital fa-fw"></i>
                </span>
              </div>

              @if ($errors->has('unidade'))
              <div class="invalid-feedback">
                {{ $errors->first('unidade') }}
              </div>
              @endif

            </div>

          </div><!-- .Unidades -->

      </div><!-- .card-body dados -->

    </div><!-- .card dados -->

      <div class='card'>

        <div class='card-body'>

          <h5 class='card-title'>{{ trans('pacientes.paciente') }}</h5>

          <div class="alert alert-info alert-dismissible alertPaciente" role="alert" id="alertPaciente" style="display:none">
            {{ trans('solicitacoes.alert.paciente') }} <a href="#" class="close" data-dismiss="alert" aria-label="close" style="text-decoration:none">x</a>
          </div>

          <div class='row'>
            <!-- Cartao SUS busca -->
            <div class="form-group col-12 {{ ($errors->has('sus')) ? 'has-error' : '' }} {{ $is_parent ? '' : 'mb-0' }}">

              {{ Form::label('sus', trans('pacientes.lbl.sus')) }}<span class="obrigatorio">*</span>

              <div class="input-group">

                {{
                  Form::text(
                    'sus',
                    isset($data['solicitacao']->paciente->sus)?$data['solicitacao']->paciente->sus:null,
                    array(
                      'id'               => 'sus',
                      'class'            => ($errors->has('sus')) ? 'form-control has-error__icon' : 'form-control sus',
                      'placeholder'      => trans('pacientes.plh.sus'),
                      'aria-describedby' => 'susAddon',
                      'required',
                      ($resultado)?'disabled':''
                    )
                  )
                }}

                <button type='button' id='busca_sus' onclick='buscarPaciente_sus()' class='col-2 btn btn-info btn-sm'>
                  {{ trans('application.btn.sus') }}
                </button>

                <div class="input-group-append">
                  <span id="susAddon" class="input-group-text rounded-right">
                    <i class="fas fa-id-card fa-fw"></i>
                  </span>
                </div>

                @if ($errors->has('sus'))
                <div class="invalid-feedback">
                  {{ $errors->first('sus') }}
                </div>
                @endif

              </div>

            </div><!-- Cartao SUS busca -->

          </div><!-- .row -->

          <div class='row'>

            <!-- Paciente nome -->
            <div class="form-group col-8 {{ ($errors->has('nome')) ? 'has-error' : '' }} {{ $is_parent ? '' : 'mb-0' }}">

              {{ Form::label('nome', trans('pacientes.lbl.nome')) }}<span class="obrigatorio">*</span>

              <div class="input-group">

                {{
                  Form::text(
                    'nome',
                    isset($data['solicitacao']->paciente->nome)?$data['solicitacao']->paciente->nome:null,
                    array(
                      'class'            => ($errors->has('nome')) ? 'form-control has-error__icon' : 'form-control nomePaciente nome',
                      'placeholder'      => trans('pacientes.lbl.nome'),
                      'id'               => 'nome',
                      'aria-describedby' => 'pacienteAddon',
                      'onchange'         => 'comparaSus()',
                      'required',
                      ($resultado)?'disabled':''
                    )
                  )
                }}

                <div class="input-group-append">
                  <span id="pacienteAddon" class="input-group-text rounded-right">
                    <i class="fas fa-user fa-fw"></i>
                  </span>
                </div>

                @if ($errors->has('nome'))
                <div class="invalid-feedback">
                  {{ $errors->first('nome') }}
                </div>
                @endif

              </div>

            </div><!-- .Paciente nome -->

            <!-- Paciente sexo -->
            <div class="form-group col-4 {{ ($errors->has('sexo')) ? 'has-error' : '' }} {{ $is_parent ? '' : 'mb-0' }}">

              {{ Form::label('sexo', trans('pacientes.lbl.sexo')) }}<span class="obrigatorio">*</span>

              <div class="input-group">

                {{
                  Form::select(
                    'tipo_sexo_id',
                    $data['tipo_sexos'],
                    isset($data['solicitacao']->paciente->tipo_sexo_id)?$data['solicitacao']->paciente->tipo_sexo_id:null,
                    array(
                      'class'            => ($errors->has('sexo')) ? 'form-control has-error__icon' : 'form-control tipo_sexo_id',
                      'placeholder'      => trans('pacientes.lbl.sexo'),
                      'aria-describedby' => 'sexoAddon',
                      'id'               => 'sexo',
                      'required',
                      ($resultado)?'disabled':''
                    )
                  )
                }}

                <div class="input-group-append">
                  <span id="sexoAddon" class="input-group-text rounded-right">
                    <i class="fas fa-venus-mars fa-fw"></i>
                  </span>
                </div>

                @if ($errors->has('sexo'))
                <div class="invalid-feedback">
                  {{ $errors->first('sexo') }}
                </div>
                @endif

              </div>

            </div><!-- .Paciente sexo -->

          </div><!-- .row -->

          <div class='row'>

            <!-- Paciente nome da mãe -->
            <div class="form-group col-8 {{ ($errors->has('nome_mae')) ? 'has-error' : '' }} {{ $is_parent ? '' : 'mb-0' }}">

              {{ Form::label('nome_mae', trans('pacientes.lbl.nome-mae')) }}

              <div class="input-group">

                {{
                  Form::text(
                    'nome_mae',
                    isset($data['solicitacao']->paciente->nome_mae)?$data['solicitacao']->paciente->nome_mae:null,
                    array(
                      'class'            => ($errors->has('nome_mae')) ? 'form-control has-error__icon' : 'form-control nome',
                      'placeholder'      => trans('pacientes.lbl.nome-mae'),
                      'aria-describedby' => 'nome_maeAddon',
                      ($resultado)?'disabled':''
                    )
                  )
                }}

                <div class="input-group-append">
                  <span id="pacienteAddon" class="input-group-text rounded-right">
                    <i class="fas fa-female fa-fw"></i>
                  </span>
                </div>

                @if ($errors->has('nome_mae'))
                <div class="invalid-feedback">
                  {{ $errors->first('nome_mae') }}
                </div>
                @endif

              </div>

            </div><!-- .Paciente nome da mãe -->

            <!-- Data de nascimento -->
            <div class="form-group col-4 {{ ($errors->has('data_nascimento')) ? 'has-error' : '' }} {{ $is_parent ? '' : 'mb-0' }}">

              {{ Form::label('data_nascimento', trans('pacientes.lbl.data')) }}<span class="obrigatorio">*</span>

              <div class="input-group">

                {{
                  Form::text(
                    'data_nascimento',
                    isset($data['solicitacao']->paciente->data_nascimento)?$data['solicitacao']->paciente->data_nascimento:null,
                    array(
                      'class'            => ($errors->has('data_nascimento')) ? 'form-control has-error__icon' : 'form-control data data_nascimento',
                      'placeholder'      => trans('pacientes.plh.data'),
                      'aria-describedby' => 'data_nascimentoAddon',
                      'onchange'         => 'comparaSus()',
                      'required',
                      ($resultado)?'disabled':''
                    )
                  )
                }}

                <div class="input-group-append">
                  <span id="data_nascimentoAddon" class="input-group-text rounded-right">
                    <i class="fas fa-birthday-cake fa-fw"></i>
                  </span>
                </div>

                @if ($errors->has('data_nascimento'))
                <div class="invalid-feedback">
                  {{ $errors->first('data_nascimento') }}
                </div>
                @endif

              </div>

            </div><!-- .Paciente data de nascimento -->

          </div><!-- .row -->

          <!-- Paciente contatos -->

          <div class='row'>

            <!-- Paciente contato 1 -->
            <div class="form-group col-6 {{ ($errors->has('contato1')) ? 'has-error' : '' }} {{ $is_parent ? '' : 'mb-0' }}">

              {{ Form::label('contato1', trans('pacientes.lbl.contato.1')) }}<span class="obrigatorio">*</span>

              <div class="input-group">

                {{
                  Form::text(
                    'contato1',
                    isset($data['solicitacao']->paciente->telefones[0])?$data['solicitacao']->paciente->telefones[0]->numero:null,
                    array(
                      'class'            => ($errors->has('contato1')) ? 'form-control has-error__icon' : 'form-control telefones',
                      'maxlength'        => '9',
                      'placeholder'      => trans('pacientes.plh.telefone'),
                      'aria-describedby' => 'contato1Addon',
                      'required',
                      ($resultado)?'disabled':''
                    )
                  )
                }}

                <div class="input-group-append">
                  <span id="contato1Addon" class="input-group-text rounded-right">
                    <i class="fas fa-phone fa-fw"></i>
                  </span>
                </div>

                @if ($errors->has('contato1'))
                <div class="invalid-feedback">
                  {{ $errors->first('contato1') }}
                </div>
                @endif

              </div>

            </div><!-- .Pacinete contato 1 -->

            <!-- Paciente contato 2 -->
            <div class="form-group col-6 {{ ($errors->has('contato2')) ? 'has-error' : '' }} {{ $is_parent ? '' : 'mb-0' }}">

              {{ Form::label('contato2', trans('pacientes.lbl.contato.2')) }}

              <div class="input-group">

                {{
                  Form::text(
                    'contato2',
                    isset($data['solicitacao']->paciente->telefones[1])?$data['solicitacao']->paciente->telefones[1]->numero:null,
                    array(
                      'class'            => ($errors->has('contato2')) ? 'form-control has-error__icon' : 'form-control telefones',
                      'placeholder'      => trans('pacientes.plh.telefone'),
                      'aria-describedby' => 'contato2Addon', ($resultado)?'disabled':''
                    )
                  )
                }}

                <div class="input-group-append">
                  <span id="contato2Addon" class="input-group-text rounded-right">
                    <i class="fas fa-mobile-alt fa-fw"></i>
                  </span>
                </div>

                @if ($errors->has('contato2'))
                <div class="invalid-feedback">
                  {{ $errors->first('contato2') }}
                </div>
                @endif

              </div>

            </div><!-- .Paciente contato 2 -->

          </div><!-- .row -->

          <!-- Paciente Endereço -->

          <div class='row'>

            <!-- Paciente cep -->
            <div class="form-group col-6 {{ ($errors->has('cep')) ? 'has-error' : '' }} {{ $is_parent ? '' : 'mb-0' }}">

              {{ Form::label('cep', trans('pacientes.lbl.cep')) }}

              <div class="input-group">

                {{
                  Form::text(
                    'cep',
                    isset($data['solicitacao']->paciente->endereco->cep)?$data['solicitacao']->paciente->endereco->cep:null,
                    array(
                      'class'            => ($errors->has('cep')) ? 'form-control has-error__icon' : 'form-control cep',
                      'maxlength'        => '9',
                      'onblur'           => 'pesquisacep(this.value);',
                      'placeholder'      => trans('pacientes.plh.cep'),
                      'aria-describedby' => 'cepAddon',
                      'id'               => 'cep',
                      ($resultado)?'disabled':''
                    )
                  )
                }}

                <div class="input-group-append">
                  <span id="cepAddon" class="input-group-text rounded-right">
                    <i class="fas fa-map-marker-alt fa-fw"></i>
                  </span>
                </div>

                @if ($errors->has('cep'))
                <div class="invalid-feedback">
                  {{ $errors->first('cep') }}
                </div>
                @endif

              </div>

            </div><!-- .Endereço cep -->

            <!-- Paciente cep -->
            <div class="form-group col-6 {{ ($errors->has('bairro')) ? 'has-error' : '' }} {{ $is_parent ? '' : 'mb-0' }}">

              {{ Form::label('bairro', trans('pacientes.lbl.bairro')) }}

              <div class="input-group">

                {{
                  Form::text(
                    'bairro',
                    isset($data['solicitacao']->paciente->endereco->bairro)?$data['solicitacao']->paciente->endereco->bairro:null,
                    array(
                      'class'            => ($errors->has('bairro')) ? 'form-control has-error__icon' : 'form-control bairro',
                      'placeholder'      => trans('pacientes.lbl.bairro'),
                      'aria-describedby' => 'bairroAddon',
                      'id'               => 'bairro',
                      ($resultado)?'disabled':''
                    )
                  )
                }}

                <div class="input-group-append">
                  <span id="bairroAddon" class="input-group-text rounded-right">
                    <i class="fas fa-city fa-fw"></i>
                  </span>
                </div>

                @if ($errors->has('bairro'))
                <div class="invalid-feedback">
                  {{ $errors->first('bairro') }}
                </div>
                @endif

              </div>

            </div><!-- .Endereço bairro -->

          </div><!-- .row -->

          <div class='row'>

            <!-- Endereço estado -->
            <div class="form-group col-6 {{ ($errors->has('estado')) ? 'has-error' : '' }} {{ $is_parent ? '' : 'mb-0' }}">

              {{ Form::label('estado', trans('pacientes.lbl.estado')) }}

              <div class="input-group">

                {{
                  Form::select(
                    'estado_uf',
                    $data['estados'],
                    isset($data['solicitacao']->paciente->endereco->estado_uf)? $data['solicitacao']->paciente->endereco->estado_uf : 'SP',
                    array(
                      'class'            => ($errors->has('estado')) ? 'form-control has-error__icon' : 'form-control estado',
                      'placeholder'      => trans('pacientes.plh.estado'),
                      'aria-describedby' => 'estadoAddon',
                      'id'               => 'estado',
                      ($resultado)?'disabled':''
                    )
                  )
                }}

                <div class="input-group-append">
                  <span id="estadoAddon" class="input-group-text rounded-right">
                    <i class="fas fa-globe-americas fa-fw"></i>
                  </span>
                </div>

                @if ($errors->has('estado'))
                <div class="invalid-feedback">
                  {{ $errors->first('estado') }}
                </div>
                @endif

              </div>

            </div><!-- .Endereço estado -->

            <!-- Endereço cidade -->
            <div class="form-group col-6 {{ ($errors->has('cidade')) ? 'has-error' : '' }} {{ $is_parent ? '' : 'mb-0' }}">

              {{ Form::label('cidade', trans('pacientes.lbl.cidade')) }}<span class="obrigatorio">*</span>

              <div class="input-group">

                {{
                  Form::select(
                    'cidade_id',
                    $data['cidades'],
                    isset($data['solicitacao']->paciente->endereco->cidade_id) ? $data['solicitacao']->paciente->endereco->cidade_id : 3388,
                    array(
                      'class'            => ($errors->has('cidade')) ? 'form-control has-error__icon' : 'form-control cidade',
                      'placeholder'      => trans('pacientes.lbl.cidade'),
                      'aria-describedby' => 'cidadeAddon',
                      'id'               => 'cidade',
                      ($resultado)?'disabled':''
                    )
                  )
                }}

                <div class="input-group-append">
                  <span id="cidadeAddon" class="input-group-text rounded-right">
                    <i class="fas fa-map-signs fa-fw"></i>
                  </span>
                </div>

                @if ($errors->has('cidade'))
                <div class="invalid-feedback">
                  {{ $errors->first('cidade') }}
                </div>
                @endif

              </div>

            </div><!-- .Endereço cidade -->

          </div><!-- .row -->

          <div class='row'>

            <!-- Paciente logradouro -->
            <div class="form-group col-8 {{ ($errors->has('logradouro')) ? 'has-error' : '' }} {{ $is_parent ? '' : 'mb-0' }}">

              {{ Form::label('logradouro', trans('pacientes.lbl.logradouro')) }}<span class="obrigatorio">*</span>

              <div class="input-group">

                {{
                  Form::text(
                    'logradouro',
                    isset($data['solicitacao']->paciente->endereco->logradouro)?$data['solicitacao']->paciente->endereco->logradouro:null,
                    array(
                      'class'            => ($errors->has('logradouro')) ? 'form-control has-error__icon' : 'form-control',
                      'placeholder'      => trans('pacientes.plh.logradouro'),
                      'aria-describedby' => 'logradouroAddon',
                      'id'               => 'logradouro',
                      'required',
                      ($resultado)?'disabled':''
                    )
                  )
                }}

                <div class="input-group-append">
                  <span id="logradouroAddon" class="input-group-text rounded-right">
                    <i class="fas fa-road fa-fw"></i>
                  </span>
                </div>

                @if ($errors->has('logradouro'))
                <div class="invalid-feedback">
                  {{ $errors->first('logradouro') }}
                </div>
                @endif

              </div>

            </div><!-- .Endereço logradouro -->

            <!-- Endereço número -->
            <div class="form-group col-4 {{ ($errors->has('numero')) ? 'has-error' : '' }} {{ $is_parent ? '' : 'mb-0' }}">

              {{ Form::label('numero', trans('pacientes.lbl.numero')) }}<span class="obrigatorio">*</span>

              <div class="input-group">

                {{
                  Form::text(
                    'numero',
                    isset($data['solicitacao']->paciente->endereco->numero)?$data['solicitacao']->paciente->endereco->numero:null,
                    array(
                      'class'            => ($errors->has('numero')) ? 'form-control has-error__icon' : 'form-control',
                      'placeholder'      => trans('pacientes.plh.numero'),
                      'aria-describedby' => 'numeroAddon',
                      'id'               => 'numero',
                      'required',
                      ($resultado)?'disabled':''
                    )
                  )
                }}

                <div class="input-group-append">
                  <span id="numeroAddon" class="input-group-text rounded-right">
                    <i class="fas fa-home fa-fw"></i>
                  </span>
                </div>

                @if ($errors->has('numero'))
                <div class="invalid-feedback">
                  {{ $errors->first('numero') }}
                </div>
                @endif

              </div>

            </div><!-- .Endereço número -->

          </div><!-- .row -->

        </div><!-- .card-body paciente -->

      </div><!-- .card paciente -->

      <div class='card'><!-- Exames -->

        <div class='card-body'>

          <h5 class='card-title'>{{ trans('exames.exames') }}</h5>


          <div class="form-group form-row {{ ($errors->has('exame_predefinido')) ? 'has-error' : '' }} {{ $is_parent ? '' : 'mb-0' }}">

              <div class='mr-3'>{{ trans('exames.lbl.predefinido') }}</div>

               @foreach( $data['tipo_exames_predefinidos'] as $key => $exame )

                 <span class="glyphicon glyphicon-ok">

                   <label class="btn btn-info">

                     <div>{{ $exame->tipo }}</div>

                     {{
                       Form::checkbox(
                         'exame_predefinido',
                         1,
                         isset($user->responsavel) ? 'checked' : null,
                         array(
                           'id'            => 'exame_predefinido',
                           'class'         => 'exame_predefinido_'.$key,
                           'autocomplete'  => "off",
                           'onclick'       => 'examePredefinido(this)'
                         )
                       )
                     }}

                 </label>

                </span>

               @endforeach

           </div><!-- .form-group -->


        @foreach( $data['tipo_exames'] as $key => $exame )

           <?php
            $verdadeDesafio = 0 ;
            $amostra = 1;
            if( isset($data['exames']) ){
              foreach($data['exames'] as $key2 => $value2){
                if( $value2->tipo_exame_id == $exame->id ){
                  $verdadeDesafio = 1;
                  $amostra = $value2->tipo_amostra_id;
                }
              }
            }
          ?>

         <div class='row'>

           <!-- Exames -->
           <div class="form-group col-12 {{ ($errors->has('tipo_exame_id')) ? 'has-error' : '' }} {{ $is_parent ? '' : 'mb-0' }}">

             <div class="input-group col-12">
              <div class="input-group-prepend col-5">

                <label>
                  {{ Form::checkbox('tipo_exame_id[]',
                                  $exame->id,
                                  $verdadeDesafio,
                                  array(
                                    'style' => 'margin-right:30px;margin-left:100px',
                                    'id'    => 'exame',
                                    'class' =>  'exame',
                                    'onclick' => 'mostraAmostra(this)',
                                    ($resultado)?'disabled':''
                                  ))
                  }}

                  {{ $exame->tipo }}

                </label>

               </div>

               <div class="input-group-append">
                 <span id="pacienteAddon" class="input-group-text rounded-left">
                   <i class="fas fa-vial fa-fw"></i>
                 </span>
               </div>

                {{ Form::select(
                    'amostra[]',
                    $data['tipo_amostras'],
                    $amostra,
                    array(
                      'class' => 'amostra amostra_'.$exame->id,
                      'style' => 'display:none',
                      'id'    => 'amostra'
                    )
                  )
                }}

              </div><!-- .input-group -->

            </div><!-- .form-group -->

          </div><!-- .Row -->

        @endforeach

      </div><!-- .card-body exames -->

    </div><!-- .card exames -->


    {{
      Form::text(
        'susHidden',
        Input::old('sus'),
        array(
          'class' => 'form-control sus',
          'id'    => 'susHidden',
          'hidden'
        )
      )
    }}
    {{
      Form::text(
        'nomeHidden',
        Input::old('nome'),
        array(
          'class' => 'form-control nomeHidden',
          'id'    => 'nomeHidden',
          'hidden'
        )
      )
    }}
    {{
      Form::text(
        'data_nascimentoHidden',
        Input::old('data_nascimento'),
        array(
          'class' => 'form-control data data_nascimentoHidden',
          'id'    => 'data_nascimentoHidden',
          'hidden'
        )
      )
    }}

    @include('solicitacoes/_modal-form')

  </div><!-- .card-body -->


    @if ($is_parent)
      <div class="card-footer text-right">

        @if (isset($data['solicitacao']->id))
          @if(!$resultado)

            {{ Form::submit(trans('application.btn.update'), array('class' => 'btn btn-primary')) }}

          @endif

          {{
            link_to_route(
              'solicitacoes.show',
              trans('application.btn.cancel'),
              $data['solicitacao']->id,
              array(
                'class' => 'btn btn-default'
              )
            )
          }}

        @else
          @if(!$resultado)

            {{-- {{ Form::submit(trans('application.btn.save'), array('class' => 'btn btn-primary','onclick' => "confirma()")) }} --}}

            <a
              class="dropdown-item"
              href="#modalForm"
              data-toggle="modal">
              <i class="fas fa-save fa-fw text-primary"></i><label>{{ trans('application.btn.continue') }}</label>
            </a>

          @endif

        @endif
      @endif

        {{-- {{
          link_to_route(
            'solicitacoes.index',
            trans('application.btn.back'),
            null,
            array(
              'class' => 'btn btn-default'
            )
          )
        }} --}}

      </div>

{{ Form::close() }}
