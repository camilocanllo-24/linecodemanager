@extends('layouts.base')
@section('titulo-pagina', 'Editar NAS')
@section('breadcrumb')
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/nas') }}">Nas</a></li>
            <li class="breadcrumb-item"><a href="{{ route('nas.edit', $nas->id) }}">{{ $nas->identificador }}</a></li>
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
                        <h4 class="card-title">Editar NAS</h4>
                        <p class="card-category">Complete el formulario</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ action('NasController@update', $nas_id) }}" method="post">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Identificador</label>
                                        <input style="text-transform:uppercase;" type="text" name="identificador" value="{{ $nas->identificador }}" class="form-control" required autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">IP</label>
                                        <input type="text" name="ip" value="{{ $nas->ip }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Puerto</label>
                                        <input type="number" name="puerto" value="{{ $nas->puerto }}" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Secret</label>
                                        <input type="text" name="secret" value="{{ $nas->secret }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="agencia" class="bmd-label-static">Agencia</label>
                                        <select name="agencia" id="agencia" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir Agencia">
                                            <option selected value="{{ $nas->agency_id }}">{{ $nas->agency->isp->nombre }} - SEDE: {{ strtoupper($nas->agency->nombre) }}</option>
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
                                            @if ($nas->estado == 1) {
                                                <option value="Activo" selected>ACTIVO</option>
                                                <option value="Inactivo">INACTIVO</option>
                                            @else
                                                <option value="Inactivo" selected>INACTIVO</option>
                                                <option value="Activo">ACTIVO</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <a class="btn btn-dark pull-left {{ ($nas->rol == 'superadmin') ? 'disabled' : '' }}" href="{{ action('NasController@destroy', $nas_id) }}"
                               onclick="event.preventDefault(); document.getElementById('delete-user-form').submit();">Borrar NAS</a>
                            <button type="submit" class="btn btn-primary pull-right">Guardar</button>
                            <div class="clearfix"></div>
                        </form>
                        <form id="delete-user-form" action="{{ action('NasController@destroy', $nas_id) }}" method="POST" style="display: none;">
                            @method('DELETE')
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
