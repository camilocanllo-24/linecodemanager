@extends('layouts.base')
@section('titulo-pagina', 'Agencias')
@section('breadcrumb')
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Agencias</li>
        </ol>
    </nav>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">Listado Agencias</h4>
                    <p class="card-category"></p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <span class="table-add float-right mb-3 mr-2"><a href="{{ route('agencies.create') }}" class="text-success"><i
                                        class="material-icons purple400 md-36">add</i></a></span>
                        <table class="table">
                            <thead class=" text-primary">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>ISP</th>
                                <th>Municipio</th>
                                <th>Teléfono</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr></thead>
                            <tbody>
                            @foreach ($agencies as $agency)
                                <tr>
                                    <td>{{ $agency->id }}</td>
                                    <td>{{ strtoupper($agency->nombre) }}</td>
                                    <td>{{ $agency->isp->nombre }}</td>
                                    <td>{{ strtoupper($agency->municipio) }}</td>
                                    <td>{{ $agency->telefono }}</td>
                                    <td>{{ strtoupper($agency->estado) }}</td>
                                    <td><span class="table-remove">
                                            <a class="btn btn-dark btn-rounded btn-sm my-0"
                                                        href="{{ action('AgencyController@edit', $agency->id) }}">Ver</a>
                                        </span></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
