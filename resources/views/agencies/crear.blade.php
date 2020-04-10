@extends('layouts.base')
@section('titulo-pagina', 'Crear Agencia')
@section('breadcrumb')
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/agencies') }}">Agencias</a></li>
            <li class="breadcrumb-item active" aria-current="page">Nueva</li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Crear Agencia</h4>
                        <p class="card-category">Complete el formulario</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('agencies.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Nombre</label>
                                        <input style="text-transform:uppercase;" type="text" name="nombre" class="form-control" required autofocus>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Dirección</label>
                                        <input style="text-transform:uppercase;" type="text" name="direccion" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Contacto</label>
                                        <input style="text-transform:uppercase;" type="text" name="contacto" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Email</label>
                                        <input style="text-transform:uppercase;" type="text" name="email" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Teléfono</label>
                                        <input type="text" name="telefono" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Ciudad/Municipio</label>
                                        <input style="text-transform:uppercase;" type="text" name="municipio" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="agencia" class="bmd-label-static">ISP</label>
                                        <select name="isp" id="isp" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir ISP" required>
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
                                            <option value="PREPAGO">PREPAGO</option>
                                            <option value="POSTPAGO">POSTPAGO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="div_postpago_1" style="display: none;">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-static">Dia de facturación</label>
                                        <select name="dia_facturacion" class="form-control selectpicker" data-style="btn btn-link" data-title="Elija una opción" id="dia_facturacion" data-live-search="true" data-size="6">
                                            <option value="1">1 de cada mes</option>
                                            <option value="2">2 de cada mes</option>
                                            <option value="3">3 de cada mes</option>
                                            <option value="4">4 de cada mes</option>
                                            <option value="5">5 de cada mes</option>
                                            <option value="6">6 de cada mes</option>
                                            <option value="7">7 de cada mes</option>
                                            <option value="8">8 de cada mes</option>
                                            <option value="9">9 de cada mes</option>
                                            <option value="10">10 de cada mes</option>
                                            <option value="11">11 de cada mes</option>
                                            <option value="12">12 de cada mes</option>
                                            <option value="13">13 de cada mes</option>
                                            <option value="14">14 de cada mes</option>
                                            <option value="15">15 de cada mes</option>
                                            <option value="16">16 de cada mes</option>
                                            <option value="17">17 de cada mes</option>
                                            <option value="18">18 de cada mes</option>
                                            <option value="19">19 de cada mes</option>
                                            <option value="20">20 de cada mes</option>
                                            <option value="21">21 de cada mes</option>
                                            <option value="22">22 de cada mes</option>
                                            <option value="23">23 de cada mes</option>
                                            <option value="24">24 de cada mes</option>
                                            <option value="25">25 de cada mes</option>
                                            <option value="26">26 de cada mes</option>
                                            <option value="27">27 de cada mes</option>
                                            <option value="28">28 de cada mes</option>
                                            <option value="29">29 de cada mes</option>
                                            <option value="30">30 de cada mes</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-static">Dia de pago</label>
                                        <select name="dia_pago" class="form-control selectpicker" data-style="btn btn-link" data-title="Elija una opción" id="dia_pago" data-live-search="true" data-size="6">
                                            <option value="1">1 de cada mes</option>
                                            <option value="2">2 de cada mes</option>
                                            <option value="3">3 de cada mes</option>
                                            <option value="4">4 de cada mes</option>
                                            <option value="5">5 de cada mes</option>
                                            <option value="6">6 de cada mes</option>
                                            <option value="7">7 de cada mes</option>
                                            <option value="8">8 de cada mes</option>
                                            <option value="9">9 de cada mes</option>
                                            <option value="10">10 de cada mes</option>
                                            <option value="11">11 de cada mes</option>
                                            <option value="12">12 de cada mes</option>
                                            <option value="13">13 de cada mes</option>
                                            <option value="14">14 de cada mes</option>
                                            <option value="15">15 de cada mes</option>
                                            <option value="16">16 de cada mes</option>
                                            <option value="17">17 de cada mes</option>
                                            <option value="18">18 de cada mes</option>
                                            <option value="19">19 de cada mes</option>
                                            <option value="20">20 de cada mes</option>
                                            <option value="21">21 de cada mes</option>
                                            <option value="22">22 de cada mes</option>
                                            <option value="23">23 de cada mes</option>
                                            <option value="24">24 de cada mes</option>
                                            <option value="25">25 de cada mes</option>
                                            <option value="26">26 de cada mes</option>
                                            <option value="27">27 de cada mes</option>
                                            <option value="28">28 de cada mes</option>
                                            <option value="29">29 de cada mes</option>
                                            <option value="30">30 de cada mes</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="div_postpago_2" style="display: none;">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-static">Dia de corte</label>
                                        <select name="dia_corte" class="form-control selectpicker" data-style="btn btn-link" data-title="Elija una opción" id="dia_corte" data-live-search="true" data-size="6">
                                            <option value="1">1 de cada mes</option>
                                            <option value="2">2 de cada mes</option>
                                            <option value="3">3 de cada mes</option>
                                            <option value="4">4 de cada mes</option>
                                            <option value="5">5 de cada mes</option>
                                            <option value="6">6 de cada mes</option>
                                            <option value="7">7 de cada mes</option>
                                            <option value="8">8 de cada mes</option>
                                            <option value="9">9 de cada mes</option>
                                            <option value="10">10 de cada mes</option>
                                            <option value="11">11 de cada mes</option>
                                            <option value="12">12 de cada mes</option>
                                            <option value="13">13 de cada mes</option>
                                            <option value="14">14 de cada mes</option>
                                            <option value="15">15 de cada mes</option>
                                            <option value="16">16 de cada mes</option>
                                            <option value="17">17 de cada mes</option>
                                            <option value="18">18 de cada mes</option>
                                            <option value="19">19 de cada mes</option>
                                            <option value="20">20 de cada mes</option>
                                            <option value="21">21 de cada mes</option>
                                            <option value="22">22 de cada mes</option>
                                            <option value="23">23 de cada mes</option>
                                            <option value="24">24 de cada mes</option>
                                            <option value="25">25 de cada mes</option>
                                            <option value="26">26 de cada mes</option>
                                            <option value="27">27 de cada mes</option>
                                            <option value="28">28 de cada mes</option>
                                            <option value="29">29 de cada mes</option>
                                            <option value="30">30 de cada mes</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-static">Facturas vencidas (Suspensión automatica)</label>
                                        <select name="facturas_vencidas" class="form-control selectpicker" data-style="btn btn-link" data-title="Elija una opción" id="facturas_vencidas" data-live-search="true" data-size="6">
                                            <option value="1">1 FACTURA</option>
                                            <option value="2">2 FACTURAS</option>
                                            <option value="3">3 FACTURAS</option>
                                            <option value="4">4 FACTURAS</option>
                                            <option value="5">5 FACTURAS</option>
                                            <option value="6">6 FACTURAS</option>
                                            <option value="7">7 FACTURAS</option>
                                            <option value="8">8 FACTURAS</option>
                                            <option value="9">9 FACTURAS</option>
                                            <option value="10">10 FACTURAS</option>
                                            <option value="11">11 FACTURAS</option>
                                            <option value="12">12 FACTURAS</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="codigo_abonado_personalizado" class="form-check-input">
                                            Código abonado personalizado
                                            <span class="form-check-sign">
                                            <span class="check"></span>
                                        </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary pull-right">Crear Agencia</button>
                            <div class="clearfix"></div>
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
