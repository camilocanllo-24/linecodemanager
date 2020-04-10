@extends('layouts.base')
@section('titulo-pagina', 'Planes/Tarifas')
@section('breadcrumb')
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Planes</li>
        </ol>
    </nav>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">Listado Planes</h4>
                    <p class="card-category"></p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <span class="table-add float-right mb-3 mr-2"><a href="{{ route('plans.create') }}" class="text-success"><i
                                        class="material-icons purple400 md-36">add</i></a></span>
                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead class=" text-primary">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descarga/Subida</th>
                                <th>Tarifa Internet</th>
                                <th>Tarifa TV</th>
                                @if (Auth::user()->isSuperAdmin()) <th>ISP</th> @endif
                                @if (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin()) <th>Agencia</th> @endif
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr></thead>
                            <tbody>
                            @foreach ($planes as $plan)
                                <tr>
                                    <td>{{ $plan->id }}</td>
                                    @if ($plan->solo_tv)
                                    <td>{{ $plan->nombre }}</td>
                                    <td></td>
                                    @else
                                    <td>{{ $plan->nombre }}@if ($plan->tv) + TV @endif</td>
                                    <td>{{ $plan->tasa_descarga }} Mb / {{ $plan->tasa_subida }} Mb</td>
                                    @endif
                                    <td>$ {{ $plan->formatted_precio_internet }}</td>
                                    <td>$ {{ $plan->formatted_precio_tv }}</td>
                                    @if (Auth::user()->isSuperAdmin()) <td>{{ $plan->agency->isp->nombre }}</td> @endif
                                    @if (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin()) <td>{{ $plan->agency->nombre }}</td> @endif
                                    @if ($plan->estado == 1)
                                        <td>ACTIVO</td>
                                    @else
                                        <td>INACTIVO</td>
                                    @endif
                                    <td><span class="table-remove">
                                            <a class="btn btn-dark btn-rounded btn-sm my-0"
                                                        href="{{ action('PlanController@edit', $plan->id) }}">Ver</a>
                                        </span></td>
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
                order: [
                    [1, 'desc']
                ],
                "columnDefs": [
                    { "orderable": false, "targets": 0 },
                    { "orderable": false, "targets": 8 },
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
        });
    </script>
@endsection
