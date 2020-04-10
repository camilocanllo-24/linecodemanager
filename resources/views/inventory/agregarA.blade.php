@extends('layouts.base')
@section('titulo-pagina', 'Editar Abonado')
@section('breadcrumb')
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/subscribers') }}">Abonados</a></li>
            <li class="breadcrumb-item"><a href="{{ route('subscribers.edit', $abonado->id) }}">{{ $abonado->numero_identidad }}</a></li>
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
                        <h4 class="card-title">Gregar material</h4>
                        <p class="card-category">Complete el formulario</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ action('SubscriberController@update', $abonado_id) }}" method="post">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Nombre del material</label>
                                        <input type="text" style="text-transform:uppercase;" name="primer_nombre" value="{{ $abonado->primer_nombre }}" class="form-control" required autofocus>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Segundo nombre</label>
                                        <input type="text" style="text-transform:uppercase;" name="segundo_nombre" value="{{ $abonado->segundo_nombre }}" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Primer apellido</label>
                                        <input type="text" style="text-transform:uppercase;" name="primer_apellido" value="{{ $abonado->primer_apellido }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Segundo apellido</label>
                                        <input type="text" style="text-transform:uppercase;" name="segundo_apellido" value="{{ $abonado->segundo_apellido }}" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-static">Tipo de identificación</label>
                                        <select name="tipo_identidad" id="tipo_identidad" data-style="btn btn-link" data-title="Elija una opción" class="form-control selectpicker" required>
                                            <option @if ($abonado->tipo_identidad === 'CC') selected @endif value="CC">CÉDULA DE CIUDADANÍA</option>
                                            <option @if ($abonado->tipo_identidad === 'CE') selected @endif value="CE">CÉDULA DE EXTRANJERÍA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Numero de identificación</label>
                                        <input type="number" name="numero_identidad" value="{{ $abonado->numero_identidad }}" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Fecha nacimiento</label>
                                        <input type="text" name="fecha_nacimiento" value="{{ \Carbon\Carbon::createFromFormat('Y-m-d', $abonado->fecha_nacimiento)->format('d/m/Y') }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Teléfono</label>
                                        <input type="text" name="telefono" value="{{ $abonado->telefono }}" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Email</label>
                                        <input type="email" style="text-transform:uppercase;" name="email" value="{{ $abonado->email }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Dirección</label>
                                        <input type="text" style="text-transform:uppercase;" name="direccion" value="{{ $abonado->direccion }}" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="agencia" class="bmd-label-static">Agencia</label>
                                        @if (Auth::user()->isSuperAdmin())
                                            <select name="agencia" id="agencia" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir Agencia">
                                                <option selected value="{{ $abonado->agency_id }}">{{ $abonado->agency->isp->nombre }} - SEDE: {{ strtoupper($abonado->agency->nombre) }}</option>
                                                @foreach($agencies as $agency)
                                                    <option value="{{ $agency->id }}">{{ $agency->isp->nombre }} - SEDE: {{ strtoupper($agency->nombre) }}</option>
                                                @endforeach
                                            </select>
                                        @elseif (Auth::user()->isAdmin())
                                            <select name="agencia" id="agencia" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir Agencia">
                                                <option selected value="{{ $abonado->agency_id }}">{{ $abonado->agency->isp->nombre }} - SEDE: {{ strtoupper($abonado->agency->nombre) }}</option>
                                                @foreach($agencies as $agency)
                                                    @if ($agency->isp->id === Auth::user()->agency->isp->id)
                                                        <option value="{{ $agency->id }}">{{ $agency->isp->nombre }} - SEDE: {{ strtoupper($agency->nombre) }}</option>
                                                    @endif
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
                                        <select name="estado" id="estado" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir Estado">
                                            <option selected value="{{ $abonado->estado }}">{{ strtoupper($abonado->estado) }}</option>
                                            @if ($abonado->estado == "Activo") {
                                                <option value="Inactivo">INACTIVO</option>
                                            @else
                                                <option value="Activo">ACTIVO</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <a class="btn btn-dark pull-left {{ ($abonado->rol == 'superadmin') ? 'disabled' : '' }}" href="{{ action('SubscriberController@destroy', $abonado_id) }}"
                               onclick="event.preventDefault(); document.getElementById('delete-user-form').submit();">Borrar Abonado</a>
                            <button type="submit" class="btn btn-primary pull-right">Guardar</button>
                            <div class="clearfix"></div>
                        </form>
                        <form id="delete-user-form" action="{{ action('SubscriberController@destroy', $abonado_id) }}" method="POST" style="display: none;">
                            @method('DELETE')
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection