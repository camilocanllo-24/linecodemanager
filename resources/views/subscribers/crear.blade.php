@extends('layouts.base')
@section('titulo-pagina', 'Crear Abonados')
@section('breadcrumb')
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/subscribers') }}">Abonados</a></li>
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
                        <h4 class="card-title">Crear Abonados</h4>
                        <p class="card-category">Complete el formulario</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('subscribers.store') }}" method="post">
                            @csrf
                            @if (Auth::user()->agency->codigo_abonado_personalizado || (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin()))
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Código abonado</label>
                                        <input type="text" name="codigo_abonado_personalizado" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control" >Primer nombre</label>
                                        <input type="text" style="text-transform:uppercase;" name="primer_nombre" class="form-control" required autofocus>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Segundo nombre</label>
                                        <input type="text" style="text-transform:uppercase;" name="segundo_nombre" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Primer apellido</label>
                                        <input type="text" style="text-transform:uppercase;" name="primer_apellido" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Segundo apellido</label>
                                        <input type="text" style="text-transform:uppercase;" name="segundo_apellido" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-static">Tipo de identificación</label>
                                        <select name="tipo_identidad" id="tipo_identidad" data-style="btn btn-link" data-title="Elija una opción" class="form-control selectpicker" required>
                                            <option value="CC">CÉDULA DE CIUDADANÍA</option>
                                            <option value="CE">CÉDULA DE EXTRANJERÍA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Número de identificación</label>
                                        <input type="number" name="numero_identidad" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Fecha nacimiento</label>
                                        <input type="text" name="fecha_nacimiento" class="form-control datepicker" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Teléfono</label>
                                        <input type="text" name="telefono" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Email</label>
                                        <input type="email" style="text-transform:uppercase;" name="email" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Dirección</label>
                                        <input type="text" style="text-transform:uppercase;" name="direccion" class="form-control" required>
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
                                                    <option value="{{ $agency->id }}">{{ $agency->isp->nombre }} - Sede {{ $agency->nombre }}</option>
                                                @endforeach
                                            </select>
                                        @elseif (Auth::user()->rol === 'admin')
                                                <label class="bmd-label-static">Agencia</label>
                                                <select name="agencia" id="agencia" class="form-control selectpicker" data-style="btn btn-link" data-size="7" data-title="Elegir Agencia">
                                                @foreach($agencies as $agency)
                                                    @if ($agency->isp->id === Auth::user()->agency->isp->id)
                                                        <option value="{{ $agency->id }}">{{ $agency->isp->nombre }} - Sede {{ $agency->nombre }}</option>
                                                    @endif
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
                                        <select name="estado" id="estado" class="form-control selectpicker" data-style="btn btn-link" data-size="2" data-title="Elegir Estado" required>
                                            <option value="Activo">ACTIVO</option>
                                            <option value="Inactivo">INACTIVO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary pull-right">Crear Abonado</button>
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
        $(document).ready(function() {
            // initialise Datetimepicker and Sliders
            md.initFormExtendedDatetimepickers();
            if ($('.slider').length != 0) {
                md.initSliders();
            }
        });
    </script>
@endsection
