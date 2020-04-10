@extends('layouts.base')
@section('titulo-pagina', 'Editar OLT')
@section('breadcrumb')
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/olts') }}">OLT's</a></li>
            <li class="breadcrumb-item"><a href="{{ route('olts.edit', $olt->id) }}">{{ $olt->identificador }}</a></li>
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
                        <h4 class="card-title">Editar OLT</h4>
                        <p class="card-category">Complete el formulario</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ action('OltController@update', $olt_id) }}" method="post">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Identificador</label>
                                        <input style="text-transform:uppercase;" type="text" name="identificador" value="{{ $olt->identificador }}" class="form-control" required autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Marca</label>
                                        <input type="text" name="marca_placeholder" value="{{ $olt->marca }}" class="form-control" disabled>
                                        <input type="hidden" name="marca" value="{{ $olt->marca }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Modelo</label>
                                        <input type="text" name="modelo_placeholder" value="{{$olt->modelo}}" class="form-control" disabled>
                                        <input type="hidden" name="modelo" value="{{ $olt->modelo }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">IP</label>
                                        <input type="text" name="ip" value="{{ $olt->ip }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Puerto</label>
                                        <input type="number" name="puerto" value="{{ $olt->puerto }}" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="username" class="label-control">Usuario</label>
                                        <input type="text" id="username" name="username" value="{{ $olt->username }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Contraseña</label>
                                        <input type="text" name="password" value="{{ $olt->password }}" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="agency" class="bmd-label-static">Agencia</label>
                                        <select name="agency" id="agency" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir Agencia">
                                            <option selected value="{{ $olt->agency_id }}">{{ $olt->agency->isp->nombre }} - SEDE: {{ strtoupper($olt->agency->nombre) }}</option>
                                            @foreach($agencies as $agency)
                                                <option value="{{ $agency->id }}">{{ $agency->isp->nombre }} - SEDE: {{ strtoupper($agency->nombre) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="estado" class="bmd-label-static">Estado</label>
                                        <select name="estado" id="estado" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir Estado">
                                            @if ($olt->estado === 'activo') {
                                                <option value="activo" selected>ACTIVO</option>
                                                <option value="inactivo">INACTIVO</option>
                                            @else
                                                <option value="inactivo" selected>INACTIVO</option>
                                                <option value="activo">ACTIVO</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <a class="btn btn-dark pull-left {{ ($olt->rol == 'superadmin') ? 'disabled' : '' }}" href="{{ action('OltController@destroy', $olt_id) }}"
                               onclick="event.preventDefault(); document.getElementById('delete-user-form').submit();">Borrar OLT</a>
                            <button type="submit" class="btn btn-primary pull-right">Guardar</button>
                            <div class="clearfix"></div>
                        </form>
                        <form id="delete-user-form" action="{{ action('OltController@destroy', $olt_id) }}" method="POST" style="display: none;">
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
