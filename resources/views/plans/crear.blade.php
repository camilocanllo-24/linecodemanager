@extends('layouts.base')
@section('titulo-pagina', 'Crear Plan')
@section('breadcrumb')
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/plans') }}">Planes</a></li>
            <li class="breadcrumb-item active" aria-current="page">Crear</li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Crear Plan</h4>
                        <p class="card-category">Complete el formulario</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('plans.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Nombre</label>
                                        <input type="text" style="text-transform:uppercase;" name="nombre" class="form-control" required autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Velocidad de Descarga (Mbps)</label>
                                        <input type="number" name="tasa_descarga" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md 6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Velocidad de Subida (Mbps)</label>
                                        <input type="number" name="tasa_subida" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Valor Tarifa de Internet</label>
                                        <input type="number" name="precio_internet" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="precio_tv" class="label-control">Valor Tarifa de TV</label>
                                        <input type="number" id="precio_tv" name="precio_tv" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        @if (Auth::user()->rol == 'superadmin')
                                            <label class="bmd-label-static">Agencia</label>
                                            <select name="agencia" id="agencia" class="form-control selectpicker" data-style="btn btn-link" data-size="7" data-title="Elegir Agencia">
                                                @foreach($agencies as $agency)
                                                    <option value="{{ $agency->id }}">{{ $agency->isp->nombre }} - SEDE {{ $agency->nombre }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <label for="agencia" class="label-control">Agencia</label>
                                            <input type="text" id="agencia" name="agencia" value="{{ Auth::user()->agency->nombre }}" class="form-control" required disabled>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="estado" class="bmd-label-static">Estado</label>
                                        <select name="estado" id="estado" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir Estado" required>
                                            <option value="Activo">ACTIVO</option>
                                            <option value="Inactivo">INACTIVO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="tv_box" style="display: none">
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" id="tv_checkbox" name="tv" class="form-check-input">
                                            Incluye TV
                                            <span class="form-check-sign">
                                            <span class="check"></span>
                                        </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary pull-right">Crear Plan</button>
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
            var precio_tv = $('#precio_tv');
            var tv_checkbox = $('#tv_checkbox');
            var tv_div = $('#tv_box');

            precio_tv.change(function () {
               if (precio_tv.val() !== '') {
                   tv_div.show();
                   tv_checkbox.attr('checked', true);
               } else if (precio_tv.val() === '') {
                   tv_checkbox.attr('checked', false);
                   tv_div.hide();
               }
            });
        });
    </script>
@endsection
