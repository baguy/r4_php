{{-- {{
  Form::open(
    array(
      'id' => 'assinaturaForm',
      'route' => 'users.upload-assinatura',
      'data-validation-errors' => trans('application.msg.error.validation-errors')
    )
  )
}} --}}

  <div class="card">
    <div class="card-header">
      <h3 class="card-title">

        {{ trim(trans('application.action.create', ['icon' => '<i class="fas fa-save"></i>'])) }}

      </h3>
    </div>
    <div class="card-body">

      @if (
        Auth::user()->hasRole('ADMIN')
      )

        <div class="container">
    			<div class="content">

            {{ Form::label('upload', trans('users.txt.assinatura')) }}
    				{{ Form::label('upload', trans('application.lbl.upload')) }}

    				<form action="{{ URL::to('uploads') }}" method="post" enctype="multipart/form-data">

                 {{ Form::file(
                   'file',
                   array(
                     'type'=>'file', 'name'=>'file', 'id'=>'file'
                   )
                 ) }}

    				    <input type="submit" value="Upload" name="submit">
    					<input type="hidden" value="{{ csrf_token() }}" name="_token">
              
    				</form>

    			</div>
    		</div>

      @endif

    </div><!-- .card-body -->

  </div>
