@extends('sitio')

@section('content')
	<header class="intro-header" style="background-image: url('{{ url('img/intro-home9.jpg') }}')">
	    <div class="container">
	        <div class="row">
	            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
	                <div class="site-heading text-center">
	                    <h1><img src="{{ url('img/logo-intro.png') }}" title="Me la Juego con Club Unilever" class="img-responsive"></h1>
	                </div>
	            </div>
	        </div>
	    </div>
	</header>

	<div class="container">
	    <div class="row">
	        <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2  col-sm-8 col-sm-offset-2">
	            <div id="formLoginContainer" class="post-preview">
	                <div class="containerRibbon one">
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
	            	<form id="formLogin" class="form-horizontal" style="display:none" method="post" action="{{ url('/auth/login') }}">
	            		<input type="hidden" name="_token" value="{{ csrf_token() }}">
	                  	<div class="form-group">
	                    	<label for="inputRut" class="col-sm-2 control-label">RUT</label>
	                    	<div class="col-sm-8">
	                      		<input type="text" class="form-control" id="inputRut" name="rut" value="{{ (Input::old('rut')) ? Input::old('rut') : '' }}" placeholder="Ingresa tu RUT aquí">
	                    	</div>
	                  	</div>
	                  	<div class="form-group">
	                    	<label for="inputPass" class="col-sm-2 control-label">Contraseña</label>
	                    	<div class="col-sm-8">
	                      		<input type="password" class="form-control" name="password" id="inputPass" placeholder="Contraseña">
	                    	</div>
	                  	</div>
	                  	<div class="form-group">
	                      	<div class="col-sm-8 col-sm-offset-2">
	                          	<div id="errorGral" role="alert" class="alert alert-danger" style="display:none;">
	                  				<strong>Ups!</strong> <span></span>  
	                			</div>
	                      	</div>
	                  	</div>
	                  	<div class="form-group">
		                  	<div class="col-sm-8 col-sm-offset-2"> 
	                    		<a id="btnLogin" href="#" class="btn btn-default btn-info">Enviar</a> 
	                    	</div>
	                  	</div>
	                </form>
	            	<div id="btnIniciarContainer">
	                  	<div class="text-center"> 
	                    	<a id="btnIniciar" href="#" class="btn btn-lg btn-info">Iniciar</a>
	                    </div>
	                </div>
	                @if (Session::has('app_error'))
		                <br>
		                <div class="form-group">
		        	      	<div class="col-sm-8 col-sm-offset-2">
		        	          	<div id="login_error" role="alert" class="alert alert-danger">
		        	  				<strong>Ups!</strong> <span>{{ Session::has('app_error') }}</span>  
		        				</div>
		        	      	</div>
		        	  	</div>
	                @endif	                
	            </div>
	        </div>
	    </div>
	</div>
@endsection

@section('footer')
    @include('partials.sitio.footer')
@stop