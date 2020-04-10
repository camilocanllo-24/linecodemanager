@extends('layouts.base')
@section('titulo-pagina', 'Pagos')
@section('breadcrumb')
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pagos</li>
        </ol>
    </nav>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Listado Pagos</h4>
                    <p class="card-category"></p>
                </div>
                <div class="card-body">
                    <div class="material-datatables">
                        @if (isset($service_id))
                        <span class="table-add float-right mb-3 mr-2"><a href="{{ action('PaymentController@create', ['service' => $service_id]) }}" data-toggle="tooltip" title="Registrar Pago" class="text-success"><i
                                    class="material-icons purple400 md-36">add</i></a></span>
                        @endif
                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead class="text-primary">
                            <tr>
                                <th>ID</th>
                                <th>Abonado</th>
                                <th>Servicio</th>
                                <th>Fecha pago</th>
                                <th>Cajero</th>
                                <th>Monto</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($pagos as $pago)
                                <tr>
                                    <td>{{ $pago->id }}</td>
                                    <td>@if (isset($pago->service->subscriber)) {{ $pago->service->subscriber->primer_nombre }} {{ $pago->service->subscriber->primer_apellido }}@endif</td>
                                    <td>@if (isset($pago->service->plan)) {{ $pago->service->plan->nombre }} @endif</td>
                                    <td data-order="{{ $pago->fecha_pago->timestamp }}">{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                                    <td>@if (isset($pago->cajero)) {{ $pago->cajero->nombres }} @endif</td>
                                    <td data-order="{{ $pago->monto }}">$ {{ number_format($pago->monto, 2, ',', '.')  }}</td>
                                    @if ($pago->trashed())
                                        <td class="text-center">
                                        <span class="table-remove">
                                            <a class="btn btn-info btn-fab btn-fab-mini btn-round" data-toggle="tooltip" title="Anular Pago"
                                               href="{{ action('PaymentController@destroy', $pago->id) }}"
                                               onclick="event.preventDefault(); eliminar_pago({{$pago->id}})">
                                                <i class="material-icons">check</i>
                                            </a>
                                        </span>
                                        <form id="delete-payment-{{$pago->id}}-form" action="{{ action('PaymentController@destroy', $pago->id) }}" method="POST" style="display: none;">
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                        </td>
                                    @else
                                    <td class="text-center">
                                        {{--<span class="table-remove">
                                            <a class="btn btn-primary btn-fab btn-fab-mini btn-round" data-toggle="tooltip" title="Imprimir Recibo"
                                               href="{{ action('PaymentController@print', $pago->id) }}" target="_blank"><i class="material-icons">print</i></a>
                                        </span>--}}
                                        {{--<span class="table-remove">
                                            <a class="btn btn-default btn-fab btn-fab-mini btn-round" data-toggle="tooltip" title="Editar Pago"
                                               href="{{ action('PaymentController@edit', $pago->id) }}"><i class="material-icons">edit</i></a>
                                        </span>--}}
                                        <span class="table-remove">
                                            <a class="btn btn-danger btn-fab btn-fab-mini btn-round" data-toggle="tooltip" title="Anular Pago"
                                               href="{{ action('PaymentController@destroy', $pago->id) }}"
                                               onclick="event.preventDefault(); eliminar_pago({{$pago->id}})">
                                                <i class="material-icons">close</i>
                                            </a>
                                        </span>
                                        <form id="delete-payment-{{$pago->id}}-form" action="{{ action('PaymentController@destroy', $pago->id) }}" method="POST" style="display: none;">
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                                @endif
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
        function eliminar_pago(pago_id) {
            Swal.fire({
                title: 'Estás seguro?',
                text: "No podrás revertir esta operación!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f44336',
                cancelButtonColor: '#999',
                confirmButtonText: 'Si, anular ticket!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    document.getElementById(`delete-payment-${pago_id}-form`).submit();
                }
            });
        }
        var table = $('#datatables').DataTable({
            order: [
                [3, 'desc']
            ],
            "columnDefs": [
                { "orderable": false, "targets": 0 },
                { "orderable": false, "targets": 6 },
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
