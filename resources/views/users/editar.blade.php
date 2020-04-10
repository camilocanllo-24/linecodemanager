@extends('layouts.base')
@section('titulo-pagina', 'Editar Usuario')
@section('breadcrumb')
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-dark">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/users') }}">Usuarios</a></li>
            <li class="breadcrumb-item"><a href="{{ route('users.edit', $usuario->id) }}">{{ $usuario->nombres }}</a></li>
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
                        <h4 class="card-title">Editar Usuario</h4>
                        <p class="card-category">Complete el formulario</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ action('UserController@update', $usuario_id) }}" method="post">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Nombres</label>
                                        <input type="text" name="nombres" style="text-transform:uppercase;" value="{{ $usuario->nombres }}" class="form-control" required autofocus>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Email</label>
                                        <input type="email" name="email" style="text-transform:uppercase;" value="{{ $usuario->email }}" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Contraseña</label>
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-static">Rol</label>
                                        <select name="rol" id="" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir Rol">
                                            @if (Auth::user()->id == $usuario->id)
                                                <option value="{{ $usuario->rol }}" selected>{{ strtoupper($usuario->rol) }}</option>
                                            @elseif (Auth::user()->isSuperAdmin())
                                                <option @if ($usuario->rol === 'superadmin') selected @endif value="superadmin">SUPERADMIN</option>
                                                <option @if ($usuario->rol === 'admin') selected @endif value="admin">ADMINISTRADOR</option>
                                                <option @if ($usuario->rol === 'operador') selected @endif value="operador">OPERADOR</option>
                                                <option @if ($usuario->rol === 'cajero') selected @endif value="cajero">CAJERO</option>
                                                <option @if ($usuario->rol === 'tecnico') selected @endif value="tecnico">TECNICO</option>
                                            @elseif (Auth::user()->isAdmin() && $usuario->isOperador())
                                                <option @if ($usuario->rol === 'operador') selected @endif value="operador">OPERADOR</option>
                                            @elseif (Auth::user()->isAdmin() && $usuario->isCajero())
                                                <option @if ($usuario->rol === 'cajero') selected @endif value="cajero">CAJERO</option>
                                            @elseif (Auth::user()->isAdmin() && $usuario->isTecnico())
                                                <option @if ($usuario->rol === 'tecnico') selected @endif value="tecnico">TECNICO</option>
                                            @elseif (Auth::user()->isAdmin() && $usuario->isAdmin())
                                                <option @if ($usuario->rol === 'admin') selected @endif value="admin">ADMINISTRADOR</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="isp" class="bmd-label-static">Agencia</label>
                                        @if (Auth::user()->isSuperAdmin())
                                            <select name="agencia" id="agencia" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir Agencia">
                                                <option selected value="{{ $usuario->agency_id }}">{{ $usuario->agency->isp->nombre }} - SEDE: {{ strtoupper($usuario->agency->nombre) }}</option>
                                                @foreach($agencies as $agency)
                                                    <option value="{{ $agency->id }}">{{ $agency->isp->nombre }} - SEDE: {{ strtoupper($agency->nombre) }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <select id="agencia" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir Agencia" disabled>
                                                <option selected value="{{ Auth::user()->agency->id }}">{{ strtoupper(Auth::user()->agency->nombre) }}</option>
                                            </select>
                                            <input type="hidden" name="agencia" value="{{ Auth::user()->agency->id }}">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="estado" class="bmd-label-static">Estado Usuario</label>
                                        @if (Auth::user()->rol == 'superadmin')
                                            <select name="estado" id="estado" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir Estado">
                                                <option selected value="{{ $usuario->estado }}">{{ strtoupper($usuario->estado) }}</option>
                                                @if ($usuario->estado == "Activo") {
                                                    <option value="Inactivo">INACTIVO</option>
                                                @else
                                                    <option value="Activo">ACTIVO</option>
                                                @endif
                                            </select>
                                        @else
                                            <select id="estado" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir Estado" disabled>
                                                <option selected value="{{ $usuario->estado }}">{{ strtoupper($usuario->estado) }}</option>
                                            </select>
                                            <input type="hidden" name="estado" value="{{ $usuario->estado }}">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <a class="btn btn-dark pull-left {{ ($usuario->rol == 'superadmin') ? 'disabled' : '' }}" href="{{ action('UserController@destroy', $usuario_id) }}"
                               onclick="event.preventDefault(); document.getElementById('delete-user-form').submit();">Borrar Usuario</a>
                            <button type="submit" class="btn btn-primary pull-right">Guardar</button>
                            <div class="clearfix"></div>
                        </form>
                        <form id="delete-user-form" action="{{ action('UserController@destroy', $usuario_id) }}" method="POST" style="display: none;">
                            @method('DELETE')
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
