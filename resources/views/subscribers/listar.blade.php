@extends('layouts.base')
@section('titulo-pagina', 'Abonados')
@section('breadcrumb')
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Abonados</li>
        </ol>
    </nav>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">Listado Abonados</h4>
                    <p class="card-category"></p>
                </div>
                <div class="card-body">
                    <div class="material-datatables">
                        <span class="table-add float-right mb-3 mr-2"><a href="{{ route('subscribers.create') }}" class="text-success"><i
                                    class="material-icons purple400 md-36">add</i></a></span>
                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead class="text-primary">
                            <tr>
                                <th>ID</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                @if (Auth::user()->isSuperAdmin())
                                <th>ISP</th>
                                @endif
                                @if (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                                <th>Agencia</th>
                                @endif
                                <th>Fecha registro</th>
                                <th>Estado</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($abonados as $abonado)
                                <tr>
                                    <td>{{ $abonado->codigo_abonado }}</td>
                                    <td>{{ $abonado->primer_nombre }} {{ $abonado->segundo_nombre }}</td>
                                    <td>{{ $abonado->primer_apellido }} {{ $abonado->segundo_apellido }}</td>
                                    @if (Auth::user()->isSuperAdmin())
                                    <td>{{ $abonado->agency->isp->nombre }}</td>
                                    @endif
                                    @if (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                                    <td>{{ strtoupper($abonado->agency->nombre) }}</td>
                                    @endif
                                    <td data-order="{{ $abonado->created_at->timestamp }}">{{ $abonado->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ strtoupper($abonado->estado) }}</td>
                                    <td class="text-right">
                                        <span class="table-remove">
                                            <a class="btn btn-primary btn-fab btn-fab-mini btn-round" data-toggle="tooltip" title="Crear Servicio"
                                               href="{{ action('ServiceController@create', ['subscriber' => $abonado->id]) }}"><i class="material-icons">add</i></a>
                                        </span>
                                        <span class="table-remove">
                                            <a class="btn btn-info btn-fab btn-fab-mini btn-round" data-toggle="tooltip" title="Ver Servicios"
                                               href="{{ action('ServiceController@index', ['subscriber' => $abonado->id]) }}"><i class="material-icons">visibility</i></a>
                                        </span>
                                        <span class="table-remove">
                                            <a class="btn btn-default btn-fab btn-fab-mini btn-round" data-toggle="tooltip" title="Editar Abonado"
                                               href="{{ action('SubscriberController@edit', $abonado->id) }}"><i class="material-icons">edit</i></a>
                                        </span>
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
        $(document).ready(function () {

            //  Activate the tooltips
            $('[data-toggle="tooltip"]').tooltip();

            var table = $('#datatables').DataTable({
                @if (Auth::user()->isSuperAdmin())
                order: [
                    [5, 'desc']
                ],
                "columnDefs": [
                    { "orderable": false, "targets": 0 },
                    { "orderable": false, "targets": 7 },
                ],
                @elseif (Auth::user()->isAdmin())
                order: [
                    [4, 'desc']
                ],
                "columnDefs": [
                    { "orderable": false, "targets": 0 },
                    { "orderable": false, "targets": 6 },
                ],
                @else
                order: [
                    [3, 'desc']
                ],
                "columnDefs": [
                    { "orderable": false, "targets": 0 },
                    { "orderable": false, "targets": 5 },
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
        });
    </script>
@endsection
