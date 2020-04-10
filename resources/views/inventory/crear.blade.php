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
                        <h4 class="card-title">Registro de materiales</h4>
                        <p class="card-category">Complete el formulario</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('materials.store') }}" method="post">
                            @csrf

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
                            </div>
                             <div class="row">

                                 <div class="col-md-6">
                                     <div class="form-group bmd-form-group">
                                         <label class="label-control">Mac</label>
                                         <input type="text" style="text-transform:uppercase;" name="mac" class="form-control">
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group bmd-form-group">
                                         <label class="label-control">Serial</label>
                                         <input type="text" style="text-transform:uppercase;" name="serial" class="form-control">
                                     </div>
                                 </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Metraje</label>
                                        <input type="number" style="text-transform:uppercase;" name="metraje" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Cantidad</label>
                                        <input type="number" style="text-transform:uppercase;" name="cantidad" class="form-control" required>
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
