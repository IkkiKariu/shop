<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\QueryException;
use App\Models\PersonalAccessToken;
use App\Models\User;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $guessedToken = $request->bearerToken();    
        if (!$guessedToken)
        {
            return response()->json(['response_status' => 'failure', 'message' => 'authentication token is required'])->setStatusCode(401);
        }
        
        try {
            $token = PersonalAccessToken::where('token', hash('sha256', $guessedToken))->first();

            if (!$token)
            {
                return response()->json(['response_status' => 'failure', 'message' => 'authentication token is invalid'])->setStatusCode(401);
            }
        } catch (QueryException $ex) {
            return response()->json(['response_status' => 'failure', 'message' => 'authentication token is invalid'])->setStatusCode(401);
        }

        return $next($request);
    }
}
