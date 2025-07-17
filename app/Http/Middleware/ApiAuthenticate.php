<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use JWTAuth;
use App\Models\User;
use Exception;

class ApiAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $inactive = User::STATUS['Inactive'];
            if (empty($user)) {
                return response()->json(['status' => false, 'code'=>404,
                'message' => trans('message.user_not_exists'), 'data' => [] ]);
            }
            if (!empty($user) && $user->status == $inactive) {
                return response()->json(['status' => false, 'code'=>404,
                'message' => trans('message.not_authorization'), 'data' => [] ]);
            }
        }catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['status' => false, 'code'=>498,
                'message' => trans('message.invalid_token'), 'data' => [] ]);
            }elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['status' => false, 'code'=>440,
                'message' => trans('message.session_expired'), 'data' => [] ]);
            }else {
                return response()->json(['status' => false, 'code'=>401,
                'message' => trans('message.Authorization_not_found'), 'data' => [] ]);
            }
        }
        return $next($request);
    }
}
