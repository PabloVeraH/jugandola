@extends('sitio')

@section('titulo')
Pares
@stop

@section('header')
    @include('partials.sitio.header')
@stop

@section('content')
    <div class="container inicioTipo2">
        <div class="row">
            <div class="col-lg-12">
                <div class="juegatela post-preview">
                    <!-- RIBBON 1 -->
                    <div class="containerRibbon one overPanel overTopXs">
                        <div class="bk l">
                            <div class="arrow top"></div> 
                            <div class="arrow bottom"></div>
                        </div>
                        <div class="skew l"></div>
                        <div class="main">
                            <div class="text-center">
                                <h3 class="smallXs">Completa los pares y gana</h3>
                            </div>   
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
                                            <p class="goldText">Tienes 180 segundos para completar los 5 pares! Buena suerte.</p>
                                        
                                            <div class="timeGame text-center">
                                              <p class="goldText">Tiempo: <strong><span id="timeGame">0</span></strong> seg.</p>
                                            
                                            <p class="goldText" style="height:28px; color: #666"><small id="primerClick">Comienza el juego haciendo click en cualquier carta.</small></p>  
                                            </div>
                                        </div>
                                        
                                        <div class="boxEncuesta">
                                            <!-- COMIENZO DEL JUEGO-->
                                            <div id="main" role="main">
                          
                                                <div id="juegoMemoria" class="quizy-memorygame">
                                                    <ul>
                                                        <li class="match1">
                                                          <img src="{{ url('game/cartas/001.png') }}">
                                                        </li>
                                                        <li class="match2">
                                                          <img src="{{ url('game/cartas/002.png') }}">
                                                        </li>
                                                        <li class="match3">
                                                          <img src="{{ url('game/cartas/003.png') }}">
                                                        </li>
                                                        <li class="match4">
                                                          <img src="{{ url('game/cartas/004.png') }}">
                                                        </li>
                                                        <li class="match5">
                                                          <img src="{{ url('game/cartas/005.png') }}">
                                                        </li>
                                                        <li class="match1">
                                                          <img src="{{ url('game/cartas/001.png') }}">
                                                        </li>
                                                        <li class="match2">
                                                          <img src="{{ url('game/cartas/002.png') }}">
                                                        </li>
                                                        <li class="match3">
                                                          <img src="{{ url('game/cartas/003.png') }}">
                                                        </li>
                                                        <li class="match4">
                                                          <img src="{{ url('game/cartas/004.png') }}">
                                                        </li>
                                                        <li class="match5">
                                                          <img src="{{ url('game/cartas/005.png') }}">
                                                        </li>
                                                        
                                                    </ul>
                                                </div>
                                            </div>
                                          <!-- FIN JUEGO-->
                                        </div>
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
                                    @elseif( Session::has('gracias_juego') )
                                        @if (Session::get('gracias_juego') == 2)
                                            <div class="graciasEncuesta text-center" style="padding-bottom: 30px;">
                                                <h3 class="pregunta">FELICITACIONES</h3>
                                                <h4 class="pregunta">Tu tiempo: {{ Session::get('tiempoJuego') }} seg.</h4>
                                                <h4 class="pregunta">Has ganado 75 puntos en tu cuenta <br />
                                                            Gracias por jugártela con tu Club Unilever.</h4>
                                                <p class="help-block" style="color:#333">Recuerda que cada tres meses habrá una nueva oportunidad para ti.<br />
                                                    ¡Vuelve para superar el desafío y ganar! Te esperamos</p>
                                                    <a href="{{ route('gana_puntos') }}" class="btn btn-info" style="margin-top:20px;"><span aria-hidden="true" class="glyphicon glyphicon-chevron-left"></span> Volver</a>
                                                <script>okPage=false;</script>
                                                {{ Session::forget('gracias_juego') }}
                                                {{ Session::forget('tiempoJuego') }}
                                            </div>
                                        @else
                                            <div class="graciasEncuesta text-center" style="padding-bottom: 30px;">
                                                <h3 class="pregunta">GRACIAS POR JUGAR</h3>
                                                <h4 class="pregunta">Tu tiempo: {{ Session::get('tiempoJuego') }} seg.</h4>
                                                <h4 class="pregunta">Has ganado 0 puntos en tu cuenta <br />
                                                            Gracias por jugártela con tu Club Unilever.</h4>
                                                <p class="help-block" style="color:#333">Recuerda que cada tres meses habrá una nueva oportunidad para ti.<br />
                                                    ¡Vuelve para superar el desafío y ganar! Te esperamos</p>
                                                    <a href="{{ route('gana_puntos') }}" class="btn btn-info" style="margin-top:20px;"><span aria-hidden="true" class="glyphicon glyphicon-chevron-left"></span> Volver</a>
                                                <script>okPage=false;</script>
                                                {{ Session::forget('gracias_juego') }}
                                                {{ Session::forget('tiempoJuego') }}
                                            </div>
                                        @endif
                                    @else
                                        <div class="graciasEncuesta text-center" style="padding-bottom: 30px;">
                                            <h3 class="pregunta">Lo sentimos!</h3>
                                            <h4 class="pregunta">Ya participaste en este juego durante esta temporada<br />
                                                        Vuelve en la siguiente para ganar más puntaje.</h4>
                                            <p class="help-block" style="color:#333">Recuerda que cada tres meses habrá una nueva oportunidad para ti.<br />
                                                ¡Vuelve para superar el desafío y ganar! Te esperamos</p>
                                                
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
    

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/jquery-1.7.1.min.js"><\/script>')</script>
    <script src="{{ url('game/js/jquery-ui-1.8.17.custom.min.js') }}"></script>
    <script src="{{ url('game/js/jquery.flip.min.js') }}"></script>
    <script>
        var urlGameMelajuego= "{{ route('guardar_puntos_pares') }}";
    </script>
    <script src="{{ url('game/js/jquery.quizymemorygame.js') }}"></script>
    <script>
        var gameM = "{{ Session::has('idJuego') ? Session::get('idJuego') : 1 }}";
        gameM     = gameM.toString(); 
        var token = "{{ csrf_token() }}";
        console.log("game A "+gameM);
        $(".boxEncuesta").click(function(){
            $("#primerClick").fadeOut();
        });
        $("#gs-closebut").click(function(){
            console.log("okPage "+okPage);
            location.reload(); 
        });
    </script>
    <script>
        var quizyParams = {itemWidth: 135, itemHeight: 209, itemsMargin:10, colCount:5, animType:'flip' , flipAnim:'rl', animSpeed:160, resultIcons:true, randomised:true, onFinishCall:'test.php'}; 
        $('#juegoMemoria').quizyMemoryGame(quizyParams);
    </script>
    {{ Session::forget('idJuego') }}
    <link href="{{ url('game/css/quizymemorygame.css') }}" rel="stylesheet">
    <style>
    .quizy-mg-item .quizy-mg-item-top{
      background:url('{{ url('game/cartas/back.png') }}');
      background-size: 100%;
    }
    </style>
@stop