@extends('layouts.base')
@section('titulo-pagina', 'Inventario')
@section('breadcrumb')
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Inventario</li>
        </ol>
    </nav>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Listado Materiales Tipo A</h4>
                    <p class="card-category"></p>
                </div>
                <div class="material-datatables">
                         <span class="table-add float-right mb-3 mr-2"><a href="{{ route('type__a_materials.create') }}" class="text-success"><i
                                    class="material-icons purple400 md-36">add</i></a></span>
                        @if (isset($service_id))
                        <span class="table-add float-right mb-3 mr-2"><a href="{{ action('type_A_materialController@create', ['type_A_material' => $type_A_material]) }}" data-toggle="tooltip" title="Ingresar nuevo material" class="text-success"><i
                                    class="material-icons purple400 md-36">add</i></a></span>
                        @endif
                        <table id="datatables" class="table table-striped table-no-bordered table-hover data-table-column-filter nowrap" style="width:100%">
                            <thead class="text-primary">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Cantidad </th>
                                <th>Cantidad total</th>
                                <th>Marca</th>
                                <th>Mac</th>
                                <th>Fecha registro</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($type_A_material as $type_A_material)
                                <tr>
                                    <td>{{ $type_A_material->id }}</td>
                                    <td>{{ $type_A_material->NombreMaterial}}</td>
                                    <td>{{ $type_A_material->descripcion}}</td>
                                    <td>{{ $type_A_material->cantidad}}</td>
                                    <td>{{ $type_A_material->cantidad_total}}</td>
                                    <td>{{ $type_A_material->marca}}</td>
                                    <td>{{ $type_A_material->mac}}</td>
                                    <td>{{ $type_A_material->fecha_registro}}</td>
                                    <td class="text-right">
                                        @if (!Auth::user()->isCajero())
                                        <span class="table-remove">
                                            <a class="btn btn-primary btn-fab btn-fab-mini btn-round" data-toggle="tooltip" title="Asignar material"
                                               href="{{ action('SubscriberController@edit', $abonado->id) }}"><i class="material-icons">add</i></a>
                                        </span>
                                        @endif
                                        <span class="table-remove">
                                            <a class="btn btn-info btn-fab btn-fab-mini btn-round" data-toggle="tooltip" title="Ver material"
                                               href=""><i class="material-icons">visibility</i></a>
                                        </span>
                                        <span class="table-remove">
                                            <a class="btn btn-default btn-fab btn-fab-mini btn-round" data-toggle="tooltip" title="Editar material"
                                               href=""><i class="material-icons">edit</i></a>
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
                @if (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                order: [
                    [5, 'desc']
                ],
                "columnDefs": [
                    { "orderable": false, "targets": 0 },
                    { "orderable": false, "targets": 7 },
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

        
        var table = $('#datatables').DataTable({
            order: [
              [5, 'desc']
            ],
            "columnDefs": [
                { "orderable": false, "targets": 0 },
                { "orderable": true, "targets": 1 },
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
    </script>

@endsection