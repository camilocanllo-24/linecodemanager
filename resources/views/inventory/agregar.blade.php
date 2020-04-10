@extends('layouts.base')
@section('titulo-pagina', 'Registrar materiales')
@section('breadcrumb')
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/materials') }}">Materiales</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar</li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Ingreso de materiales</h4>
                        <p class="card-category">Complete el formulario</p>
                    </div>
                    <div class="card-body">

                        <form action="{{ action('InventoryController@update', $material_id) }}" method="post">
                            @method('PUT')
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="isp" class="bmd-label-static">Tipo material</label>
                                        <select name="tipo_material_id" id="isp" class="form-control selectpicker" data-style="btn btn-link" data-title="Tipo material">
                                            <option selected value="{{ $Material->tipomaterial->id }}" >{{ $Material->tipomaterial->nombre }} - Marca {{ $Material->tipomaterial->marca}} - Modelo {{ $Material->tipomaterial->modelo}} - Metraje {{ $Material->tipomaterial->metraje}} </option>
                                            @foreach($Tipo_material as $tipomaterial)
                                                <option value="{{ $tipomaterial->id }}"></option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Cantidad a agregar</label>
                                        <input type="number" style="text-transform:uppercase;" name="cantidad" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Cantidad actual</label>
                                        <input name="cantidadactual" type="text" value="{{ $Material->cantidad }}"
                                               class="form-control" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @if($Material->metraje=='')
                                @else
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Metraje</label>
                                        <input type="number"  style="text-transform:uppercase;" name="metraje" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Metraje actual</label>
                                        <input name="metrajeactual" type="text" value="{{ $Material->metraje }}"
                                               class="form-control"  disabled>
                                    </div>
                                </div>
                                    @endif
                            </div>
                            <div class="row">
                                @if($Material->mac=='')
                                    @else
                                <div class="col-md-6">

                                    <div class="form-group bmd-form-group">

                                        <label class="label-control">Mac</label>
                                        <input type="text" style="text-transform:uppercase;" name="mac" value="{{ $Material->mac }}"
                                               class="form-control" disabled>
                                    </div>
                                </div>
                                @endif
                                    @if($Material->serial=='')
                                    @else
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Serial</label>
                                        <input type="text" style="text-transform:uppercase;" name="serial" value="{{ $Material->serial }}"
                                               class="form-control" disabled>
                                    </div>
                                </div>
                                        @endif
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="agencia" class="bmd-label-static">Agencia</label>
                                        @if (Auth::user()->isSuperAdmin())
                                            <select name="agencia" id="agencia" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir Agencia">
                                                <option selected value="{{ $Material->agency_id }}">{{ $Material->agency->isp->nombre }} - SEDE: {{ strtoupper($Material->agency->nombre) }}</option>
                                                @foreach($agencies as $agency)
                                                    <option value="{{ $agency->id }}">{{ $agency->isp->nombre }} - SEDE: {{ strtoupper($agency->nombre) }}</option>
                                                @endforeach
                                            </select>
                                        @elseif (Auth::user()->isAdmin())
                                            <select name="agencia" id="agencia" class="form-control selectpicker" data-style="btn btn-link" data-title="Elegir Agencia">
                                                <option selected value="{{ $Material->agency_id }}">{{ $Material->agency->isp->nombre }} - SEDE: {{ strtoupper($Material->agency->nombre) }}</option>
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
                                        <label class="label-control">Fecha ingreso a bodega</label>
                                        <input type="text" name="fecha_ingreso_bodega" class="form-control datepicker" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary pull-right">Registrar material</button>
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
