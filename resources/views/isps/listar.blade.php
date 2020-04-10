@extends('layouts.base')
@section('titulo-pagina', 'ISPs')
@section('breadcrumb')
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">ISPs</li>
        </ol>
    </nav>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">Listado ISPs</h4>
                    <p class="card-category"></p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <span class="table-add float-right mb-3 mr-2"><a href="{{ route('isps.create') }}" class="text-success"><i
                                        class="material-icons purple400 md-36">add</i></a></span>
                        <table class="table">
                            <thead class=" text-primary">
                            <tr>
                                <th>ID</th>
                                <th>NIT</th>
                                <th>Razón social</th>
                                <th>Municipio</th>
                                <th>Teléfono</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr></thead>
                            <tbody>
                            @foreach ($isps as $isp)
                                <tr>
                                    <td>{{ $isp->id }}</td>
                                    <td>{{ $isp->nit }}</td>
                                    <td>{{ $isp->nombre }}</td>
                                    <td>{{ $isp->municipio }}</td>
                                    <td>{{ $isp->telefono }}</td>
                                    <td>{{ strtoupper($isp->estado) }}</td>
                                    <td><span class="table-remove">
                                            <a class="btn btn-dark btn-rounded btn-sm my-0"
                                                        href="{{ action('IspController@edit', $isp->id) }}">Ver</a>
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
