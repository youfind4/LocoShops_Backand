<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Exceptions\UnauthorizedException;

class Permissions
{
    private $exceptNames = [
        'LaravelInstaller*',
        'LaravelUpdater*',
        'debugbar*'
    ];

    private $exceptControllers = [
        'LoginController',
        'ForgotPasswordController',
        'ResetPasswordController',
        'RegisterController',
        'PayPalController'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $permission = $request->route()->getName();
        if ($this->match($request->route()) && auth()->user()->canNot($permission)) {
            // throw new UnauthorizedException(403, trans('error.permission') . ' <b>' . $permission . '</b>');
            // VPN Team Start
            return redirect(route('users.profile'));
            // VPN Team End
        }

        return $next($request);
    }

    private function match(\Illuminate\Routing\Route $route)
    {
        if ($route->getName() == '' || $route->getName() === null) {
            return false;
        } else {
            if (in_array(class_basename($route->getController()), $this->exceptControllers)) {
                return false;
            }
            foreach ($this->exceptNames as $except) {
                if (str_is($except, $route->getName())) {
                    return false;
                }
            }
        }
        return true;
    }

}