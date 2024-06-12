<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseJson;
use App\Models\Store;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckStoreActivationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            //> cek jika udah login
            //> cek jika profile toko sudah lengkap

            $store = Store::where(['user_id' => $user->id])->first();
            if ($user->status === User::STATUS_VERIFIED && !$store) {
                return ResponseJson::failedResponse("Silahkan lengkapi profil toko terlebih dahulu");
            }
        }

        return $next($request);
    }
}
