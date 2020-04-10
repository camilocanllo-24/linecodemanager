@extends('layouts.base')
@section('titulo-pagina', 'Crear NAS')
@section('breadcrumb')
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/nas') }}">NAS</a></li>
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
                        <h4 class="card-title">Crear NAS</h4>
                        <p class="card-category">Complete el formulario</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('nas.store') }}" method="post">
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
                                        <label class="label-control">IP</label>
                                        <input type="text" name="ip" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md 6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Puerto</label>
                                        <input type="number" name="puerto" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Secret</label>
                                        <input type="text" name="secret" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="agencia" class="bmd-label-static">Agencia</label>
                                        <select name="agencia" id="agencia" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir Agencia">
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
                                            <option value="Activo">ACTIVO</option>
                                            <option value="Inactivo">INACTIVO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary pull-right">Crear NAS</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
