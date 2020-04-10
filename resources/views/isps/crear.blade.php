@extends('layouts.base')
@section('titulo-pagina', 'Crear ISP')
@section('breadcrumb')
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/isps') }}">ISPs</a></li>
            <li class="breadcrumb-item active" aria-current="page">Nueva</li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Crear ISP</h4>
                        <p class="card-category">Complete el formulario</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('isps.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Razón social</label>
                                        <input style="text-transform:uppercase;" type="text" name="nombre" class="form-control" required autofocus>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">NIT</label>
                                        <input type="text" name="nit" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Contacto</label>
                                        <input style="text-transform:uppercase;" type="text" name="contacto" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Email</label>
                                        <input style="text-transform:uppercase;" type="text" name="email" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Teléfono</label>
                                        <input type="text" name="telefono" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Ciudad/Municipio</label>
                                        <input style="text-transform:uppercase;" type="text" name="municipio" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Dirección</label>
                                        <input style="text-transform:uppercase;" type="text" name="direccion" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary pull-right">Crear ISP</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
