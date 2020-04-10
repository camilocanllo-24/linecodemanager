@extends('layouts.base')
@section('titulo-pagina', 'Editar Agencia')
@section('breadcrumb')
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/agencies') }}">Agencias</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar</li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Editar Agencia</h4>
                        <p class="card-category">Complete el formulario</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ action('AgencyController@update', $agency_id) }}" method="post">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Nombre</label>
                                        <input style="text-transform:uppercase;" type="text" name="nombre" value="{{ $agency->nombre }}" class="form-control" required autofocus>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Dirección</label>
                                        <input style="text-transform:uppercase;" type="text" name="direccion" value="{{ $agency->direccion }}" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Contacto</label>
                                        <input style="text-transform:uppercase;" type="text" name="contacto" value="{{ $agency->contacto }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Email</label>
                                        <input style="text-transform:uppercase;" type="text" name="email" value="{{ $agency->email }}" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Teléfono</label>
                                        <input type="text" name="telefono" value="{{ $agency->telefono }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Ciudad/Municipio</label>
                                        <input style="text-transform:uppercase;" type="text" name="municipio" value="{{ $agency->municipio }}" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="isp" class="bmd-label-static">ISP</label>
                                        <select name="isp" id="isp" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir ISP">
                                            <option selected value="{{ $agency->isp_id }}">{{ $agency->isp->nombre }}</option>
                                            @foreach($isps as $isp)
                                                <option value="{{ $isp->id }}">{{ $isp->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-static">Tipo de facturación</label>
                                        <select name="tipo_facturacion" class="form-control selectpicker" data-style="btn btn-link" data-title="Elija una opción" id="tipo_facturacion" required>
                                            <option @if ($agency->tipo_facturacion  === 'PREPAGO') selected @endif value="PREPAGO">PREPAGO</option>
                                            <option @if ($agency->tipo_facturacion === 'POSTPAGO') selected @endif value="POSTPAGO">POSTPAGO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="div_postpago_1" style="display: none;">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-static">Dia de facturación</label>
                                        <select name="dia_facturacion" class="form-control selectpicker" data-style="btn btn-link" data-title="Elija una opción" id="dia_facturacion" data-live-search="true" data-size="6">
                                            <option @if($agency->dia_facturacion == 1) selected @endif value="1">1 DE CADA MES</option>
                                            <option @if($agency->dia_facturacion == 2) selected @endif value="2">2 DE CADA MES</option>
                                            <option @if($agency->dia_facturacion == 3) selected @endif value="3">3 DE CADA MES</option>
                                            <option @if($agency->dia_facturacion == 4) selected @endif value="4">4 DE CADA MES</option>
                                            <option @if($agency->dia_facturacion == 5) selected @endif value="5">5 DE CADA MES</option>
                                            <option @if($agency->dia_facturacion == 6) selected @endif value="6">6 DE CADA MES</option>
                                            <option @if($agency->dia_facturacion == 7) selected @endif value="7">7 DE CADA MES</option>
                                            <option @if($agency->dia_facturacion == 8) selected @endif value="8">8 DE CADA MES</option>
                                            <option @if($agency->dia_facturacion == 9) selected @endif value="9">9 DE CADA MES</option>
                                            <option @if($agency->dia_facturacion == 10) selected @endif value="10">10 DE CADA MES</option>
                                            <option @if($agency->dia_facturacion == 11) selected @endif value="11">11 DE CADA MES</option>
                                            <option @if($agency->dia_facturacion == 12) selected @endif value="12">12 DE CADA MES</option>
                                            <option @if($agency->dia_facturacion == 13) selected @endif value="13">13 DE CADA MES</option>
                                            <option @if($agency->dia_facturacion == 14) selected @endif value="14">14 DE CADA MES</option>
                                            <option @if($agency->dia_facturacion == 15) selected @endif value="15">15 DE CADA MES</option>
                                            <option @if($agency->dia_facturacion == 16) selected @endif value="16">16 DE CADA MES</option>
                                            <option @if($agency->dia_facturacion == 17) selected @endif value="17">17 DE CADA MES</option>
                                            <option @if($agency->dia_facturacion == 18) selected @endif value="18">18 DE CADA MES</option>
                                            <option @if($agency->dia_facturacion == 19) selected @endif value="19">19 DE CADA MES</option>
                                            <option @if($agency->dia_facturacion == 20) selected @endif value="20">20 DE CADA MES</option>
                                            <option @if($agency->dia_facturacion == 21) selected @endif value="21">21 DE CADA MES</option>
                                            <option @if($agency->dia_facturacion == 22) selected @endif value="22">22 DE CADA MES</option>
                                            <option @if($agency->dia_facturacion == 23) selected @endif value="23">23 DE CADA MES</option>
                                            <option @if($agency->dia_facturacion == 24) selected @endif value="24">24 DE CADA MES</option>
                                            <option @if($agency->dia_facturacion == 25) selected @endif value="25">25 DE CADA MES</option>
                                            <option @if($agency->dia_facturacion == 26) selected @endif value="26">26 DE CADA MES</option>
                                            <option @if($agency->dia_facturacion == 27) selected @endif value="27">27 DE CADA MES</option>
                                            <option @if($agency->dia_facturacion == 28) selected @endif value="28">28 DE CADA MES</option>
                                            <option @if($agency->dia_facturacion == 29) selected @endif value="29">29 DE CADA MES</option>
                                            <option @if($agency->dia_facturacion == 30) selected @endif value="30">30 DE CADA MES</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-static">Dia de pago</label>
                                        <select name="dia_pago" class="form-control selectpicker" data-style="btn btn-link" data-title="Elija una opción" id="dia_pago" data-live-search="true" data-size="6">
                                            <option @if($agency->dia_pago == 1) selected @endif value="1">1 DE CADA MES</option>
                                            <option @if($agency->dia_pago == 2) selected @endif value="2">2 DE CADA MES</option>
                                            <option @if($agency->dia_pago == 3) selected @endif value="3">3 DE CADA MES</option>
                                            <option @if($agency->dia_pago == 4) selected @endif value="4">4 DE CADA MES</option>
                                            <option @if($agency->dia_pago == 5) selected @endif value="5">5 DE CADA MES</option>
                                            <option @if($agency->dia_pago == 6) selected @endif value="6">6 DE CADA MES</option>
                                            <option @if($agency->dia_pago == 7) selected @endif value="7">7 DE CADA MES</option>
                                            <option @if($agency->dia_pago == 8) selected @endif value="8">8 DE CADA MES</option>
                                            <option @if($agency->dia_pago == 9) selected @endif value="9">9 DE CADA MES</option>
                                            <option @if($agency->dia_pago == 10) selected @endif value="10">10 DE CADA MES</option>
                                            <option @if($agency->dia_pago == 11) selected @endif value="11">11 DE CADA MES</option>
                                            <option @if($agency->dia_pago == 12) selected @endif value="12">12 DE CADA MES</option>
                                            <option @if($agency->dia_pago == 13) selected @endif value="13">13 DE CADA MES</option>
                                            <option @if($agency->dia_pago == 14) selected @endif value="14">14 DE CADA MES</option>
                                            <option @if($agency->dia_pago == 15) selected @endif value="15">15 DE CADA MES</option>
                                            <option @if($agency->dia_pago == 16) selected @endif value="16">16 DE CADA MES</option>
                                            <option @if($agency->dia_pago == 17) selected @endif value="17">17 DE CADA MES</option>
                                            <option @if($agency->dia_pago == 18) selected @endif value="18">18 DE CADA MES</option>
                                            <option @if($agency->dia_pago == 19) selected @endif value="19">19 DE CADA MES</option>
                                            <option @if($agency->dia_pago == 20) selected @endif value="20">20 DE CADA MES</option>
                                            <option @if($agency->dia_pago == 21) selected @endif value="21">21 DE CADA MES</option>
                                            <option @if($agency->dia_pago == 22) selected @endif value="22">22 DE CADA MES</option>
                                            <option @if($agency->dia_pago == 23) selected @endif value="23">23 DE CADA MES</option>
                                            <option @if($agency->dia_pago == 24) selected @endif value="24">24 DE CADA MES</option>
                                            <option @if($agency->dia_pago == 25) selected @endif value="25">25 DE CADA MES</option>
                                            <option @if($agency->dia_pago == 26) selected @endif value="26">26 DE CADA MES</option>
                                            <option @if($agency->dia_pago == 27) selected @endif value="27">27 DE CADA MES</option>
                                            <option @if($agency->dia_pago == 28) selected @endif value="28">28 DE CADA MES</option>
                                            <option @if($agency->dia_pago == 29) selected @endif value="29">29 DE CADA MES</option>
                                            <option @if($agency->dia_pago == 30) selected @endif value="30">30 DE CADA MES</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="div_postpago_2" style="display: none;">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-static">Dia de corte</label>
                                        <select name="dia_corte" class="form-control selectpicker" data-style="btn btn-link" data-title="Elija una opción" id="dia_corte" data-live-search="true" data-size="6">
                                            <option @if($agency->dia_corte == 1) selected @endif value="1">1 DE CADA MES</option>
                                            <option @if($agency->dia_corte == 2) selected @endif value="2">2 DE CADA MES</option>
                                            <option @if($agency->dia_corte == 3) selected @endif value="3">3 DE CADA MES</option>
                                            <option @if($agency->dia_corte == 4) selected @endif value="4">4 DE CADA MES</option>
                                            <option @if($agency->dia_corte == 5) selected @endif value="5">5 DE CADA MES</option>
                                            <option @if($agency->dia_corte == 6) selected @endif value="6">6 DE CADA MES</option>
                                            <option @if($agency->dia_corte == 7) selected @endif value="7">7 DE CADA MES</option>
                                            <option @if($agency->dia_corte == 8) selected @endif value="8">8 DE CADA MES</option>
                                            <option @if($agency->dia_corte == 9) selected @endif value="9">9 DE CADA MES</option>
                                            <option @if($agency->dia_corte == 10) selected @endif value="10">10 DE CADA MES</option>
                                            <option @if($agency->dia_corte == 11) selected @endif value="11">11 DE CADA MES</option>
                                            <option @if($agency->dia_corte == 12) selected @endif value="12">12 DE CADA MES</option>
                                            <option @if($agency->dia_corte == 13) selected @endif value="13">13 DE CADA MES</option>
                                            <option @if($agency->dia_corte == 14) selected @endif value="14">14 DE CADA MES</option>
                                            <option @if($agency->dia_corte == 15) selected @endif value="15">15 DE CADA MES</option>
                                            <option @if($agency->dia_corte == 16) selected @endif value="16">16 DE CADA MES</option>
                                            <option @if($agency->dia_corte == 17) selected @endif value="17">17 DE CADA MES</option>
                                            <option @if($agency->dia_corte == 18) selected @endif value="18">18 DE CADA MES</option>
                                            <option @if($agency->dia_corte == 19) selected @endif value="19">19 DE CADA MES</option>
                                            <option @if($agency->dia_corte == 20) selected @endif value="20">20 DE CADA MES</option>
                                            <option @if($agency->dia_corte == 21) selected @endif value="21">21 DE CADA MES</option>
                                            <option @if($agency->dia_corte == 22) selected @endif value="22">22 DE CADA MES</option>
                                            <option @if($agency->dia_corte == 23) selected @endif value="23">23 DE CADA MES</option>
                                            <option @if($agency->dia_corte == 24) selected @endif value="24">24 DE CADA MES</option>
                                            <option @if($agency->dia_corte == 25) selected @endif value="25">25 DE CADA MES</option>
                                            <option @if($agency->dia_corte == 26) selected @endif value="26">26 DE CADA MES</option>
                                            <option @if($agency->dia_corte == 27) selected @endif value="27">27 DE CADA MES</option>
                                            <option @if($agency->dia_corte == 28) selected @endif value="28">28 DE CADA MES</option>
                                            <option @if($agency->dia_corte == 29) selected @endif value="29">29 DE CADA MES</option>
                                            <option @if($agency->dia_corte == 30) selected @endif value="30">30 DE CADA MES</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-static">Facturas vencidas (Suspensión automatica)</label>
                                        <select name="facturas_vencidas" class="form-control selectpicker" data-style="btn btn-link" data-title="Elija una opción" id="facturas_vencidas" data-live-search="true" data-size="6">
                                            <option @if($agency->facturas_vencidas == 1) selected @endif value="1">1 FACTURA</option>
                                            <option @if($agency->facturas_vencidas == 2) selected @endif value="2">2 FACTURAS</option>
                                            <option @if($agency->facturas_vencidas == 3) selected @endif value="3">3 FACTURAS</option>
                                            <option @if($agency->facturas_vencidas == 4) selected @endif value="4">4 FACTURAS</option>
                                            <option @if($agency->facturas_vencidas == 5) selected @endif value="5">5 FACTURAS</option>
                                            <option @if($agency->facturas_vencidas == 6) selected @endif value="6">6 FACTURAS</option>
                                            <option @if($agency->facturas_vencidas == 7) selected @endif value="7">7 FACTURAS</option>
                                            <option @if($agency->facturas_vencidas == 8) selected @endif value="8">8 FACTURAS</option>
                                            <option @if($agency->facturas_vencidas == 9) selected @endif value="9">9 FACTURAS</option>
                                            <option @if($agency->facturas_vencidas == 10) selected @endif value="10">10 FACTURAS</option>
                                            <option @if($agency->facturas_vencidas == 11) selected @endif value="11">11 FACTURAS</option>
                                            <option @if($agency->facturas_vencidas == 12) selected @endif value="12">12 FACTURAS</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="estado" class="bmd-label-static">Estado Agencia</label>
                                        <select name="estado" id="estado" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir Estado">
                                            <option selected value="{{ $agency->estado }}">{{ strtoupper($agency->estado) }}</option>
                                            @if ($agency->estado == "activo") {
                                            <option value="inactivo">INACTIVO</option>
                                            @else
                                                <option value="activo">ACTIVO</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="codigo_abonado_personalizado" @if ($agency->codigo_abonado_personalizado) checked @endif class="form-check-input">
                                            Código abonado personalizado
                                            <span class="form-check-sign">
                                            <span class="check"></span>
                                        </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <a class="btn btn-dark pull-left" href="{{ action('AgencyController@destroy', $agency_id) }}" onclick="event.preventDefault();
                                                     document.getElementById('delete-isp-form').submit();">Borrar Agencia</a>
                            <button type="submit" class="btn btn-primary pull-right">Guardar</button>
                            <div class="clearfix"></div>
                        </form>
                        <form id="delete-isp-form" action="{{ action('AgencyController@destroy', $agency_id) }}" method="POST" style="display: none;">
                            @method('DELETE')
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            var tipo_facturacion = $('#tipo_facturacion');
            var div_postpago_1 = $('#div_postpago_1');
            var div_postpago_2 = $('#div_postpago_2');

            if (tipo_facturacion.val() === 'POSTPAGO') {
                div_postpago_1.show('slow');
                div_postpago_2.show('slow');
            }

            tipo_facturacion.change(function () {
                if (tipo_facturacion.val() === 'POSTPAGO') {
                    div_postpago_1.show('slow');
                    div_postpago_2.show('slow');
                }  else {
                    div_postpago_1.hide('slow');
                    div_postpago_2.hide('slow');
                }
            });
        });
    </script>
@endsection
