@extends('layouts.base')
@section('titulo-pagina', 'Editar Plan')
@section('breadcrumb')
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/plans') }}">Planes</a></li>
            <li class="breadcrumb-item"><a href="{{ route('plans.edit', $plan->id) }}">{{ $plan->nombre }}</a></li>
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
                        <h4 class="card-title">Editar Plan</h4>
                        <p class="card-category">Complete el formulario</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ action('PlanController@update', $plan_id) }}" method="post">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Nombre</label>
                                        <input type="text" name="nombre" value="{{ $plan->nombre }}" class="form-control" required autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Velocidad de Descarga (Mbps)</label>
                                        <input type="number" name="tasa_descarga" value="{{ $plan->tasa_descarga }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Velocidad de Subida (Mbps)</label>
                                        <input type="number" name="tasa_subida" value="{{ $plan->tasa_subida }}" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Valor Tarifa Internet</label>
                                        <input type="number" name="precio_internet" value="{{ $plan->precio_internet }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Valor Tarifa TV</label>
                                        <input type="number" name="precio_tv" id="precio_tv" value="{{ $plan->precio_tv }}" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="isp" class="bmd-label-static">ISP</label>
                                        @if (Auth::user()->isSuperAdmin())
                                            <select name="agencia" id="agencia" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir Agencia">
                                                <option selected value="{{ $plan->agency_id }}">{{ $plan->agency->isp->nombre }} - SEDE: {{ strtoupper($plan->agency->nombre) }}</option>
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
                                        <label for="estado" class="bmd-label-static">Estado</label>
                                        <select name="estado" id="estado" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir Estado">
                                            @if ($plan->estado == 1) {
                                                <option selected value="Activo">ACTIVO</option>
                                                <option value="Inactivo">INACTIVO</option>
                                            @else
                                                <option selected value="Inactivo">INACTIVO</option>
                                                <option value="Activo">ACTIVO</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="tv_box" style="display: none">
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            @if ($plan->tv)
                                            <input type="checkbox" name="tv" id="tv_checkbox" class="form-check-input" checked>
                                            Incluye TV
                                            @else
                                            <input type="checkbox" name="tv" id="tv_checkbox" class="form-check-input">
                                            Incluye TV
                                            @endif
                                            <span class="form-check-sign">
                                            <span class="check"></span>
                                        </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <a class="btn btn-dark pull-left {{ ($plan->rol == 'superadmin') ? 'disabled' : '' }}" href="{{ action('PlanController@destroy', $plan_id) }}"
                               onclick="event.preventDefault(); document.getElementById('delete-user-form').submit();">Borrar Plan</a>
                            <button type="submit" class="btn btn-primary pull-right">Guardar</button>
                            <div class="clearfix"></div>
                        </form>
                        <form id="delete-user-form" action="{{ action('PlanController@destroy', $plan_id) }}" method="POST" style="display: none;">
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
            var precio_tv = $('#precio_tv');
            var tv_checkbox = $('#tv_checkbox');
            var tv_div = $('#tv_box');

            if (precio_tv.val() !== '') {
                tv_div.show('slow');
            }

            precio_tv.on('keyup paste', function () {
                if (precio_tv.val() !== '') {
                    tv_div.show("fast");
                    tv_checkbox.attr('checked', true);
                } else {
                    tv_checkbox.attr('checked', false);
                    tv_div.hide("slow");
                }
            });
        });
    </script>
@endsection
