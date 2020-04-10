@extends('layouts.base')
@section('titulo-pagina', 'Crear Servicio')
@section('breadcrumb')
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/subscribers') }}">Abonados</a></li>
            <li class="breadcrumb-item"><a href="{{ route('subscribers.edit', $abonado->id) }}">{{ $abonado->numero_identidad }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('services.index', ['subscriber' => $abonado->id]) }}">Servicios</a></li>
            <li class="breadcrumb-item active" aria-current="page">Crear</li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">person</i>
                        </div>
                        <h4 class="card-title">Datos del Abonado</h4>
                        <p class="card-category">Complete el formulario</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Tipo de Identificación</label>
                                    <input type="text" class="form-control" required
                                           value="{{ $abonado->tipo_identidad }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Número de Identificación</label>
                                    <input type="text" class="form-control" required
                                           value="{{ $abonado->numero_identidad }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Primer Nombre</label>
                                    <input type="text" class="form-control" required
                                           value="{{ $abonado->primer_nombre }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Segundo Nombre</label>
                                    <input type="text" class="form-control" required
                                           value="{{ $abonado->segundo_nombre }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Primer Apellido</label>
                                    <input type="text" class="form-control" required
                                           value="{{ $abonado->primer_apellido }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Segundo Apellido</label>
                                    <input type="text" class="form-control" required
                                           value="{{ $abonado->segundo_apellido }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Dirección</label>
                                    <input type="text" class="form-control"
                                           value="{{ $abonado->direccion }}" disabled>
                                </div>
                            </div>
                            <div class="col-md 6">
                                <div class="form-group bmd-form-group">
                                    <label class="label-control">Teléfono</label>
                                    <input type="number" class="form-control"
                                           value="{{ $abonado->telefono }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">tv</i>
                        </div>
                        <h4 class="card-title">Datos del Servicio</h4>
                        <p class="card-category">Complete el formulario</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('services.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="abonado_id" value="{{ $abonado->id }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Dirección</label>
                                        <input type="text" style="text-transform:uppercase;" name="direccion" class="form-control" required autofocus>
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
                                        <label class="label-control">Fecha subscripción</label>
                                        <input type="text" name="fecha_subscripcion" class="form-control datepicker" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="plan" class="bmd-label-static">Plan</label>
                                        <select name="plan_id" id="plan" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir Plan">
                                            @foreach($planes as $plan)
                                                @if ($plan->solo_tv)
                                                <option value="{{ $plan->id }}">{{ $plan->nombre }}: $ {{ $plan->formatted_precio_tv }}</option>
                                                @else
                                                <option value="{{ $plan->id }}">{{ $plan->nombre }} - {{ $plan->tasa_descarga }}Mb/{{ $plan->tasa_subida }}Mb: $ {{ $plan->formatted_precio_internet }}@if ($plan->tv) - Incluye TV: $ {{ $plan->formatted_precio_tv }} @endif</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{--<div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Fecha instalación</label>
                                        <input type="text" name="fecha_instalacion" class="form-control datepicker" required>
                                    </div>
                                </div>--}}
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Fecha y hora estimada de inicio de instalación</label>
                                        <input type="text" name="fecha_estimada_inicio" class="form-control datetimepicker" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Fecha y hora estimada de fin de instalación</label>
                                        <input type="text" name="fecha_estimada_cierre" class="form-control datetimepicker" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="ultima_milla" class="bmd-label-static">Última milla</label>
                                        <select name="ultima_milla" id="ultima_milla" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir una tecnología">
                                            <option value="SIN DEFINIR">SIN DEFINIR</option>
                                            <option value="GPON">GPON</option>
                                            <option value="EOC">EOC</option>
                                            <option value="METRO">METRO ETHERNET</option>
                                            <option value="INALAMBRICO">INALÁMBRICO</option>
                                            <option value="DOCSIS">DOCSIS</option>
                                            <option value="CATV">CATV</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-static">Instalador</label>
                                        <select name="usuario_asignado_id" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir un usuario">
                                            <option value="SIN DEFINIR">SIN DEFINIR</option>
                                            @foreach($usuarios as $usuario)
                                                <option value="{{$usuario->id}}">{{ $usuario->nombres }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary pull-right">Crear Servicio</button>
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
        md.initFormExtendedDatetimepickers();
        if ($('.slider').length != 0) {
            md.initSliders();
        }
    </script>
@endsection
