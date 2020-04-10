@extends('layouts.base')
@section('titulo-pagina', 'Editar Servicio')
@section('breadcrumb')
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/subscribers') }}">Abonados</a></li>
            <li class="breadcrumb-item"><a href="{{ route('subscribers.edit', $abonado->id) }}">{{ $abonado->numero_identidad }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('services.index', ['subscriber' => $abonado->id]) }}">Servicios</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar</li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">person</i>
                        </div>
                        <h4 class="card-title">Datos del Abonado</h4>
                        <p class="card-category">Complete el formulario</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Tipo de Identificación</label>
                                    <input type="text" class="form-control" required
                                           value="{{ $abonado->tipo_identidad }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Número de Identificación</label>
                                    <input type="text" class="form-control" required
                                           value="{{ $abonado->numero_identidad }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Primer Nombre</label>
                                    <input type="text" class="form-control" required
                                           value="{{ $abonado->primer_nombre }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Segundo Nombre</label>
                                    <input type="text" class="form-control" required
                                           value="{{ $abonado->segundo_nombre }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Primer Apellido</label>
                                    <input type="text" class="form-control" required
                                           value="{{ $abonado->primer_apellido }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Segundo Apellido</label>
                                    <input type="text" class="form-control" required
                                           value="{{ $abonado->segundo_apellido }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Dirección</label>
                                    <input type="text" class="form-control"
                                           value="{{ $abonado->direccion }}" disabled>
                                </div>
                            </div>
                            <div class="col-md 6">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Teléfono</label>
                                    <input type="number" class="form-control"
                                           value="{{ $abonado->telefono }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        @if ($servicio->estado == -1) <h4 class="card-title">Activar Servicio</h4>
                        @else <h4 class="card-title">Editar Servicio</h4>@endif
                        <p class="card-category">Complete el formulario</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ action('ServiceController@update', $servicio_id) }}" method="post">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Dirección</label>
                                        <input type="text" name="direccion" value="{{ $servicio->direccion }}" class="form-control" required autofocus>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Teléfono</label>
                                        <input type="text" name="telefono" value="{{ $servicio->telefono }}" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Fecha subscripción</label>
                                        <input type="text" name="fecha_subscripcion" value="@if ($servicio->fecha_subscripcion) {{ $servicio->fecha_subscripcion->format('m/d/Y') }} @endif" class="form-control datepicker" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Fecha instalación</label>
                                        <input type="text" name="fecha_instalacion" value="@if ($servicio->fecha_instalacion) {{ $servicio->fecha_instalacion->format('m/d/Y') }} @endif" class="form-control datepicker" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="ultima_milla" class="bmd-label-static">Última milla</label>
                                        <select name="ultima_milla" id="ultima_milla" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir una tecnología">
                                            <option value="GPON" @if ($servicio->ultima_milla == 'GPON') selected @endif>GPON</option>
                                            <option value="EOC" @if ($servicio->ultima_milla == 'EOC') selected @endif>EOC</option>
                                            <option value="METRO" @if ($servicio->ultima_milla == 'METRO') selected @endif>METRO ETHERNET</option>
                                            <option value="INALAMBRICO" @if ($servicio->ultima_milla == 'INALAMBRICO') selected @endif>INALÁMBRICO</option>
                                            <option value="DOCSIS" @if ($servicio->ultima_milla == 'DOCSIS') selected @endif>DOCSIS</option>
                                            <option value="CATV" @if ($servicio->ultima_milla == 'CATV') selected @endif>CATV</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="plan" class="bmd-label-static">Plan</label>
                                        <select name="plan_id" id="plan" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir Plan">
                                            @if ($servicio->plan->solo_tv)
                                                <option selected value="{{ $servicio->plan->id }}">{{ $servicio->plan->nombre }}: $ {{ $servicio->plan->formatted_precio_tv }}</option>
                                            @else
                                                <option selected value="{{ $servicio->plan->id }}">{{ $servicio->plan->nombre }} - {{ $servicio->plan->tasa_descarga }}Mb/{{ $servicio->plan->tasa_subida }}Mb: $ {{ $servicio->plan->formatted_precio_internet }}@if ($servicio->plan->tv) - Incluye TV: $ {{ $servicio->plan->formatted_precio_tv }} @endif</option>
                                            @endif
                                            @foreach($planes as $plan)
                                                @if ($plan->solo_tv)
                                                    <option value="{{ $plan->id }}">{{ $plan->nombre }}: $ {{ $plan->formatted_precio_tv }}</option>
                                                @else
                                                    <option value="{{ $plan->id }}">{{ $plan->nombre }} - {{ $plan->tasa_descarga }}Mb/{{ $plan->tasa_subida }}Mb: $ {{ $plan->formatted_precio_internet }}@if ($plan->tv) - Incluye TV: $ {{ $plan->formatted_precio_tv }} @endif</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{--@if (Auth::user()->isSuperAdmin())
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="estado" class="bmd-label-static">Estado Usuario</label>
                                        <select name="estado" id="estado" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir Estado">
                                            @if ($servicio->estado == 1)
                                                <option selected>Activo</option>
                                                <option>Inactivo</option>
                                            @elseif ($servicio->estado == -1)
                                                <option selected>Activo</option>
                                            @else
                                                <option selected>Inactivo</option>
                                                <option>Activo</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>--}}

                            <div class="row" style="display: none" id="ont_div">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="ont_placeholder" class="bmd-label-static">ONT</label>
                                        <select id="ont_placeholder" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir ONT">
                                            @if ($ont)
                                                <optgroup label="ONT actual">
                                                    <option selected value="{{ $ont->olt->id}}/{{$ont->board }}/{{ $ont->puerto }}/{{$ont->serial}}/{{$ont->optical_info->rx_power}}/{{$ont->optical_info->tx_power}}/{{$ont->optical_info->catv_power}}">{{ $ont->olt->identificador }} | Tarjeta: {{ $ont->board }} | Puerto: {{ $ont->puerto }} | Serial: {{$ont->serial}}</option>
                                                </optgroup>
                                            @endif
                                                <optgroup label="ONTs sin activar">
                                            @foreach($onts as $ont)
                                                <option value="{{ $ont->olt->id}}/{{$ont->board }}/{{ $ont->puerto }}/{{$ont->serial}}">{{ $ont->olt->identificador }} | Tarjeta: {{ $ont->board }} | Puerto: {{ $ont->puerto }} | Serial: {{$ont->serial}}</option>
                                            @endforeach
                                                </optgroup>
                                        </select>
                                        <input type="hidden" name="ont" id="ont">
                                        <input type="hidden" name="olt" id="olt">
                                        <input type="hidden" name="olt_board" id="olt_board">
                                        <input type="hidden" name="olt_puerto" id="olt_puerto">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group bmd-form-group">
                                        <label for="rx_power" class="bmd-label-static">RX Power</label>
                                        <input type="text" id="rx_power" class="form-control" value="" disabled>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group bmd-form-group">
                                        <label for="tx_power" class="bmd-label-static">TX Power</label>
                                        <input type="text" id="tx_power" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group bmd-form-group">
                                        <label for="catv_rx_power" class="bmd-label-static">CATV RX Power</label>
                                        <input type="text" id="catv_rx_power" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>

                            @if (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="saldo" class="bmd-label-static">Saldo</label>
                                        <input type="number" id="saldo" name="saldo" class="form-control" value="{{ $servicio->saldo }}">
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if ($servicio->estado == 0)
                                <input type="hidden" name="estado" value="Inactivo">
                            @else
                                <input type="hidden" name="estado" value="Activo">
                            @endif
                            <button type="submit" class="btn btn-primary pull-right">Guardar</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    $(document).ready(function () {
        md.initFormExtendedDatetimepickers();
        if ($('.slider').length !== 0) {
            md.initSliders();
        }
        var ont = $('#ont_placeholder');
        var ultimaMilla = $('#ultima_milla');
        if (ultimaMilla.val() === 'GPON') {
            $('#ont_div').show("slow");
            if (ont.val()) {
                var selected = ont.val();
                var split = selected.split('/');
                var olt = split[0];
                var board = split[1];
                var puerto = split[2];
                var serial = split[3];
                $('#olt_board').val(board);
                $('#olt_puerto').val(puerto);
                $('#ont').val(serial);
                $('#olt').val(olt);
                if (split.length > 4) {
                    var rx_power = split[4];
                    var tx_power = split[5];
                    var catv_power = split[6];
                    $('#tx_power').val(tx_power);
                    $('#rx_power').val(rx_power);
                    $('#catv_rx_power').val(catv_power);
                } else {
                    $('#tx_power').val("");
                    $('#rx_power').val("");
                    $('#catv_rx_power').val("");
                }

            }
        }
        ultimaMilla.change(function () {
            if (ultimaMilla.val() === 'GPON') {
                $('#ont_div').show("slow");
            } else {
                $('#ont_div').hide("slow");
            }
        });
        ont.change(function () {
            var selected = ont.val();
            var split = selected.split('/');
            var olt = split[0];
            var board = split[1];
            var puerto = split[2];
            var serial = split[3];
            $('#olt_board').val(board);
            $('#olt_puerto').val(puerto);
            $('#ont').val(serial);
            $('#olt').val(olt);
            if (split.length > 4) {
                var rx_power = split[4];
                var tx_power = split[5];
                var catv_power = split[6];
                $('#tx_power').val(tx_power);
                $('#rx_power').val(rx_power);
                $('#catv_rx_power').val(catv_power);
            } else {
                $('#tx_power').val("");
                $('#rx_power').val("");
                $('#catv_rx_power').val("");
            }
        });
    });
</script>
@endsection
