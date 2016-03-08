<!-- Footer -->
<footer>
    @if (Auth::check())
    	<div class="container">
            <div class="row">
            	
                <div id="navcontainer" class="hidden-xs">
                    <ul id="navlist">
                        <li><a href="{{ route('tu_cuenta') }}">Tu cuenta</a></li>
                        <li><a href="{{ route('tus_puntos') }}">Tus puntos</a></li>
                        <li><a href="{{ route('juegatela') }}">Juégatela</a></li>
                        <li><a href="{{ route('catalogo') }}">Catálogo</a></li>
                        <li><a href="{{ route('gana_puntos') }}">Gana puntos</a></li>
                    </ul>
                </div>
                
            </div>
        </div>
    @endif
</footer>