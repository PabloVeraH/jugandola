@extends('sitio')

@section('titulo')
Detalle de Factura
@stop

@section('header')
    @include('partials.sitio.header')
@stop

@section('content')
	<div class="container inicioTipo2">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2  col-sm-8 col-sm-offset-2">
                <div class="tuCuenta post-preview">
                    <!-- RIBBON 1 -->
                    <div class="containerRibbon one overPanel overTopXs">
                        <div class="bk l">
                            <div class="arrow top"></div> 
                            <div class="arrow bottom"></div>
                        </div>
                        <div class="skew l"></div>
                        <div class="main">
                            <div class="text-center"><h3>Ficha cliente</h3></div>   
                        </div>
                        <div class="skew r"></div>
                        <div class="bk r">
                            <div class="arrow top"></div> 
                            <div class="arrow bottom"></div>
                        </div>
                    </div>
                    <!-- FIN RIBBON 1 -->

                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <div class="panel panel-default panelTipo2">
                                <div class="panel-body text-center">
                                  	<div class="tituloTipo2Container">
	                                  	<h2 class="tituloTipo2">Facturación del año actual ({{ date('Y') }})</h2>
                                    </div>
                                    <div class="seccion">
                                        <h3>{{ $cliente->nom_cliente }}</h3>
                                    </div>
                                    <div class="seccion">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Fecha de Emisión</th>
                                                    <th>Pts. Normales</th>
                                                    <th>Pts. Especiales</th>
                                                    <th>Monto</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for ($i = (int)date('m'); ($i < 0) || ($i != (int)date('m') - 6); $i--)
                                                    <tr>
                                                        <th scope="row">{{ $cliente->{'mes'.$i} }}</th>
                                                        <td>{{ str_replace(",",".",number_format($cliente->{'ptos_normal'.$i})) }}</td>
                                                        <td>{{ str_replace(",",".",number_format($cliente->{'ptos_estrellas'.$i})) }}</td>
                                                        <td>${{ str_replace(",",".",number_format($cliente->{'factura'.$i})) }}</td>
                                                    </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="form-group">
                                      	<a href="{{ url(Request::segment(1).'/'.Request::segment(2)) }}" class="btn btn-default btn-xs">
                                            <span aria-hidden="true" class="glyphicon glyphicon-chevron-left"></span> Volver
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    @include('partials.sitio.footer')
@stop