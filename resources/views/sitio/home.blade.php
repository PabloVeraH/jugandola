@extends('sitio')

@section('titulo')
Home
@stop

@section('header')
    @include('partials.sitio.header')
@stop

@section('content')
	<header class="intro-header" style="background-image: url('{{ url('img/intro-home9.jpg') }}')">
	    <div class="container">
	        <div class="row">
	            <div class="col-xs-12 col-sm-6 col-sm-offset-3 ">
	                <div class="site-heading text-center contenedorPersonajes">
	                	<div class="logoDashboard">
	                    	<img src="{{ url('img/logoClubUnilever.png') }}" title="Club Unilever">
	                    </div>
	                    <div class="personaje_1">
	                    	<img src="{{ url('img/personaje_1.png') }}" title="Me la Juego con Club Unilever">
	                    </div>
	                    <div class="letrero">
	                    	<img src="{{ url('img/ver-resultados.png') }}" title="Ver ganadores">
	                    </div>
	                    <div class="verGanadoresContainer">
	                    	<div class="verParticipantes">
	                    		<a href="http://clubunilever.cl/lamejorfoto_septiembre/galeria_participantes/" target="_blank" title="Ver participantes">
	                    			<img src="{{ url('img/btn-ver-participantes.png') }}" title="Ver participantes" class="img-responsive">
	                    		</a>
	                    	</div>
	                    	<div class="verGanadores">
	                    		<a href="http://clubunilever.cl/lamejorfoto_septiembre/galeria_participantes/index_premiados.html" target="_blank" title="Ver ganadores">
	                    			<img src="{{ url('img/btn-ver-ganadores.png') }}" title="Ver ganadores" class="img-responsive">
	                    		</a>
	                    	</div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</header>

	<!-- Main Content -->
	<div class="container contMain">
	    <div class="row">
	        <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2  col-sm-8 col-sm-offset-2">
	            <div class="post-preview">
	                <div class="containerRibbon one overPanel overTopXs">
	                	<div class="bk l">
	                		<div class="arrow top"></div> 
	                		<div class="arrow bottom"></div>
	                	</div>
	                	<div class="skew l"></div>
	                	<div class="main">
	                		<div class="text-center"><h4>Ahora Te toca a tí</h4></div>   
	                	</div>
	                	<div class="skew r"></div>
	                	<div class="bk r">
	                		<div class="arrow top"></div> 
	                		<div class="arrow bottom"></div>
	                	</div>
	                </div>

	            	<div class="row">
	                	<div class="col-sm-8 col-sm-offset-2">
	                    	<div id="PanelDashboardUsr" class="panel panel-default panelTipo1">
	                          	<div class="panel-body">
	                          		<h3 class="text-center">Bienvenido</h3>
	                          		<div class="row">
	                            		<div class="col-sm-6 col-sm-offset-3 col-md-8 col-md-offset-2">
	                                		<div class="info-box text-center">
	                                			{{ utf8_decode(Auth::user()->nombres) }}
	                                		</div>
	                            		</div>
	                          		</div>
	                            
	                            	<p>
	                            		Participa y gana,<br>
		                                ademas de informar <br>a tus clientes de todas<br> las actividades del <br>club unilever.
	                            	</p>
	                            	<hr>
	                            	<div class="form-group text-center">
	                                	<a class="btn btn-default btn-info" href="{{ route('tu_cuenta') }}">Tu cuenta</a>
	                            	</div>
	                          	</div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

	@if ($modal)
		<div style="display:none">
			<a id="trigger" title="{{ $modal->mod_titulo }}" target="_self" class="fancybox" href="http://clubunilever.cl/img/content/{{ $modal->mod_foto }}">
				<img class="img-responsive" title="{{ $modal->mod_titulo }}" alt="{{ $modal->mod_titulo }}" src="http://clubunilever.cl/img/content/{{ $modal->mod_foto }}">
			</a>
		</div>
	@endif
@stop

@section('footer')
    @include('partials.sitio.footer')
@stop

@if ($modal)
	@section('scripts')
		$(document).ready(function() {
			$(".fancybox").fancybox();
			$("#trigger").trigger("click");
		});
	@stop
@endif