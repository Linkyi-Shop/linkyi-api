<?php

namespace App\Http\Middleware;

use App\Helpers\MemberLogout;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class MemberAccessLogin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */


    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if ($user->tokenCan('accessLogin')) {
            $personalAccessToken = $user->tokens()->first();
            if ($personalAccessToken === null) {
                Session()->forget('id_user_' . $user->id);
                $user->tokens()->delete();
                return response()->json(['success' => false, 'status' => 'Token Expired', 'data' => null], 401);
            }

            $dateTimeNow = Carbon::now();
            // $diffInMinutes = $personalAccessToken->last_used_at->diffInMinutes($dateTimeNow);
            // $accessTokenIdle = ENV('ACCESSTOKENIDLE');

            // if ($diffInMinutes > $accessTokenIdle) {
            //     Session()->forget('id_user_' . $user->id);
            //     $user->tokens()->delete();
            //     return response()->json(['success' => false, 'status' => 'Token Expired', 'data' => null], 401);
            // }

            $personalAccessToken->last_used_at = $dateTimeNow;
            $personalAccessToken->save();
            return $next($request);
        }

        return response()->json([
            'success' => 'false',
            'status' => 'Token Expired',
            'data' => null,
        ], 401);
    }
}
