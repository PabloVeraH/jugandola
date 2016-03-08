@extends('sitio')

@section('titulo')
Mi Cuenta
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
                            <div class="text-center"><h3>Tu cuenta</h3></div>   
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
                                        <h5>Nombre:</h5>
                                        <h3>{{ utf8_decode(Auth::user()->nombres) }}</h3>
                                    </div>
                                    <div class="seccion">
                                        <h5>RUT:</h5>
                                        <h3>{{ Auth::user()->rut }}</h3>
                                    </div>
                                    <div class="seccion">
                                        <h5>N° de clientes registrados</h5>
                                        <h3>{{ Auth::user()->clientes()->count() }} cliente{{ (Auth::user()->clientes()->count() != 1) ? 's' : '' }}</h3>
                                    </div>
                                    <form action="{{ route('ficha_cliente') }}" method="post" id="FormConsultaCliente">
                                        <div class="seccion noBottom">
                                            @if (Session::has('error_message'))
                                                <div role="alert" class="alert alert-danger">
                                                    <strong>Ups!</strong> <span>{{ Session::get('error_message') }}</span>  
                                                </div>
                                            @endif
                                            <div class="tituloTipo1Container">
                                                <h3 class="tituloTipo1">Ver ficha de clientes</h3>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputRut" class="control-label">Ingrese RUT del cliente</label>
                                                <input type="text" class="form-control text-center input-lg" name="rut" id="inputRut" placeholder="Ingresa tu RUT aquí" value="{{ (Input::old('rut')) ? Input::old('rut') : '' }}">
                                            </div>
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <div class="form-group">
                                                <div class="">
                                                    <div id="errorGral" role="alert" class="alert alert-danger" style="display:none;">
                                                        <strong>Ups!</strong> <span></span>  
                                                    </div>
                                                    <div id="errorUsr" role="alert" class="alert alert-warning" style="display:none;">
                                                        <strong>Ups!</strong> <span></span>  
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <a id="btnEnviar" href="#" class="btn btn-default btn-info">Consultar</a>
                                          	</div>
                                        </div>
                                    </form>
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