@extends('sitio')

@section('titulo')
Encuesta
@stop

@section('header')
    @include('partials.sitio.header')
@stop

@section('content')
	<div class="container inicioTipo2">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2  col-sm-8 col-sm-offset-2">
                <div class="juegatela post-preview">
                    <!-- RIBBON 1 -->
                    <div class="containerRibbon one overPanel overTopXs">
                        <div class="bk l">
                            <div class="arrow top"></div> 
                            <div class="arrow bottom"></div>
                        </div>
                        <div class="skew l"></div>
                        <div class="main">
                            <div class="text-center"><h3 class="smallXs">Gana Puntos - Encuesta</h3></div>   
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
                                <div class="panel-body">
                                    <!-- CADA POST-->
                                    <div class="seccion cadaPostJuegatela">
                                      	<div class="row">
                                            <div class="col-xs-5 leftP">
                                                <img src="{{ url('img/juegatela-encuesta.png') }}" alt="" class="img-responsive">
                                            </div>
                                            <div class="col-xs-7 rightP">
                                                <h2>Te queremos <span>conocer más.</span></h2>
                                                <p>Responde la encuesta y gana automáticamente 100 puntos.</p>
                                            </div>
                                        </div>
                                    </div>
                                    @if (count($alternativas) > 0)
                                        @if (Session::has('error_message'))
                                            <div role="alert" class="alert alert-danger">
                                                <strong>¡Ups!</strong> {{ Session::get('error_message') }}
                                            </div>
                                        @endif
                                        <form class="encuestaForm" method="post" action="{{ route('guardar_encuesta') }}">
                                            <?php $contador = 0; ?>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="encuesta" value="{{ Crypt::encrypt($encuesta->id) }}">
                                            @foreach ($alternativas as $alternativa)
                                                <div class="form-group">
                                                    <label class="pregunta" for="pregunta#{{ $alternativa->id }}">
                                                        {{ ++$contador }}) {{ $alternativa->pregunta }}
                                                    </label>
                                                  	<div class="radio">
                                                        <label>
                                                            <?php $encryptPregunta = Crypt::encrypt($alternativa->id); ?>
                                                            <input type="radio" name="pregunta#{{ $encryptPregunta }}" id="pregunta#{{ $encryptPregunta }}" value="1">
                                                            SI
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="pregunta#{{ $encryptPregunta }}" id="pregunta#{{ $encryptPregunta }}" value="0" checked>
                                                            NO
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div class="form-group text-center">
                                                <button type="submit" class="btn btn-info">
                                                    <span aria-hidden="true" class="glyphicon glyphicon glyphicon-ok"></span> Enviar encuesta
                                                </button>
                                            </div>
                                            <hr>
                                            <div class="form-group text-center">
                                                <a href="{{ route('gana_puntos') }}" class="btn btn-default btn-xs">
                                                    <span aria-hidden="true" class="glyphicon glyphicon-chevron-left"></span> Volver
                                                </a>
                                            </div>
                                        </form>  
                                    @else
                                        <div role="alert" class="alert alert-warning">
                                            <strong>¡Ups!</strong> Esta sección no se encuentra disponible para ti.
                                        </div>
                                        <div class="form-group text-center">
                                            <a href="{{ route('gana_puntos') }}" class="btn btn-default btn-xs">
                                                <span aria-hidden="true" class="glyphicon glyphicon-chevron-left"></span> Volver
                                            </a>
                                        </div>
                                    @endif
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