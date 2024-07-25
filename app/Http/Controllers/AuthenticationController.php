<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\AuthenticationService;

class AuthenticationController extends Controller
{
    private AuthenticationService $authenticationService;
    
    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function authenticate(Request $request)
    {
        $data = $request->json()->all();

        $token = $this->authenticationService->authenticate($data);

        return $token ? response()->json([
            'response_status' => 'success', 'message' => 'user authentication succed', 'data' => ['token' => $token]
        ]) : response()->json(['response_status' => 'failure', 'message' => 'user authentication failed; check credentials']);
    }

    public function deauthenticate(Request $request)
    {
        $token = $request->bearerToken();

        $userDeauthenticatedSucced = $this->authenticationService->deauthenticate($token);

        return $userDeauthenticatedSucced ? response()->json([
            'response_status' => 'success', 'message' => 'user deauthentication succed'
        ]) : response()->json(['response_status' => 'failure', 'message' => 'user deauthentication failed']);
    }
}
