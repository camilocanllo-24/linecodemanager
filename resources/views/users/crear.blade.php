@extends('layouts.base')
@section('titulo-pagina', 'Crear Usuario')
@section('breadcrumb')
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/users') }}">Usuarios</a></li>
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
                        <h4 class="card-title">Crear Usuario</h4>
                        <p class="card-category">Complete el formulario</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('users.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Nombres</label>
                                        <input type="text" style="text-transform:uppercase;" name="nombres" class="form-control" required autofocus>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Apellidos</label>
                                        <input type="text" style="text-transform:uppercase;" name="apellidos" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Contraseña</label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Confirmar Contraseña</label>
                                        <input type="password" name="password2" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Rol</label>
                                        <select name="rol" id="" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir Rol">
                                            @if (Auth::user()->isSuperAdmin())
                                                <option value="superadmin">SUPERADMIN</option>
                                                <option value="admin">ADMINISTRADOR</option>
                                            @endif
                                            <option value="operador">OPERADOR</option>
                                            <option value="cajero">CAJERO</option>
                                            <option value="tecnico">TECNICO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Email</label>
                                        <input type="email" style="text-transform:uppercase;" name="email" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        @if (Auth::user()->rol == 'superadmin')
                                            <label for="agencia" class="bmd-label-static">Agencia</label>
                                            <select name="agencia" id="agencia" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir Agencia">
                                                @foreach($agencies as $agency)
                                                    <option value="{{ $agency->id }}">{{ $agency->isp->nombre }} - SEDE: {{ $agency->nombre }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <label for="" class="label-control">Agencia</label>
                                            <select name="agencia" id="agencia" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir Agencia">
                                                @foreach($agencies as $agency)
                                                @if ($agency->isp->id == Auth::user()->agency->isp->id)
                                                    <option value="{{ $agency->id }}">{{ $agency->isp->nombre }} SEDE: {{ $agency->nombre }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                @if (Auth::user()->rol == 'superadmin')
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="estado" class="bmd-label-static">Estado Usuario</label>
                                        <select class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir Estado"  data-size="7" name="estado" id="estado">
                                            <option value="Activo">ACTIVO</option>
                                            <option value="Inactivo">INACTIVO</option>
                                        </select>
                                    </div>
                                </div>
                                @else
                                    <input type="hidden" name="estado" value="Activo">
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary pull-right">Crear Usuario</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
