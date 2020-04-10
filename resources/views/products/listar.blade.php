@extends('layouts.base')
@section('titulo-pagina', 'Planes/Tarifas')
@section('breadcrumb')
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Productos</li>
        </ol>
    </nav>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">Listado Productos</h4>
                    <p class="card-category"></p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <span class="table-add float-right mb-3 mr-2"><a href="{{ route('products.create') }}" class="text-success"><i
                                        class="material-icons purple400 md-36">add</i></a></span>
                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead class=" text-primary">
                            <tr>
                                <th>Codigo Barras</th>
                                <th>Descripción</th>
                                <th>Marca</th>
                                <th>Categoria</th>
                                <th>Iva</th>
                                <th>Precio Cj,Dp,Pc</th>
                                <th>Precio unidad</th>
                                <th>Precio Venta</th>
                                <th>Cantidad</th>
                                <th>Ganancia</th>
                                <th>Imagen</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr></thead>
                            <tbody>
                            @foreach ($productos as $producto)
                                <tr>
                                    <td>{{ $producto->codigo_barras }}</td>
                                    <td>{{ $producto->descripcion }}</td>
                                    <td>{{ $producto->marca }}</td>
                                    <td>{{ $producto->category->descripcion }}</td>
                                    <td>{{ $producto->vat->descripcion }}</td>
                                    <td>{{ number_format($producto->precio_cj_dp) }}</td>
                                    <td>{{ $producto->precio_und }}</td>
                                    <td>{{ $producto->precio_venta }}</td>
                                    <td>{{ $producto->cantidad_actual }}</td>
                                    <td>{{ $producto->utilidad }}</td>
                                    <td>{{ $producto->imagen }}</td>
                                    <td>{{ $producto->created_at }}</td>
                                    <td><span class="table-remove">
                                            <a class="btn btn-dark btn-rounded btn-sm my-0"
                                               href="{{ action('ProductController@edit', $producto->id) }}">Editar</a>
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
