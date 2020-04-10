@extends('layouts.base')
@section('titulo-pagina', 'Servicios')
@section('breadcrumb')
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/subscribers') }}">Abonados</a></li>
            @if (isset($abonado))
                <li class="breadcrumb-item"><a
                        href="{{ route('subscribers.edit', $abonado->id) }}">{{ $abonado->numero_identidad }}</a>
                </li> @endif
            <li class="breadcrumb-item active" aria-current="page">Servicios</li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @if (isset($abonado))
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
                @endif
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Listado Servicios</h4>
                        <p class="card-category"></p>
                    </div>
                    <div class="card-body">
                        <div class="material-datatables">
                            @if (isset($abonado))
                                @if (!Auth::user()->isCajero())
                                    <span class="table-add float-right mb-3 mr-2"><a
                                            href="{{ action('ServiceController@create', ['subscriber' => $abonado->id]) }}"
                                            class="text-success"><i
                                                class="material-icons purple400 md-36">add</i></a></span>
                                @endif
                            @endif
                            <table id="datatables" class="table table-striped table-no-bordered table-hover"
                                   style="width: 100%">
                                <thead class="text-primary">
                                <tr>
                                    <th>ID</th>
                                    @if (!isset($abonado))
                                        <th>Abonado</th>
                                    @endif
                                    <th>Plan</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                    <th>Última milla</th>
                                    @if (!isset($abonado))
                                        @if (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                                            <th>Agencia</th>
                                        @endif
                                    @endif
                                    <th>Fecha instalación</th>
                                    <th>Estado servicio</th>
                                    <th>Estado PPPoE</th>
                                    <th>IP Asignada</th>
                                    <th class="text-center">Pagos</th>
                                    <th class="text-center">Tickets</th>
                                    @if (isset($abonado))
                                        @if (!Auth::user()->isCajero())
                                            <th class="text-center">Servicio</th>
                                        @endif
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($servicios as $servicio)
                                    <tr>
                                        <td>{{ $servicio->id }}</td>
                                        @if (!isset($abonado))
                                            <td>{{ $servicio->subscriber->primer_nombre }} {{ $servicio->subscriber->primer_apellido }}</td>
                                        @endif
                                        @if ($servicio->plan->tv == 1 && !$servicio->plan->solo_tv)
                                            <td>{{ $servicio->plan->nombre }} + TV</td>
                                        @else
                                            <td>{{ $servicio->plan->nombre }}</td>
                                        @endif
                                        <td>{{ $servicio->direccion }}</td>
                                        <td>{{ $servicio->telefono }}</td>
                                        <td>{{ $servicio->ultima_milla }}</td>
                                        @if (!isset($abonado))
                                            @if (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                                                <td>{{ $servicio->subscriber->agency->isp->nombre}}
                                                    - {{ $servicio->subscriber->agency->nombre }}</td>
                                            @endif
                                        @endif
                                        @if (isset($servicio->fecha_instalacion))
                                            <td data-order="{{ $servicio->fecha_instalacion->timestamp }}">{{ $servicio->fecha_instalacion->format('d/m/Y') }}</td>
                                        @else
                                            <td></td>
                                        @endif
                                        @if ($servicio->estado == 1)
                                            <td>ACTIVO</td>
                                        @elseif ($servicio->estado == 0)
                                            <td>INACTIVO</td>
                                        @else
                                            <td>PREACTIVADO</td>
                                        @endif
                                        @if ($servicio->ultima_milla === 'CATV')
                                            <td>NO APLICA</td>
                                        @elseif ($servicio->pppoe_status === 'conectado')
                                        <td data-search="online"><span class="badge badge-pill badge-success">{{ strtoupper($servicio->pppoe_status) }}</span>
                                            @if (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                                                <a href="{{ action('ServiceController@admin_disconnect_user', $servicio->id) }}"> - DESCONECTAR</a>
                                            @endif
                                        </td>
                                        @else
                                        <td data-search="offline"><span class="badge badge-pill badge-danger">{{ strtoupper($servicio->pppoe_status) }}</span></td>
                                        @endif
                                        <td>@if (isset($servicio->framed_ip_address))<a href="http://{{ $servicio->framed_ip_address }}" data-toggle="tooltip" title="Ingresar al router" target="_blank">{{ $servicio->framed_ip_address }}</a>@endif</td>
                                        <td class="text-center">
                                        <span class="table-remove">
                                            <a class="btn btn-primary btn-fab btn-fab-mini btn-round"
                                               data-toggle="tooltip" title="Registrar Pago"
                                               href="{{ action('PaymentController@create', ['service' => $servicio->id]) }}"><i
                                                    class="material-icons">add</i></a>
                                        </span>
                                            <span class="table-remove">
                                            <a class="btn btn-default btn-fab btn-fab-mini btn-round"
                                               data-toggle="tooltip" title="Ver Pagos"
                                               href="{{ action('PaymentController@index', ['service' => $servicio->id]) }}"><i
                                                    class="material-icons">visibility</i></a>
                                        </span>
                                        </td>
                                        <td class="text-center">
                                        <span class="table-remove">
                                            <a class="btn btn-primary btn-fab btn-fab-mini btn-round"
                                               data-toggle="tooltip" title="Registrar Ticket"
                                               href="{{ action('TicketController@create', ['service' => $servicio->id]) }}"><i
                                                    class="material-icons">add</i></a>
                                        </span>
                                            <span class="table-remove">
                                            <a class="btn btn-default btn-fab btn-fab-mini btn-round"
                                               data-toggle="tooltip" title="Ver Tickets"
                                               href="{{ action('TicketController@index', ['service' => $servicio->id]) }}"><i
                                                    class="material-icons">visibility</i></a>
                                        </span>
                                        </td>
                                        @if (isset($abonado))
                                            @if (!Auth::user()->isCajero())
                                                <td class="text-center">
                                                    @if ($servicio->estado == 1)
                                                        <span class="table-remove">
                                            <a class="btn btn-info btn-fab btn-fab-mini btn-round" data-toggle="tooltip"
                                               title="Suspender Servicio"
                                               href="{{ action('ServiceController@toggle', $servicio->id) }}"><i
                                                    class="material-icons">close</i></a>
                                        </span>
                                                        <span class="table-remove">
                                            <a class="btn btn-default btn-fab btn-fab-mini btn-round"
                                               data-toggle="tooltip" title="Editar Servicio"
                                               href="{{ action('ServiceController@edit', $servicio->id) }}"><i
                                                    class="material-icons">edit</i></a>
                                        </span>
                                                    @else
                                                        <span class="table-remove">
                                            <a class="btn btn-info btn-fab btn-fab-mini btn-round" data-toggle="tooltip"
                                               title="Activar Servicio"
                                               href="{{ action('ServiceController@toggle', $servicio->id) }}"><i
                                                    class="material-icons">check</i></a>
                                        </span>
                                                    @endif
                                                    <span class="table-remove">
                                            <a class="btn btn-danger btn-fab btn-fab-mini btn-round"
                                               data-toggle="tooltip" title="Eliminar Servicio"
                                               href="{{ action('ServiceController@destroy', $servicio->id) }}"
                                               onclick="event.preventDefault(); eliminar_servicio({{$servicio->id}})">
                                                <i class="material-icons">delete</i>
                                            </a>
                                        </span>
                                                </td>
                                            @endif
                                        @endif
                                        <form id="delete-service-{{$servicio->id}}-form"
                                              action="{{ action('ServiceController@destroy', $servicio->id) }}"
                                              method="POST" style="display: none;">
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function eliminar_servicio($servicio_id) {
            Swal.fire({
                title: 'Estás seguro?',
                text: "No podrás revertir esta operación!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f44336',
                cancelButtonColor: '#999',
                confirmButtonText: 'Si, eliminar servicio!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    document.getElementById(`delete-service-${$servicio_id}-form`).submit();
                }
            });
        }

        $(document).ready(function () {
            var table = $('#datatables').addClass('nowrap').DataTable({
                @if (!isset($abonado))
                    @if (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                order: [
                    [7, 'desc']
                ],
                    @else
                order: [
                    [6, 'desc']
                ],
                    @endif
                "columnDefs": [
                    {"orderable": false, "targets": 0},
                    @if (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                    {
                        "orderable": false, "targets": 11
                    },
                    {"orderable": false, "targets": 12},
                    @else
                    {
                        "orderable": false, "targets": 10
                    },
                    {"orderable": false, "targets": 11},
                    @endif
                ],
                @else
                order: [
                    [5, 'desc']
                ],
                "columnDefs": [
                    {"orderable": false, "targets": 0},
                    {"orderable": false, "targets": 9},
                    {"orderable": false, "targets": 10},
                    @if (!Auth::user()->isCajero())
                    {
                        "orderable": false, "targets": 11
                    },
                    @endif
                ],
                @endif
                "pagingType": "full_numbers",
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Todos"]
                ],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Buscar",
                    "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                },
            });

            //  Activate the tooltips
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
