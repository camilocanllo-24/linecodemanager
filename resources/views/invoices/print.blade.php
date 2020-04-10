@extends('layouts.blank')
@section('titulo-pagina', 'Imprimir Ticket')
@section('content')
    <div class="container-fluid">
        <h3 class="text-center" style="margin: 0;">ORDEN DE SERVICIO #{{ $ticket->id }}</h3>
        <h4 class="text-center" style="margin: 0;">{{ $ticket->created_at->format('d/m/Y h:m:s a') }}</h4>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="margin-top: 0; margin-bottom: 0.5rem;">
                    <div class="card-body">
                        <div class="card-header card-header-primary card-header-icon">
                            <h4 class="card-title" style="margin-top: 0; margin-bottom: 0.5rem;">Datos del Abonado</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Tipo de Identificación</label>
                                    <input type="text" class="form-control" required
                                           value="{{ $abonado->tipo_identidad }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Número de Identificación</label>
                                    <input type="text" class="form-control" required
                                           value="{{ $abonado->numero_identidad }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Dirección</label>
                                    <input type="text" class="form-control"
                                           value="{{ $abonado->direccion }}" disabled>
                                </div>
                            </div>
                            <div class="col-md 3">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Teléfono</label>
                                    <input type="number" class="form-control"
                                           value="{{ $abonado->telefono }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Primer Nombre</label>
                                    <input type="text" class="form-control" required
                                           value="{{ $abonado->primer_nombre }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Segundo Nombre</label>
                                    <input type="text" class="form-control" required
                                           value="{{ $abonado->segundo_nombre }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Primer Apellido</label>
                                    <input type="text" class="form-control" required
                                           value="{{ $abonado->primer_apellido }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Segundo Apellido</label>
                                    <input type="text" class="form-control" required
                                           value="{{ $abonado->segundo_apellido }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="card-header card-header-primary card-header-icon">
                            <h4 class="card-title" style="margin-top: 0; margin-bottom: 0.5rem;">Datos del Servicio</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Dirección</label>
                                    <input type="text" value="{{ $servicio->direccion }}"
                                           class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Teléfono</label>
                                    <input type="text" value="{{ $servicio->telefono }}"
                                           class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Fecha subscripción</label>
                                    <input type="text" value="{{ $servicio->fecha_subscripcion }}"
                                           class="form-control datepicker" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Fecha instalación</label>
                                    <input type="text" value="{{ $servicio->fecha_instalacion }}"
                                           class="form-control datepicker" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Última milla</label>
                                    <input class="form-control" type="text" value="{{ $servicio->ultima_milla }}"
                                           disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Plan</label>
                                    <input type="text" class="form-control" disabled
                                           value="{{ $servicio->plan->nombre }} @if($servicio->plan->tv == 1) + TV @endif - $ {{ $servicio->plan->precio_total }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Nombre de Usuario</label>
                                    <input class="form-control" type="text" value="{{ $servicio->credential->nombre_usuario }}"
                                           disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Contraseña</label>
                                    <input class="form-control" type="text" value="{{ $servicio->credential->password }}"
                                           disabled>
                                </div>
                            </div>

                        </div>
                        @if ($servicio->ultima_milla === "GPON" && $ont)
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">ONT</label>
                                        <input type="text" class="form-control" disabled
                                               value="{{ $ont->olt->identificador }} | {{ $ont->board_olt }}/{{ $ont->puerto_olt }}/{{$ont->indice_ont}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group bmd-form-group">
                                        <label for="rx_power" class="bmd-label-static">RX Power</label>
                                        <input type="text" class="form-control" value="{{ $optical_info->rx_power }}"
                                               disabled>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group bmd-form-group">
                                        <label for="tx_power" class="bmd-label-static">TX Power</label>
                                        <input type="text" class="form-control" disabled
                                               value="{{ $optical_info->tx_power }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group bmd-form-group">
                                        <label for="catv_rx_power" class="bmd-label-static">CATV RX Power</label>
                                        <input type="text" class="form-control" disabled
                                               value="{{ $optical_info->catv_power }}">
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="card-header card-header-primary card-header-icon">
                            <h4 class="card-title" style="margin-top: 0; margin-bottom: 0.5rem;">Datos del Ticket</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-static">Tipo de Ticket</label>
                                    <input type="text" class="form-control" value="{{ $ticket->tipo }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Motivo</label>
                                    <input type="text" name="motivo" value="{{$ticket->motivo}}"
                                           class="form-control" required disabled>
                                </div>
                            </div>
                            @if ($ticket->fecha_efectiva_inicio && $ticket->fecha_efectiva_cierre)
                                <div class="col-md-3">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Fecha efectiva de inicio</label>
                                        <input disabled type="text"
                                               value="{{ $ticket->fecha_efectiva_inicio->format('d/m/Y h:m:s a') }}"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Fecha efectiva de fin</label>
                                        <input disabled type="text"
                                               value="{{ $ticket->fecha_efectiva_cierre->format('d/m/Y h:m:s a') }}"
                                               class="form-control">
                                    </div>
                                </div>
                            @else
                            <div class="col-md-3">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Fecha estimada de inicio</label>
                                    <input disabled type="text"
                                           value="{{ $ticket->fecha_estimada_inicio->format('d/m/Y h:m:s a') }}"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Fecha estimada de fin</label>
                                    <input disabled type="text"
                                           value="{{ $ticket->fecha_estimada_cierre->format('d/m/Y h:m:s a') }}"
                                           class="form-control">
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Descripción</label>
                                    <textarea disabled class="form-control" name="descripcion"
                                              rows="3">{{ $ticket->descripcion }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Autor</label>
                                    <input disabled type="text" class="form-control"
                                           value="{{ $ticket->autoruser->nombres }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Asignado a</label>
                                    <input disabled type="text" class="form-control"
                                           @if ($ticket->assignateduser) value="{{ $ticket->assignateduser->nombres }}" @endif>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Prioridad</label>
                                    <input disabled class="form-control" type="text" value="{{$ticket->prioridad}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Estado Ticket</label>
                                    <input disabled class="form-control" type="text" value="{{$ticket->estado}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            window.print();
        });
    </script>
@endsection
