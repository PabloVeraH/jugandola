@extends('sitio')

@section('titulo')
Trivia
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
                            <div class="text-center"><h3 class="smallXs">Gana Puntos - Trivia</h3></div>   
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
                                    <div class="seccion cadaPostJuegatela">
                                      	<div class="row">
                                            <div class="col-xs-5 col-sm-3 col-sm-offset-2 leftP">
                                                <img src="{{ url('img/juegatela-trivia.png') }}" alt="" class="img-responsive">
                                            </div>
                                            <div class="col-xs-7 rightP">
                                                <h2>Veamos como anda <span>tu memoria.</span></h2>
                                                <p>Responde la trivia y gana automáticamente 75 ptos. <br>
                                                    ¡Vamos, está muy fácil.</p>
                                            </div>
                                        </div>
                                    </div>
                                      
                                    @if (count($preguntas) > 0)
                                        @if (Session::has('error_message'))
                                            <div role="alert" class="alert alert-danger">
                                                <strong>¡Ups!</strong> {{ Session::get('error_message') }}
                                            </div>
                                        @endif
                                        <form class="encuestaForm" method="post" action="{{ route('guardar_trivia') }}">
                                            <?php $contador = 0; ?>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="trivia" value="{{ Crypt::encrypt($trivia->id) }}">
                                            @foreach ($preguntas as $pregunta)
                                                <div class="form-group">
                                                    <label class="pregunta" for="pregunta#{{ $pregunta->id }}">
                                                        {{ ++$contador }}) {{ $pregunta->pregunta }}
                                                    </label>
                                                    <div class="radio">
                                                        <?php $encryptPregunta = Crypt::encrypt($pregunta->id); ?>
                                                        <label>
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
                                                    <span aria-hidden="true" class="glyphicon glyphicon glyphicon-ok"></span> Enviar Trivia
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