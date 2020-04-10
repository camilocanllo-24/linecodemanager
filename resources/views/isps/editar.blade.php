@extends('layouts.base')
@section('titulo-pagina', 'Editar ISP')
@section('breadcrumb')
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/isps') }}">ISPs</a></li>
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
                        <h4 class="card-title">Editar ISP</h4>
                        <p class="card-category">Complete el formulario</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ action('IspController@update', $isp_id) }}" method="post">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Razón social</label>
                                        <input style="text-transform:uppercase;" type="text" name="nombre" value="{{ $isp->nombre }}" class="form-control" required autofocus>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">NIT</label>
                                        <input type="text" name="nit" value="{{ $isp->nit }}" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Contacto</label>
                                        <input style="text-transform:uppercase;" type="text" name="contacto" value="{{ $isp->contacto }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Email</label>
                                        <input style="text-transform:uppercase;" type="text" name="email" value="{{ $isp->email }}" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Teléfono</label>
                                        <input type="text" name="telefono" value="{{ $isp->telefono }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Dirección</label>
                                        <input style="text-transform:uppercase;" type="text" name="direccion" value="{{ $isp->direccion }}" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Ciudad/Municipio</label>
                                        <input style="text-transform:uppercase;" type="text" name="municipio" value="{{ $isp->municipio }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="estado" class="bmd-label-static">Estado ISP</label>
                                        <select name="estado" id="estado" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir Estado">
                                            <option selected value="{{ $isp->estado }}">{{ strtoupper($isp->estado) }}</option>
                                            @if ($isp->estado == "Activo") {
                                                <option value="Inactivo">INACTIVO</option>
                                            @else
                                                <option value="Activo">ACTIVO</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <a class="btn btn-dark pull-left" href="{{ action('IspController@destroy', $isp_id) }}" onclick="event.preventDefault();
                                                     document.getElementById('delete-isp-form').submit();">Borrar ISP</a>
                            <button type="submit" class="btn btn-primary pull-right">Guardar</button>
                            <div class="clearfix"></div>
                        </form>
                        <form id="delete-isp-form" action="{{ action('IspController@destroy', $isp_id) }}" method="POST" style="display: none;">
                            @method('DELETE')
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
