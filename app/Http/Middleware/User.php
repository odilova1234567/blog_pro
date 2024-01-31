<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use App\Models\ApiUser;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class User extends Controller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $check_ApiUser = ApiUser::where("token",$this->getToken())->first();
        if($check_ApiUser == null){
            return $this->sendResponse(null,false,"User topilmadi");
        }
        $request->check_Apiuser = $check_ApiUser;
        return $next($request);
    }
}
