@extends('layouts.base')
@section('titulo-pagina', 'Tickets')
@section('breadcrumb')
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tickets</li>
        </ol>
    </nav>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Listado Tickets</h4>
                    <p class="card-category"></p>
                </div>
                <div class="card-body">
                    <div class="material-datatables">
                        @if (isset($service_id))
                        <span class="table-add float-right mb-3 mr-2"><a href="{{ action('TicketController@create', ['service' => $service_id]) }}" data-toggle="tooltip" title="Crear Ticket" class="text-success"><i
                                    class="material-icons purple400 md-36">add</i></a></span>
                        @endif
                        <table id="datatables" class="table table-striped table-no-bordered table-hover data-table-column-filter nowrap" style="width:100%">
                            <thead class="text-primary">
                            <tr>
                                <th>ID</th>
                                <th>Abonado</th>
                                <th>Tipo</th>
                                <th>Fecha inicio</th>
                                <th>Fecha cierre</th>
                                <th>Fecha creacion</th>
                                <th>Prioridad</th>
                                @if (Auth::user()->isSuperAdmin())
                                    <th>ISP</th>
                                @endif
                                @if (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                                    <th>Agencia</th>
                                @endif
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($tickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->id }}</td>
                                    <td>{{ $ticket->service->subscriber->primer_nombre }} {{ $ticket->service->subscriber->primer_apellido }}</td>
                                    <td>{{ $ticket->tipo }}</td>
                                    @if ($ticket->fecha_efectiva_inicio)
                                        <td data-order="{{ $ticket->fecha_efectiva_inicio->timestamp }}"> {{ $ticket->fecha_efectiva_inicio->format('d/m/Y H:i') }}</td>
                                    @else
                                        <td></td>
                                    @endif
                                @if ($ticket->fecha_efectiva_cierre)
                                        <td data-order="{{ $ticket->fecha_efectiva_cierre->timestamp }}">{{ $ticket->fecha_efectiva_cierre->format('d/m/Y H:i') }}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    <td data-order="{{ $ticket->created_at->timestamp }}">{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $ticket->prioridad }}</td>
                                    @if (Auth::user()->isSuperAdmin())
                                    <td>{{ $ticket->service->subscriber->agency->isp->nombre }}</td>
                                    @endif
                                    @if (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                                    <td>{{ $ticket->service->subscriber->agency->nombre }}</td>
                                    @endif
                                    <td>{{ $ticket->estado }}</td>
                                    <td class="text-center">
                                        <span class="table-remove">
                                            <a class="btn btn-primary btn-fab btn-fab-mini btn-round" data-toggle="tooltip" title="Imprimir Ticket"
                                               href="{{ action('TicketController@print', $ticket->id) }}" target="_blank"><i class="material-icons">print</i></a>
                                        </span>
                                        <span class="table-remove">
                                            <a class="btn btn-default btn-fab btn-fab-mini btn-round" data-toggle="tooltip" title="Editar Ticket"
                                               href="{{ action('TicketController@edit', $ticket->id) }}"><i class="material-icons">edit</i></a>
                                        </span>
                                        @if ($ticket->estado === 'CANCELADO' || $ticket->estado === 'RESUELTO')
                                        <span class="table-remove">
                                            <a class="btn btn-info btn-fab btn-fab-mini btn-round" data-toggle="tooltip" title="Reabrir Ticket"
                                               href="{{ action('TicketController@destroy', $ticket->id) }}"
                                               onclick="event.preventDefault(); toggle_ticket({{$ticket->id}}, 'closed')">
                                                <i class="material-icons">check</i>
                                            </a>
                                        </span>
                                        @else
                                        <span class="table-remove">
                                            <a class="btn btn-danger btn-fab btn-fab-mini btn-round" data-toggle="tooltip" title="Anular Ticket"
                                               href="{{ action('TicketController@destroy', $ticket->id) }}"
                                               onclick="event.preventDefault(); toggle_ticket({{$ticket->id}}, 'open')">
                                                <i class="material-icons">close</i>
                                            </a>
                                        </span>
                                        @endif
                                        <form id="delete-ticket-{{$ticket->id}}-form" action="{{ action('TicketController@destroy', $ticket->id) }}" method="POST" style="display: none;">
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                    </td>
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
        function toggle_ticket(ticket_id, estado) {
            if (estado === 'closed') {
                Swal.fire({
                    title: 'Reabrir ticket!',
                    text: "Está seguro que desea reabrir este ticket?",
                    type: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#00bcd4',
                    cancelButtonColor: '#999',
                    confirmButtonText: 'Si, reabrir ticket!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        document.getElementById(`delete-ticket-${ticket_id}-form`).submit();
                    }
                });
            } else {
                Swal.fire({
                    title: 'Cerrar ticket!',
                    text: "Está seguro que desea cerrar este ticket?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#f44336',
                    cancelButtonColor: '#999',
                    confirmButtonText: 'Si, cerrar ticket!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        document.getElementById(`delete-ticket-${ticket_id}-form`).submit();
                    }
                });
            }
        }
        var table = $('#datatables').DataTable({
            order: [
              [5, 'desc']
            ],
            "columnDefs": [
                { "orderable": false, "targets": 0 },
                { "orderable": true, "targets": 1 },
                @if (Auth::user()->isSuperAdmin())
                { "orderable": false, "targets": 10 },
                @elseif (Auth::user()->isAdmin())
                { "orderable": false, "targets": 9 },
                @else
                { "orderable": false, "targets": 8 },
                @endif
            ],
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
    </script>
@endsection
