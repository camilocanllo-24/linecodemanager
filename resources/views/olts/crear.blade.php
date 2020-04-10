@extends('layouts.base')
@section('titulo-pagina', 'Crear OLT')
@section('breadcrumb')
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/olts') }}">OLT's</a></li>
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
                        <h4 class="card-title">Crear OLT</h4>
                        <p class="card-category">Complete el formulario</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('olts.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Identificador</label>
                                        <input style="text-transform:uppercase;" type="text" name="identificador" class="form-control" required autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="marca" class="bmd-label-static">Marca</label>
                                        <select name="marca" id="marca" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir Marca" required>
                                            <option value="PREVAIL">PREVAIL</option>
                                            <option value="HUAWEI">HUAWEI</option>
                                            <option value="CDATA">C-DATA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="modelo" class="bmd-label-static">Modelo</label>
                                        <select name="modelo" id="modelo" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir Modelo" required>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">IP</label>
                                        <input type="text" name="ip" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Puerto</label>
                                        <input type="number" name="puerto" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Usuario</label>
                                        <input type="text" name="username" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Contraseña</label>
                                        <input type="text" name="password" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="agency" class="bmd-label-static">Agencia</label>
                                        <select name="agency" id="agency" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir Agencia">
                                            @foreach($agencies as $agency)
                                                <option value="{{ $agency->id }}">{{ $agency->isp->nombre }} - Sede: {{ $agency->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-static">Estado</label>
                                        <select name="estado" id="estado" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir Estado" required>
                                            <option value="activo">ACTIVO</option>
                                            <option value="inactivo">INACTIVO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary pull-right">Crear OLT</button>
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
            var marca = $('#marca');
            var modelo = $('#modelo');
            marca.change(function () {
                if (marca.val() === 'PREVAIL') {
                    modelo.children('option').remove();
                    modelo.append($("<option />").val('SIDITEL-8P').text('SIDITEL 8P'));
                    modelo.append($("<option />").val('SIDITEL-16P').text('SIDITEL 16P'));
                    modelo.selectpicker('refresh');
                } else if (marca.val() === 'HUAWEI') {
                    modelo.children('option').remove();
                    modelo.append($("<option />").val('MA5608T').text('MA5608T'));
                    modelo.selectpicker('refresh');
                } else if (marca.val() === 'CDATA') {
                    modelo.children('option').remove();
                    modelo.selectpicker('refresh');
                }
            });
        });
    </script>
@endsection
