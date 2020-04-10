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
                    <h4 class="card-title">Listado Materiales Tipo B</h4>
                    <p class="card-category"></p>
                </div>
                <div class="card-body">
                    <div class="material-datatables">
                         <span class="table-add float-right mb-3 mr-2"><a href="{{ route('inventories.create') }}" class="text-success"><i
                                    class="material-icons purple400 md-36">add</i></a></span>
                       
                        <table id="datatables" class="table table-striped table-no-bordered table-hover data-table-column-filter nowrap" style="width:100%">
                            <thead class="text-primary">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Cantidad </th>
                                <th>Cantidad total</th>
                                <th>Fecha registro</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($Inventory as $Inventory)
                                <tr>
                                    <td>{{ $Inventory->id }}</td>
                                    <td>{{ $Inventory->Nombre}}</td>
                                    <td>{{ $Inventory->descripcion}}</td>
                                    <td>{{ $Inventory->cantidad}}</td>
                                    <td>{{ $Inventory->cantidad_total}}</td>
                                    <td>{{ $Inventory->fecha_registro}}</td>
                                    <td class="text-right">
                                        @if (!Auth::user()->isCajero())
                                        <span class="table-remove">
                                            <a class="btn btn-primary btn-fab btn-fab-mini btn-round" data-toggle="tooltip" title="Asignar material"
                                               href=""><i class="material-icons">add</i></a>
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