@extends('layouts.base')
@section('titulo-pagina', 'Usuarios')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">Listado Usuarios</h4>
                    <p class="card-category"></p>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <span class="table-add float-right mb-3 mr-2"><a href="{{ route('users.create') }}" class="text-success"><i
                                        class="material-icons purple400 md-36">add</i></a></span>
                        <table class="table">
                            <thead class=" text-primary">
                            <tr>
                                <th>ID</th>
                                <th>Nombres</th>
                                <th>ISP</th>
                                <th>Agencia</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr></thead>
                            <tbody>
                            @foreach ($usuarios as $usuario)
                                <tr>
                                    <td>{{ $usuario->id }}</td>
                                    <td>{{ strtoupper($usuario->nombres) }}</td>
                                    <td>{{ $usuario->agency->isp->nombre }}</td>
                                    <td>{{ strtoupper($usuario->agency->nombre) }}</td>
                                    <td>{{ strtoupper($usuario->email) }}</td>
                                    <td>{{ strtoupper($usuario->rol) }}</td>
                                    <td>{{ strtoupper($usuario->estado) }}</td>
                                    <td><span class="table-remove">
                                            <a class="btn btn-dark btn-rounded btn-sm my-0"
                                                        href="{{ action('UserController@edit', $usuario->id) }}">Ver</a>
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
