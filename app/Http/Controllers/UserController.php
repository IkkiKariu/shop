<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function remove(Request $request)
    {
        $token = $request->bearerToken();

        $userDeletedSuccessfully = $this->userService->delete($token);

        return $userDeletedSuccessfully ? response()->json([
            'response_status' => 'success', 'message' => 'user deleted successfully'
        ]) : response()->json(['response_status' => 'failure', 'message' => 'user deleting failed']);
    }
}
