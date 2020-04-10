@extends('layouts.base')
@section('titulo-pagina', 'Crear Plan')
@section('breadcrumb')
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/products') }}">Productos</a></li>
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
                        <h4 class="card-title">Crear Producto</h4>
                        <p class="card-category">Complete el formulario</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Codigo Barras</label>
                                        <input type="number" style="text-transform:uppercase;" name="codigo_barras" class="form-control" required autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Descripcion</label>
                                        <input type="text" name="descripcion" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md 6">
                                    <div class="form-group bmd-form-group">
                                        <label class="label-control">Marca</label>
                                        <input type="text" name="marca" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group bmd-form-group">
                                        <label for="precio_cj_dp" class="label-control">Precio caja, display, paca</label>
                                        <input type="text" id="number" name="precio_cj_dp" class="form-control" required checked>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group bmd-form-group">
                                        <label for="precio_und" class="label-control">Precio unidad</label>
                                        <input type="text" id="number1"  name="precio_und" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group bmd-form-group">
                                        <label for="precio_venta" class="label-control">Precio venta</label>
                                        <input type="text" id="number2" name="precio_venta" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group bmd-form-group">
                                        <label for="cantidad_actual" class="label-control">Cantidad</label>
                                        <input type="text" onkeyup="format(this)" onchange="format(this)" name="cantidad_actual" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label for="utilidad" class="label-control">Utilidad</label>
                                        <input type="text" id="number3" name="utilidad" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Imagen</label>
                                    <input type="file" name="imagen" class="">
                                </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                            <label class="bmd-label-static">Categoria</label>
                                            <select name="id_categoria" id="id_categoria" class="form-control selectpicker" data-style="btn btn-link" data-size="7" data-title="Elegir Agencia">
                                                @foreach($id_categoria as $categorias)
                                                    <option value="{{ $categorias->id }}">{{ $categorias->descripcion }}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-static">Iva</label>
                                        <select name="id_iva" id="id_iva" class="form-control selectpicker" data-style="btn btn-link" data-size="7" data-title="Elegir Agencia">
                                            @foreach($id_iva as $id_ivas)
                                                <option value="{{ $id_ivas->id }}">{{ $id_ivas->descripcion }}%</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary pull-right">Crear Plan</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/jquery.priceformat.min.js') }}"></script>
    <script>
        md.initFormExtendedDatetimepickers();
        $(document).ready(function () {
            var monto = $('#number');
            monto.priceFormat({
                prefix: '$ ',
                centsSeparator: ',',
                thousandsSeparator: '.',
                clearOnEmpty: true
            });
            var monto1 = $('#number1');
                monto1.priceFormat({
                    prefix: '$ ',
                    centsSeparator: ',',
                    thousandsSeparator: '.',
                    clearOnEmpty: true
            });
            var monto2 = $('#number2');
            monto2.priceFormat({
                prefix: '$ ',
                centsSeparator: ',',
                thousandsSeparator: '.',
                clearOnEmpty: true
            });
            var monto3 = $('#number3');
            monto3.priceFormat({
                prefix: '$ ',
                centsSeparator: ',',
                thousandsSeparator: '.',
                clearOnEmpty: true
            });

        });
        function format(input)
        {
            var num = input.value.replace(/\./g,'');
            if(!isNaN(num)){
                num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
                num = num.split('').reverse().join('').replace(/^[\.]/,'');
                input.value = num;
            }

            else{ alert('Solo se permiten numeros');
                input.value = input.value.replace(/[^\d\.]*/g,'');
            }
        }
        var utilidad,
            deposito, retiro;

        function depositar() {
            deposito = parseFloat(document.getElementsByName("deposito")[0].value);

            if (isNaN(deposito)) {
                alert("El valor ingresado no es número válido");
                return;
            }

            saldo = saldo + deposito;
        }

        function retirar() {
            retiro = parseFloat(document.getElementsByName("retiro")[0].value);

            if (isNaN(retiro)) {
                alert("El valor ingresado no es número válido");
                return;
            }

            if (retiro > saldo) {
                alert("Su fondo disposible no es suficiente");
                return;
            }

            saldo = saldo - retiro;
        }

        $(document).ready(function(){
            $('#number').on('change',function(){
                if (this.checked) {
                    $("#number1").show();
                } else {
                    $("#number1").hide();
                }
            })
        });
        function verificar() {
            document.getElementsByName("verificacion")[0].value = saldo;
        }
    </script>
@endsection


