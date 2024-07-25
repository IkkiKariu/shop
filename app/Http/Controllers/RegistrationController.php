<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RegistrationService;

class RegistrationController extends Controller
{
    private RegistrationService $registrationService;

    public function __construct(RegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    public function store(Request $request)
    {
        $data = $request->json()->all();

        $newUser = $this->registrationService->register($data);

        return $newUser ? response()->json([
            'response_status' => 'success', 'message' => 'user registration succed', 'data' => ['newUser' => $newUser]
        ]) : response()->json(['response_status' => 'failure', 'message' => 'user registration failed']);
    }
}
