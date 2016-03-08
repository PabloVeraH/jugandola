@extends('sitio')

@section('titulo')
{{ $cliente->nom_cliente }}
@stop

@section('header')
    @include('partials.sitio.header')
@stop

@section('content')
	<div class="container inicioTipo2">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2  col-sm-8 col-sm-offset-2">
                <div class="tuCuenta post-preview">
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
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <div class="panel panel-default panelTipo2">
                                <div class="panel-body text-center">
                                    <div class="seccion">
                                        <h5>Nombre:</h5>
                                        <h3>{{ $cliente->nom_cliente }}</h3>
                                    </div>
                                    <div class="seccion">
                                        <h5>Nombre del local:</h5>
                                        <h3>{{ $cliente->nombre_local }}</h3>
                                    </div>
                                    <div class="seccion">
                                        <h5>Puntos acumulados:</h5>
                                        <h3>{{ str_replace(",",".",number_format($puntos)) }} ptos.</h3>
                                    </div>
                                    <div class="seccion">
                                        <h5>No. canjes realizados:</h5>
                                        <h3>{{ $cliente->canjes()->count() }} canjes</h3>
                                    </div>
                                    <div class="seccion">
                                        <h5>categoría a que pertenece:</h5>
                                        <div class="categoriaImg">
                                        	<img src="{{ url('img/'.$imagen_nivel) }}" alt="Socio TOP" class="img-responsive" style="margin: 0px auto;">
                                        </div>
                                    </div>
                                    <div class="seccion noBottom">
                                      	<div class="tituloTipo1Container">
                                      		<h3 class="tituloTipo1">Facturación total (Últimos 3 meses)</h3>
                                      	</div>
                                        <div class="numberFormatContainer">
                        					<h4 class="numberFormat"> ${{ str_replace(",",".",number_format($delmes)) }} </h4>
                                      	</div>
                                        <div class="form-group">
                                            <a href="{{ Request::url() }}/detalle" class="btn btn-default btn-info">Ver detalle</a>
                                      	</div>
                                        <hr>
                                        <div class="form-group">
                                            <a href="{{ route('tu_cuenta') }}" class="btn btn-default btn-xs">
                                                <span aria-hidden="true" class="glyphicon glyphicon-chevron-left"></span> 
                                                Volver
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
    </div>
@stop

@section('footer')
    @include('partials.sitio.footer')
@stop