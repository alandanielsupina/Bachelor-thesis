<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class IsSelectedCompany
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->get('selected_company')) {
            $user = User::findOrFail(Auth::id());
            
            if ($user->hasRole('owner')) {
                $selected_company = session()->get('selected_company');
                if (Company::where('id', $selected_company)->where('user_id', Auth::id())->count() === 1) {
                    return $next($request);
                }
            }
            if ($user->hasRole('super-admin')) {
                return $next($request);
            }
        }
        abort(403);
    }
}
