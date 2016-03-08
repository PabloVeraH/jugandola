@extends('sitio')

@section('titulo')
{{ $producto->pro_nombre }}
@stop

@section('header')
    @include('partials.sitio.header')
@stop

@section('content')
    <div class="container inicioTipo2">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1  col-sm-12 col-sm-offset-0">
                    <div class="catalogoProdsDetalle post-preview">
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
                                      <!-- PRODUCTOS -->
                                    <div class="seccion noBottom row">
                                      
                                       <!-- Un producto -->
                                        <div class="form-group productoSingle col-xs-12">
                                            <div class="productoImg text-center">
                                                <img src="http://clubunilever.cl/img_productos/{{ $producto->pro_foto }}" class="img-responsive" style="margin:0 auto;">
                                            </div>
                                            <div class="productoPtos">{{ str_replace(",",".",number_format($producto->pro_puntos)) }} ptos.</div>
                                            <div class="productoDesc">
                                                <h2>{{ $producto->pro_nombre }}</h2>
                                                <div>
                                                    {!! $producto->pro_descripcion !!}
                                                </div>
                                            </div>                                            
                                        </div>
                                        <div class="clearfix"></div>
                                        <hr>
                                        <div class="clearfix"></div>

                                        @if(!Session::has('canje_correcto'))
                                            <div class="seccion2">
                                                <h3>{{ utf8_decode(Auth::user()->nombres) }}</h3>
                                                <div class="tituloTipo1Container">
                                                    <div class="tituloTipo1">
                                                        <h3>Puntos acumulados</h3>
                                                        <h2>{{ str_replace(",",".",number_format($puntos)) }} ptos.</h2>
                                                    </div>
                                                </div>
                                                <!--
                                                <form id="formCanje" class="form" method="post" action="{{ route('canjear',['id' => Request::segment(2)]) }}">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <div class="form-group col-sm-6 col-sm-offset-3 ">
                                                        <label for="inputPass" class="control-label">Ingresa Contraseña para canjear</label>
                                                        <div class="col-sm-X">
                                                            <input type="password" class="form-control text-center" id="inputPassCanje" placeholder="Contraseña">
                                                        </div>
                                                    </div>
                                                    @if(Session::has('canje_error'))
                                                        <div class="form-group">
                                                            <div class="col-sm-8 col-sm-offset-2">
                                                                <div id="errorGral" role="alert" class="alert alert-danger">
                                                                    <strong>Ups!</strong> <span>{{ Session::get('canje_error') }}</span>  
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="form-group">
                                                        <a id="canjeProdDetalle" href="detalle-producto.html" class="btn btn-info">Canjear ahora</a>
                                                    </div>
                                                </form>
                                                -->
                                                <br>
                                                <div class="form-group">
                                                    <a id="canjeProdDetalle" href="#" class="btn btn-info">Proximamente</a>
                                                </div>
                                            </div>
                                        @else                                        
                                            <div class="seccion3">
                                                <div role="alert" class="alert alert-success">
                                                    <strong>Excelente!</strong> Haz canjeado un producto. Pronto se contactarán con Usted para confirmar stock y coordinar la entrega.
                                                </div>
                                                <div class="tituloTipo1Container">
                                                    <div class="tituloTipo1">
                                                        <h3>Puntos restantes</h3>
                                                        <h2>{{ str_replace(",",".",number_format($puntos)) }} ptos.</h2>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <div class="clearfix"></div>
                                        <hr>
                                        <div class="form-group">
                                            <a class="btn btn-default btn-xs" href="{{ (URL::previous() == Request::fullUrl()) ? route('catalogo') : URL::previous() }}">
                                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Volver
                                            </a>
                                        </div>
                                        
                                        
                                        
                                        </div>
                                        <!-- FIN PRODUCTOS -->
                                        
                                        
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