@extends('sitio')

@section('titulo')
Juegatela
@stop

@section('styles')
    <link rel="stylesheet" href="{{ url('juego-ruleta/css/style.css') }}" type="text/css" media="screen" />
    <script>
        var okPage=true;
    
        var myEvent = window.attachEvent || window.addEventListener;
        var chkevent = window.attachEvent ? 'onbeforeunload' : 'beforeunload'; /// make IE7, IE8 compatable
        myEvent(chkevent, function(e) { // For >=IE7, Chrome, Firefox
            var confirmationMessage = ' ';  // a space
            if(okPage){
                (e || window.event).returnValue = confirmationMessage;
                return confirmationMessage;
            }
        });
    </script>
    <style>
        .fancybox-margin{margin-right:15px;}
        body, #tipo2 footer {
          background: rgba(0, 0, 0, 0) url("{{ url('img/fondo1.gif') }}") repeat scroll 0 0;
          color: #fff;
        }
    </style>
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
                            <div class="text-center"><h3>Juegatela</h3></div>   
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
                                   
                                    @if ($habilitado)
                                        <div class="seccion text-center">
                                            <p class="goldText">Si te sale 3 veces repetida la imagen, ya ganaste.</p>
                                        </div>
                                                                        
                                        <div class="boxEncuesta">
                                            <!-- COMIENZO DEL JUEGO-->
                                            <div id="main" role="main">
                                                <div class="content">
                                                    <img src="{{ url('juego-ruleta/img/maquina-slot.png') }}" class="img-responsive fondoImgSlot" style="margin:0 auto">
                                                    <div class="slotContainer"> 
                                                        <div class="row">
                                                            <div id="machine4" class="slotMachine col-xs-4 slotLeft">
                                                                <div class="slot slot1"></div>
                                                                <div class="slot slot2"></div>
                                                                <div class="slot slot3"></div>
                                                                <div class="slot slot4"></div>
                                                                <div class="slot slot5"></div>
                                                                <div class="slot slot6"></div>
                                                            </div>
                                                            
                                                            <div id="machine5" class="slotMachine col-xs-4 slotCenter">
                                                                <div class="slot slot1"></div>
                                                                <div class="slot slot2"></div>
                                                                <div class="slot slot3"></div>
                                                                <div class="slot slot4"></div>
                                                                <div class="slot slot5"></div>
                                                                <div class="slot slot6"></div>
                                                            </div>
                                                            
                                                            <div id="machine6" class="slotMachine col-xs-4 slotRight">
                                                                <div class="slot slot1"></div>
                                                                <div class="slot slot2"></div>
                                                                <div class="slot slot3"></div>
                                                                <div class="slot slot4"></div>
                                                                <div class="slot slot5"></div>
                                                                <div class="slot slot6"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="slotContainerbtns text-center">
                                                        <a id="slotMachineButtonShuffle" href="#"  class="btn btn-primary btn-lg">Iniciar</a>
                                                        <a id="slotMachineButtonStop" href="#" style="display:none"  class="btn btn-danger btn-lg">Detener!</a>
                                                    </div>
                                                </div>
                                                                          
                                                                            
                                                <div class="clearfix"></div>

                                                <div id="modalGanar" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                                                    <div class="modal-dialog modal-sm">
                                                        <div class="modal-content">
                                                            <div class="text-center" style="padding:20px;">
                                                                <h3 class="pregunta">FELICITACIONES</h3>
                                                                <a href="#"  class="reload btn btn-primary btn-lg">Continuar</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> 

                                                <div id="modalPerder" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                                                    <div class="modal-dialog modal-sm">
                                                        <div class="modal-content">
                                                            <div class="text-center" style="padding:20px;">
                                                                <h3 class="pregunta">LO SENTIMOS!</h3>
                                                                <a href="#"  class="reload btn btn-primary btn-lg">Continuar</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>
                                            <!-- FIN JUEGO-->
                                        </div>
                                    @elseif( Session::has('gracias_juego') )
                                        @if (Session::get('gracias_juego') == 2)
                                            <div class="graciasEncuesta text-center" style="padding-bottom: 30px;">
                                                <h3 class="pregunta">FELICITACIONES</h3>
                                                <h4 class="pregunta">
                                                    Has ganado 75 puntos en tu cuenta <br />
                                                    Gracias por jugártela con tu Club Unilever.
                                                </h4>
                                                <p class="help-block" style="color:#333">
                                                    Recuerda que cada tres meses habrá una nueva oportunidad para ti.<br />
                                                    ¡Vuelve para superar el desafío y ganar! Te esperamos
                                                </p>
                                                <a href="{{ route('inicio') }}" class="btn btn-info" style="margin-top:20px;"><span aria-hidden="true" class="glyphicon glyphicon-chevron-left"></span> Volver</a>
                                                <script>okPage=false;</script>
                                            </div>
                                        @else
                                            <div class="graciasEncuesta text-center" style="padding-bottom: 30px;">
                                                <h3 class="pregunta">GRACIAS POR JUGAR</h3>
                                                <h4 class="pregunta">
                                                    Has ganado 0 puntos en tu cuenta <br />
                                                    Gracias por jugártela con tu Club Unilever.
                                                </h4>
                                                <p class="help-block" style="color:#333">
                                                    Recuerda que cada tres meses habrá una nueva oportunidad para ti.<br />
                                                    ¡Vuelve para superar el desafío y ganar! Te esperamos
                                                </p>
                                                <a href="{{ route('inicio') }}" class="btn btn-info" style="margin-top:20px;"><span aria-hidden="true" class="glyphicon glyphicon-chevron-left"></span> Volver</a>
                                                <script>okPage=false;</script>
                                            </div>
                                        @endif
                                        {{ Session::forget('gracias_juego') }}
                                        {{ Session::forget('tiempoJuego') }}
                                    @else
                                        <div class="graciasEncuesta text-center" style="padding-bottom: 30px;">
                                            <h3 class="pregunta">Lo sentimos!</h3>
                                            <h4 class="pregunta">
                                                Ya participaste en este juego durante esta temporada<br />
                                                Vuelve en la siguiente para ganar más puntaje.
                                            </h4>
                                            <p class="help-block" style="color:#333">
                                                Recuerda que cada tres meses habrá una nueva oportunidad para ti.<br />
                                                ¡Vuelve para superar el desafío y ganar! Te esperamos
                                            </p>                                        
                                            <a href="{{ route('gana_puntos') }}" class="btn btn-info" style="margin-top:20px;"><span aria-hidden="true" class="glyphicon glyphicon-chevron-left"></span> Volver</a>
                                            <script>okPage=false;</script>
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

@section('otrosScripts')
    <script>
        var urlGameMelajuego='{{ route("guardar-juegatela") }}';
    </script>
    <script type="text/javascript" src="{{ url('juego-ruleta/src/jquery.slotmachine.js') }}"></script>
            
    <script>
        var token = "{{ csrf_token() }}";
        var gameM = "{{ Session::has('idJuegatela') ? Session::get('idJuegatela') : 1 }}";
        gameM     = gameM.toString(); 
        console.log("game A "+gameM);
        $(document).ready(function(){
            var machine4 = $("#machine4").slotMachine({
                active  : 0,
                delay   : 500
            });
            
            var machine5 = $("#machine5").slotMachine({
                active  : 1,
                delay   : 500
            });
            
            window.machine6 = $("#machine6").slotMachine({
                active  : 2,
                delay   : 500
            });
            
            var started = 0;
            
            $("#slotMachineButtonShuffle").click(function(e){
                e.preventDefault();
                $(this).remove();
                $("#slotMachineButtonStop").fadeIn();
                started = 3;
                machine4.shuffle();
                machine5.shuffle();
                machine6.shuffle();
            });
            
            $("#slotMachineButtonStop").click(function(e){
                e.preventDefault();
                switch(started){
                    case 3:
                        machine4.stop();
                        console.log("A: "+machine4.active);
                        break;
                    case 2:
                        machine5.stop();
                        console.log("B: "+machine5.active);
                        break;
                    case 1:
                        machine6.stop();
                        console.log("C: "+machine6.active);
                        $("#slotMachineButtonStop").fadeOut();
                        if(machine4.active == machine5.active && machine5.active == machine6.active){
                            gana();
                        }else{
                            pierde();
                        };
                        break;
                }
                started--;
            });
        });
    </script>
    {{ Session::forget('idJuegatela') }}
@stop