@extends('sitio')

@section('titulo')
Catalogo de Productos
@stop

@section('header')
    @include('partials.sitio.header')
@stop

@section('content')
    <div class="container inicioTipo2">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1  col-sm-12 col-sm-offset-0">
                <div class="catalogoProds post-preview">
                    <!-- RIBBON 1 -->
                    <div class="containerRibbon one overPanel overTopXs">
                        <div class="bk l">
                            <div class="arrow top"></div> 
                            <div class="arrow bottom"></div>
                        </div>
                        <div class="skew l"></div>
                        <div class="main">
                            <div class="text-center"><h3>Catálogo</h3></div>   
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
                                        <h3>{{ utf8_decode(Auth::user()->nombres) }}</h3>
                                        <div class="tituloTipo1Container">
                                      		<div class="tituloTipo1">
                                        	   <h3>Puntos acumulados</h3>
                                        	   <h2>{{ str_replace(",",".",number_format($puntos)) }} ptos.</h2>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="seccion noBottom row">
                                        <?php $contador = 0; ?>
                                        @foreach ($productos as $producto)
                                            <?php $contador++; ?>
                                            <div class="form-group productoSingle col-xs-6">
                                            	<div class="productoImg">
                                                	<a href="{{ route('detalle_producto',['id' => Crypt::encrypt($producto->pro_id)]) }}">
                                                        <img src="http://clubunilever.cl/img_productos/{{ $producto->pro_foto }}" class="img-responsive">
                                                    </a>
                                                </div>
                                                <div class="productoPtos">{{ str_replace(",",".",number_format($producto->pro_puntos)) }} ptos.</div>
                                                <div class="productoDesc">
                                                	<h3>{{ $producto->pro_nombre }}</h3>
                                                    <p>Canje validos si existe stock disponible.</p>
                                                </div>
                                                <div class="form-group">
                                                	<a href="{{ route('detalle_producto',['id' => Crypt::encrypt($producto->pro_id)]) }}" class="btn btn-info btn-xs">Canjear ahora</a>
                                          		</div>
                                          	</div>
                                            @if ($contador%2==0)
                                                <div class="clearfix"></div>
                                            @endif
                                        @endforeach
                                    </div>                                        

                                    <nav>
                                        {!! $productos->render(); !!}
                                    </nav>
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