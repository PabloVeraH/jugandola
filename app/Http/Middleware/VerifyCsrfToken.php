<?php namespace MeLaJuego\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier {

    protected $except = [
        'api/*'
    ];

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		return parent::handle($request, $next);
	}

	/**
     * Determine if the session and input CSRF tokens match.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function tokensMatch($request){
        $token = $request->session()->token();
        $_token = $request->input('_token');
        $header = $request->header('X-XSRF-TOKEN');
        if ( $token === $_token || ($header && $token === $this->encrypter->decrypt($header) )) {
       		return true;
       	}
       	else{
       		return false;
       		//return redirect()->back()->with(['app_error','Mucho tiempo de inactividad, prueba nuevamente lo solicitado']);
        }
    }

}
