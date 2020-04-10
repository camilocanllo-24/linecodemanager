@extends('layouts.base')
@section('titulo-pagina', 'Crear Ticket')
@section('breadcrumb')
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/subscribers') }}">Abonados</a></li>
            <li class="breadcrumb-item"><a
                    href="{{ route('subscribers.edit', $abonado->id) }}">{{ $abonado->numero_identidad }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tickets.index') }}">Tickets</a></li>
            <li class="breadcrumb-item active" aria-current="page">Crear</li>
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
            Datos del Ticket
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">tv</i>
                        </div>
                        <h4 class="card-title">Datos del Servicio</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Dirección</label>
                                    <input type="text" value="{{ $servicio->direccion }}"
                                           class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Teléfono</label>
                                    <input type="text" value="{{ $servicio->telefono }}"
                                           class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Fecha subscripción</label>
                                    <input type="text" value="@if (isset($servicio->fecha_subscripcion)) {{ $servicio->fecha_subscripcion->format('d/m/Y') }} @endif"
                                           class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Fecha instalación</label>
                                    <input type="text" value="@if (isset($servicio->fecha_instalacion)) {{ $servicio->fecha_instalacion->format('d/m/Y') }} @endif"
                                           class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Última milla</label>
                                    <input class="form-control" type="text" value="{{ $servicio->ultima_milla }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Plan</label>
                                    <input type="text" class="form-control" disabled value="{{ $servicio->plan->nombre }} - {{ $servicio->plan->tasa_descarga }}Mb/{{ $servicio->plan->tasa_subida }}Mb: $ {{ $servicio->plan->formatted_precio_internet }}@if ($servicio->plan->tv)-Incluye TV:$ {{ $servicio->plan->formatted_precio_tv }} @endif">
                                </div>
                            </div>
                        </div>
                        @if ($servicio->ultima_milla === "GPON" && $ont)
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">ONT</label>
                                        <input type="text" class="form-control" disabled value="{{ $ont->olt->identificador }} | Tarjeta: {{ $ont->board_olt }} | Puerto: {{ $ont->puerto_olt }} | Serial: {{$ont->serial}}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group bmd-form-group">
                                        <label for="rx_power" class="bmd-label-static">RX Power</label>
                                        <input type="text" class="form-control" value="{{ $optical_info->rx_power }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group bmd-form-group">
                                        <label for="tx_power" class="bmd-label-static">TX Power</label>
                                        <input type="text" class="form-control" disabled value="{{ $optical_info->tx_power }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group bmd-form-group">
                                        <label for="catv_rx_power" class="bmd-label-static">CATV RX Power</label>
                                        <input type="text" class="form-control" disabled value="{{ $optical_info->catv_power }}">
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>


            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Datos del material utilizado</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('tickets.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="service" value="{{ $servicio->id }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-static">Tipo de Ticket</label>
                                        <select name="tipo" id="tipo" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir una opción">
                                            <option value="AVERIA">AVERÍA</option>
                                            <option value="DESCONEXION">DESCONEXIÓN</option>
                                            <option value="RECONEXION">RECONEXIÓN</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Motivo</label>
                                        <input type="text" name="motivo" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Descripción</label>
                                        <textarea class="form-control" name="descripcion" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Fecha estimada de inicio</label>
                                        <input type="text" name="fecha_estimada_inicio" class="form-control datetimepicker" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Fecha estimada de fin</label>
                                        <input type="text" name="fecha_estimada_cierre" class="form-control datetimepicker" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-static">Autor</label>
                                        <select name="autor_placeholder" class="form-control selectpicker" data-style="btn btn-link" disabled>
                                            <option selected>{{ Auth::user()->nombres }}</option>
                                        </select>
                                        <input type="hidden" name="usuario_autor_id" value="{{ Auth::user()->id }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-static">Asignar a</label>
                                        <select name="usuario_asignado_id" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir un usuario">
                                            <option value="SIN DEFINIR">SIN DEFINIR</option>
                                            @foreach($usuarios as $usuario)
                                                <option value="{{$usuario->id}}">{{ $usuario->nombres }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-static">Prioridad</label>
                                        <select name="prioridad" id="prioridad" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir una opción">
                                            <option value="ALTA">ALTA</option>
                                            <option value="MEDIA">MEDIA</option>
                                            <option value="BAJA">BAJA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-static">Estado del Ticket</label>
                                        <select name="estado" id="estado" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir una opción">
                                            <option value="ASIGNADO">ASIGNADO</option>
                                            <option value="EN CURSO">EN CURSO</option>
                                            <option value="PENDIENTE">PENDIENTE</option>
{{--                                            <option value="RESUELTO">RESUELTO</option>--}}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary pull-right">Crear Ticket</button>
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
        md.initFormExtendedDatetimepickers();
    </script>
@endsection
