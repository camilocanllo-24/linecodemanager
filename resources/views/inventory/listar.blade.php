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
                        <h4 class="card-title ">Listado de materiales</h4>
                        <p class="card-category"></p>
                    </div>
                    <div class="card-body">
                        <div class="material-datatables">
                            @if (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                        <span class="table-add float-right mb-3 mr-2"><a href="{{ route('materials.create') }}" class="text-success"><i
                                    class="material-icons purple400 md-36">add</i></a></span>@endif
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead class="text-primary">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Cantidad</th>
                                        <th>Marca</th>
                                        <th>Mac</th>
                                        <th>Serial</th>
                                        <th>Fecha ingreso</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($materiales as $material)
                                    <tr>
                                        <td>{{ $material->id }}</td>
                                        <td>{{ $material->tipomaterial->nombre}}</td>
                                        <td>{{ $material->tipomaterial->descripcion}}</td>
                                        <td>{{ $material->cantidad}}</td>
                                        <td>{{ $material->tipomaterial->marca}}</td>
                                        <td>{{ $material->mac}}</td>
                                        <td>{{ $material->serial}}</td>
                                        <td>{{ $material->created_at}}</td>
                                        <td class="text-right">
                                            @if (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                                            @if($material->mac!='' && $material->cantidad <=1 ||  Auth::user()->isCajero())

                                            @else
                                            <span class="table-remove">
                                                <a class="btn btn-primary btn-fab btn-fab-mini btn-round"
                                                   data-toggle="tooltip"  title="Asignar cantidad"
                                                   href=" {{ action('InventoryController@edit', $material->id) }}"><i
                                                        class="material-icons">add</i></a>
                                            </span>
                                            @endif
                                            @endif
                                            <span class="table-remove">
                                                <a class="btn btn-info btn-fab btn-fab-mini btn-round" data-toggle="tooltip"
                                                   title="Ver registro ingreso"
                                                   href="{{ action('InventoryController@materialEntryRecords', ['tipomaterial_id' => $material->tipomaterial->id]) }}"><i class="material-icons">visibility</i></a>
                                            </span>
                                                <span class="table-remove">
                                                   <a class="btn btn-info btn-fab btn-fab-mini btn-round" data-toggle="tooltip"
                                                   title="Ver registro salida"
                                                   href="{{ action('InventoryController@assignedMaterials', ['tipomaterial_id' => $material->tipomaterial->id]) }}"><i class="material-icons">visibility</i></a>
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
    </script>
@endsection
