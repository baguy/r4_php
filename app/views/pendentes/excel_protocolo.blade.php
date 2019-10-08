@extends('templates.protocolo')

@section('MAIN')

@define $contadorVetor = count($ve)
@define $i = 0

@if(count($ve) > 0)

  <table class="table-report">
    <thead>
      <tr>
        <th colspan="8" style="height: 30%">{{ trans('application.btn.excel_protocolo') }}</th>
      </tr>
    </thead>
  </table>

  <table class="table-report">
    <thead>
      <tr>
        <th style="height: 30%">{{ trans('exames.lbl.kit') }}</th>
      </tr>
    </thead>
  </table>

  <table class="table-report">
    <thead>
      <tr>
        <th style="height: 30%">{{ trans('exames.lbl.data') }}</th>
      </tr>
    </thead>
  </table>

  <table class="table-report">
    <thead>
      <tr style='background-color:#bfbfbf;'>
        <th>LET</th>
        @define $contador = 1;
        @while($contador < 13)
          <th style="width: 15%; height: 60%">{{ $contador }}</th>
          @define $contador += 1;
        @endwhile
      </tr>
    </thead>

    <tbody>

      @define $contadorAlfa = 1;
      @define $alfabeto = 'A';
      @define $contadorL = 1;
      @while($contadorAlfa < 9)

        <tr>
          <td class="borda" style='background-color:#bfbfbf;'>
            {{ $alfabeto++ }}
          </td>

          @while($contadorL < 13)

            @if($i <= $contadorVetor)

              @if($i == 0)

                <td class="borda" style="width: 15%; height: 60%">
                  CP
                </td>

              @elseif($i == 1)

                <td class="borda" style="width: 15%; height: 60%; wrap-text: true">
                  @define $v = current($ve)
                  {{ $v->solicitacao->numero }} <br /> {{ $v->tipoExame->abreviacao }}
                </td>

              @else

                <td class="borda" style="width: 15%; height: 60%; wrap-text: true">
                  @define $v = next($ve)
                  {{ $v->solicitacao->numero }} <br /> {{ $v->tipoExame->abreviacao }}
                </td>

              @endif

              @define $i += 1

            @else
              <td class="borda" style="width: 15%; height: 60%">
              </td>
            @endif

            @define $contadorL += 1;
          @endwhile

        </tr>

        @define $contadorAlfa += 1
        @define $contadorL = 1;

      @endwhile

    </tbody>
  </table>

@else

  <table class="table-report">
    <tbody>
      <tr>
        <td>{{ trans('application.msg.warn.no-records-found') }}</td>
      </tr>
    </tbody>
  </table>

@endif

<footer class='fixed'>

  <div>

    <div>
      @define $exames = []
      @foreach($ve as $key => $value)
        <?php
        $exames[$key] = $value->tipoExame->tipo
        ?>
      @endforeach
      <?php
      $result = array_unique($exames);
      ?>
      <table class="table-report">
        <thead>
          <tr>
            <th colspan="8" style="height: 30%;"> {{ trans('exames.exame.s') }}:
              @foreach($result as $key => $value) — {{ $value }} @endforeach
            </th>
          </tr>
        </thead>
      </table>

    </div>

  </div>

</footer>

@stop
