<?php

namespace App\Services;

use App\Models\PersonalAccessToken;
use App\Models\User;

class UserService
{
    public function delete(string $token)
    {
        $user = $this->retrieveByToken($token);
        if (!$user)
        {
            return false;   
        }

        $user->tokens()->delete();
        $user->delete();

        return true;
    }

    public function retrieveByToken(string $token)
    {
        $tokenModel = PersonalAccessToken::where('token', hash('sha256', $token))->first();

        $userModel = User::where('id', $tokenModel->tokenable_id)->first();
        
        return $userModel;
    }
}