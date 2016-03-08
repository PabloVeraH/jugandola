@extends('sitio')

@section('titulo')
Mis Puntos
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
                            <div class="text-center"><h3>Tus puntos</h3></div>   
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
                                    <div class="seccion">
                                        <h5>Fecha:</h5>
                                        <h3>{{ date('d').' de '.date('F').' '.date('Y') }}</h3>
                                    </div>
                                    <div class="seccion">
                                        <h5>Puntos acumulados:</h5>
                                        <h3>{{ str_replace(",",".",number_format($puntos)) }} ptos.</h3>
                                    </div>
                                    <div class="seccion">
                                        <h5>N&deg; de puntos gastados:</h5>
                                        <h3>{{ str_replace(",",".",number_format($gastados)) }}</h3>
                                    </div>
                                    <div class="seccion">
                                        <h5><strong>N&deg; de puntos disponibles</strong>:</h5>
                                        <h3>{{ str_replace(",",".",number_format($puntos - $gastados)) }}</h3>
                                    </div>
                                    <div class="seccion">
                                        <h5>N&deg; de canjes realizados:</h5>
                                        <h3>{{ $canjes }} canje{{ ($canjes != 1) ? 's' : '' }}</h3>
                                    </div>
                                    <div class="seccion noBottom">
                                        <div class="tituloTipo1Container">
                                      		<h3 class="tituloTipo1">Canjes destacados para ti</h3>
                                      	</div>
                                        <div class="form-group productoSingle">
                                        	<div class="productoImg">
                                            	<img src="http://clubunilever.cl/img_productos/{{ $producto->pro_foto }}" class="img-responsive">
                                            </div>
                                            <div class="productoPtos">{{ $producto->pro_puntos }} ptos.</div>
                                            <div class="productoDesc">
                                            	<h3>{{ $producto->pro_nombre }}</h3>
                                                <p>Canje validos si existe stock disponible.</p>
                                            </div>
                                            <div class="form-group">
                                            	<a href="{{ route('detalle_producto',['id' => Crypt::encrypt($producto->pro_id)]) }}" class="btn btn-info">Canjear ahora</a>
                                      		</div>
                                      	</div>
                                        <hr>
                                        <div class="form-group">
                                            <a href="{{ route('catalogo') }}" class="btn btn-default btn-xs">Ver todos los productos 
                                                <span aria-hidden="true" class="glyphicon glyphicon-shopping-cart"></span><span aria-hidden="true" class="glyphicon glyphicon-chevron-right"></span>
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