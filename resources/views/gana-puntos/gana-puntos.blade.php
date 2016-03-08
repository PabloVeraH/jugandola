@extends('sitio')

@section('titulo')
Gana Puntos
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
                            <div class="text-center"><h3>Gana Puntos</h3></div>   
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

                                    @if (Session::has('message_success'))
                                        <div class="alert alert-success">
                                            <strong>¡Felicitaciones!</strong> <br> {!! Session::get('message_success') !!}
                                        </div>
                                    @elseif (Session::has('error_trivia'))
                                        <div class="alert alert-danger">
                                            <strong>Casi casi casi!</strong> <br> {!! Session::get('error_trivia') !!}
                                        </div>
                                    @endif

                                    <div class="seccion text-center">
                                        <p class="goldText">
                                            Completa todas las encuestas, trivias y juegos del año. ¡Sortearemos <strong>1000 puntos</strong> entre todos los vendedores que así lo hagan! Periódicamente actualizaremos esta sección, ¡vuelve para sumar nuevos puntos!.
                                        </p>
                                    </div>
                                      
                                    <!-- CADA POST-->
                                    <div class="seccion cadaPostJuegatela">
                                      	<div class="row">
                                            <div class="col-xs-5 leftP">
                                                <img src="{{ url('img/juegatela-encuesta.png') }}" alt="" class="img-responsive">
                                            </div>
                                            <div class="col-xs-7 rightP">
                                                <h2>Te queremos <span>conocer más.</span></h2>
                                                <p>Responde la encuesta y gana automáticamente 100 puntos.</p>
                                                <a href="{{ route('gana_puntos_encuesta') }}" style="border-radius:0; color:#fff; padding: 5px; font-size:11px" class="btn btn-danger">Comenzar <span style="color:#fff;" aria-hidden="true" class="glyphicon glyphicon-chevron-right"></span></a>
                                            </div>
                                        </div>
                                    </div>
                                      
                                    <!-- CADA POST-->
                                    <div class="seccion cadaPostJuegatela">
                                      	<div class="row">
                                            <div class="col-xs-5 leftP">
                                                <img src="{{ url('img/juegatela-trivia.png') }}" alt="" class="img-responsive">
                                            </div>
                                            <div class="col-xs-7 rightP">
                                                <h2>Veamos cómo anda <span>tu memoria.</span></h2>
                                                <p>Responde la trivia y gana automáticamente 75 ptos. <br>
                                                    ¡Vamos, está muy fácil.</p>
                                                <a style="border-radius:0; color:#fff; padding: 5px; font-size:11px" class="btn btn-danger" href="{{ route('gana_puntos_trivia') }}">Comenzar <span style="color:#fff;" aria-hidden="true" class="glyphicon glyphicon-chevron-right"></span></a>
                                            </div>
                                        </div>
                                    </div>
                                      
                                    <!-- CADA POST-->
                                    <div class="seccion cadaPostJuegatela">
                                      	<div class="row">
                                            <div class="col-xs-5 leftP">
                                                <img src="{{ url('img/juegatela-juego.png') }}" alt="" class="img-responsive">
                                            </div>
                                            <div class="col-xs-7 rightP">
                                                <h2>Juega <span>completando los pares y gana.</span></h2>
                                                <p>automáticamente 75 ptos.</p>
                                                <a style="border-radius:0; color:#fff; padding: 5px; font-size:11px" class="btn btn-danger" href="{{ route('gana_puntos_pares') }}">Comenzar <span style="color:#fff;" aria-hidden="true" class="glyphicon glyphicon-chevron-right"></span></a>
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
    </div>
@stop

@section('footer')
    @include('partials.sitio.footer')
@stop