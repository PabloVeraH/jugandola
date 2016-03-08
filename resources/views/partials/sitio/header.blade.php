<!-- Navigation -->
    <nav class="navbar navbar-default navbar-custom navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Menu</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ URL::route('inicio') }}"><img alt="Unilever" src="{{ url('img/logoUnilever.png') }}"></a>
            </div>
            
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
               <ul class="nav navbar-nav navbar-right">
                    <li class="{{ \Request::is('/') ? 'active' : '' }}">
                        <a href="{{ URL::route('inicio') }}">Inicio</a>
                    </li>
                    <li class="{{ \Request::is('tu-cuenta') || \Request::is('tu-cuenta/*') ? 'active' : '' }}">
                        <a href="{{ URL::route('tu_cuenta') }}">Tu cuenta</a>
                    </li>
                    <li class="{{ \Request::is('tus-puntos') || \Request::is('tus-puntos/*') ? 'active' : '' }}">
                        <a href="{{ URL::route('tus_puntos') }}">Tus puntos</a>
                    </li>
                    <li class="{{ \Request::is('juegatela') || \Request::is('juegatela/*') ? 'active' : '' }}">
                        <a href="{{ URL::route('juegatela') }}">Juégatela</a>
                    </li>
                    <li class="{{ \Request::is('catalogo') || \Request::is('catalogo/*') ? 'active' : '' }}">
                        <a href="{{ URL::route('catalogo') }}">Catálogo</a>
                    </li>
                    <li class="{{ \Request::is('gana-puntos') || \Request::is('gana-puntos/*') ? 'active' : '' }}">
                        <a href="{{ URL::route('gana_puntos') }}">Gana puntos</a>
                    </li>
                    <li>
                        <a href="{{ url('auth/logout') }}">Salir</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>