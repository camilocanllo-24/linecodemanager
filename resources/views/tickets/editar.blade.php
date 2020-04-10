@extends('layouts.base')
@section('titulo-pagina', 'Editar Ticket')
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
                                    <input type="text" value="{{ $servicio->fecha_subscripcion }}"
                                           class="form-control datepicker" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Fecha instalación</label>
                                    <input type="text" value="{{ $servicio->fecha_instalacion }}"
                                           class="form-control datepicker" disabled>
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
                        <h4 class="card-title">Datos del Ticket</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('tickets.update', $ticket->id) }}" method="post">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="service" value="{{$servicio->id}}">
                            <div class="row">
                                <div class="col-md-6">
                                    @if ($ticket->tipo !== 'INSTALACION')
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-static">Tipo de Ticket</label>
                                        <select name="tipo" id="tipo" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir una opción">
                                            <option @if($ticket->tipo === 'AVERIA') selected @endif value="AVERIA">AVERÍA</option>
                                            <option @if($ticket->tipo === 'DESCONEXION') selected @endif value="DESCONEXION">DESCONEXIÓN</option>
                                            <option @if($ticket->tipo === 'RECONEXION') selected @endif value="RECONEXION">RECONEXIÓN</option>
                                        </select>
                                    </div>
                                    @else
                                        <div class="form-group bmd-form-group">
                                            <label class="label-control">Tipo de Ticket</label>
                                            <input type="text" class="form-control" value="{{ $ticket->tipo }}" disabled>
                                            <input type="hidden" name="tipo" value="{{ $ticket->tipo }}">
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Motivo</label>
                                        @if ($ticket->tipo === 'INSTALACION')
                                        <input type="text" value="{{$ticket->motivo}}" class="form-control" required disabled>
                                        <input type="hidden" name="motivo" value="{{$ticket->motivo}}">
                                        @else
                                        <input type="text" name="motivo" value="{{$ticket->motivo}}" class="form-control" required>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Descripción</label>
                                        <textarea class="form-control" name="descripcion" rows="3">{{ $ticket->descripcion }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Fecha estimada de inicio</label>
                                        @if (Auth::user()->isTecnico())
                                        <input type="text" name="fecha_estimada_inicio_placeholder" value="{{ $ticket->fecha_estimada_inicio->format('m/d/Y h:i:s a') }}" class="form-control" disabled>
                                        <input type="hidden" name="fecha_estimada_inicio" value="{{ $ticket->fecha_estimada_inicio->format('m/d/Y h:i:s a') }}">
                                        @else
                                        <input type="text" id="fecha_estimada_inicio" name="fecha_estimada_inicio" value="{{ $ticket->fecha_estimada_inicio->format('m/d/Y h:i:s a') }}" class="form-control datetimepicker" required>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Fecha estimada de fin</label>
                                        @if (Auth::user()->isTecnico())
                                        <input type="text" name="fecha_estimada_cierre_placeholder" value="{{ $ticket->fecha_estimada_cierre->format('m/d/Y h:i:s a') }}" class="form-control" disabled>
                                        <input type="hidden" name="fecha_estimada_cierre" value="{{ $ticket->fecha_estimada_cierre->format('m/d/Y h:i:s a') }}">
                                        @else
                                        <input type="text" id="fecha_estimada_cierre" name="fecha_estimada_cierre" value="{{ $ticket->fecha_estimada_cierre->format('m/d/Y h:i:s a') }}" class="form-control datetimepicker" required>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Fecha efectiva de inicio</label>
                                        <input type="text" id="fecha_efectiva_inicio" name="fecha_efectiva_inicio" @if ($ticket->fecha_efectiva_inicio) value="{{ $ticket->fecha_efectiva_inicio->format('m/d/Y h:i:s a') }}" @endif class="form-control datetimepicker">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Fecha efectiva de fin</label>
                                        <input type="text" id="fecha_efectiva_cierre" name="fecha_efectiva_cierre" @if ($ticket->fecha_efectiva_cierre) value="{{ $ticket->fecha_efectiva_cierre->format('m/d/Y h:i:s a') }}" @endif class="form-control datetimepicker">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-static">Autor</label>
                                        <select name="autor_placeholder" class="form-control selectpicker" data-style="btn btn-link" disabled>
                                            <option value="SIN DEFINIR">SIN DEFINIR</option>
                                            @if ($ticket->autoruser)
                                            <option selected>{{ $ticket->autoruser->nombres }}</option>
                                            @endif
                                        </select>
                                        <input type="hidden" name="usuario_autor_id" value="{{ $ticket->usuario_autor_id }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        @if (Auth::user()->isTecnico())
                                        <label class="bmd-label-static">Asignado a</label>
                                        <input type="text" name="usuario_asignado_id_placeholder" value="{{ $ticket->assignateduser->nombres }}" class="form-control" disabled>
                                        <input type="hidden" name="usuario_asignado_id" value="{{ $ticket->assignateduser->id }}">
                                        @else
                                        <label class="bmd-label-static">Asignar a</label>
                                        <select name="usuario_asignado_id" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir un usuario">
                                            <option value="SIN DEFINIR">SIN DEFINIR</option>
                                            @foreach($usuarios as $usuario)
                                                <option @if($ticket->usuario_asignado_id === $usuario->id) selected @endif value="{{$usuario->id}}">{{ $usuario->nombres }}</option>
                                            @endforeach
                                        </select>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-static">Prioridad</label>
                                        <select name="prioridad" id="prioridad" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir una opción">
                                            <option @if ($ticket->prioridad === 'ALTA') selected @endif value="ALTA">ALTA</option>
                                            <option @if ($ticket->prioridad === 'MEDIA') selected @endif value="MEDIA">MEDIA</option>
                                            <option @if ($ticket->prioridad === 'BAJA') selected @endif value="BAJA">BAJA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-static">Estado Ticket</label>
                                        <select name="estado" id="estado" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir una opción">
                                            <option @if ($ticket->estado === 'ASIGNADO') selected @endif value="ASIGNADO">ASIGNADO</option>
                                            <option @if ($ticket->estado === 'EN CURSO') selected @endif value="EN CURSO">EN CURSO</option>
                                            <option @if ($ticket->estado === 'PENDIENTE') selected @endif value="PENDIENTE">PENDIENTE</option>
                                            <option @if ($ticket->estado === 'RESUELTO') selected @endif value="RESUELTO">RESUELTO</option>
                                            <option @if ($ticket->estado === 'CANCELADO') selected @endif value="CANCELADO">CANCELADO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
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
        });
    </script>
@endsection
