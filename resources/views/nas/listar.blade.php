@extends('layouts.base')
@section('titulo-pagina', 'Nas')
@section('breadcrumb')
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">NAS</li>
        </ol>
    </nav>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">Listado NAS</h4>
                    <p class="card-category"></p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <span class="table-add float-right mb-3 mr-2"><a href="{{ route('nas.create') }}" class="text-success"><i
                                        class="material-icons purple400 md-36">add</i></a></span>
                        <table class="table">
                            <thead class=" text-primary">
                            <tr>
                                <th>ID</th>
                                <th>Identificador</th>
                                <th>IP</th>
                                <th>Puerto</th>
                                <th>Secret</th>
                                <th>ISP</th>
                                <th>Agencia</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr></thead>
                            <tbody>
                            @foreach ($nas as $nasObj)
                                <tr>
                                    <td>{{ $nasObj->id }}</td>
                                    <td>{{ $nasObj->identificador }}</td>
                                    <td>{{ $nasObj->ip }}</td>
                                    <td>{{ $nasObj->puerto }}</td>
                                    <td>{{ $nasObj->secret }}</td>
                                    <td>{{ $nasObj->agency->isp->nombre }}</td>
                                    <td>{{ $nasObj->agency->nombre }}</td>
                                    @if ($nasObj->estado == 1)
                                        <td>ACTIVO</td>
                                    @else
                                        <td>INACTIVO</td>
                                    @endif
                                    <td><span class="table-remove">
                                            <a class="btn btn-dark btn-rounded btn-sm my-0"
                                                        href="{{ action('NasController@edit', $nasObj->id) }}">Ver</a>
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
