@extends('layouts.base')
@section('titulo-pagina', 'Registrar Pago')
@section('breadcrumb')
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('payments.index', ['service', $servicio->id]) }}">Pagos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Crear</li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">money_off</i>
                        </div>
                        <h4 class="card-title">Datos del Pago</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('payments.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="service" value="{{ $servicio->id }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Abonado</label>
                                        <input type="text" name="abonado" class="form-control" value="{{ $servicio->subscriber->primer_nombre }} {{ $servicio->subscriber->primer_apellido }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Servicio</label>
                                        <input type="text" name="servicio" class="form-control" value="{{ $servicio->plan->nombre }} @if ($servicio->plan->tv) + TV: @endif $ {{ $servicio->plan->precio_total }}" disabled>
                                    </div>
                                </div>
                                @if (isset($deuda))
                                <div class="col-md-3">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Deuda actual</label>
                                        <input type="text" class="form-control" value="@if($deuda) $ {{ number_format($deuda, 2, ',', '.')  }}@endif" disabled>
                                    </div>
                                </div>
                                @elseif (isset($saldo))
                                <div class="col-md-3">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Saldo actual</label>
                                        <input type="text" class="form-control" value="@if($saldo) $ {{ number_format($saldo, 2, ',', '.')  }}@endif" disabled>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-static">Forma de pago</label>
                                        <select class="form-control selectpicker" data-style="btn btn-link" data-title="Elija una forma de pago" name="forma_pago" id="forma_pago" required>
                                            <option value="EFECTIVO">EFECTIVO</option>
                                            <option value="EFECTY">EFECTY</option>
                                            <option value="TARJETA DE CREDITO">TARJETA DE CREDITO</option>
                                            <option value="TARJETA DEBITO">TARJETA DEBITO</option>
                                            <option value="TRANSFERENCIA BANCARIA">TRANSFERENCIA BANCARIA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Referencia de Pago</label>
                                        <input type="text" class="form-control" name="referencia_pago" id="referencia_pago">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Fecha de pago</label>
                                        <input type="text" name="fecha_pago" class="form-control datepicker" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Valor a cancelar</label>
                                        <input type="text" id="monto" name="monto" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            @if ($servicio->estado == 0)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" id="reactivar_servicio" name="reactivar_servicio" class="form-check-input">
                                            Reactivar Servicio
                                            <span class="form-check-sign">
                                            <span class="check"></span>
                                        </span>
                                        </label>
                                    </div>
                                </div>
                            @endif
                            </div>
                            <button type="submit" class="btn btn-primary pull-right">Registrar Pago</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/jquery.priceformat.min.js') }}"></script>
    <script>
        md.initFormExtendedDatetimepickers();
        $(document).ready(function () {
            var monto = $('#monto');
            monto.priceFormat({
                prefix: '$ ',
                centsSeparator: ',',
                thousandsSeparator: '.',
                clearOnEmpty: true
            });
        });
    </script>
@endsection

