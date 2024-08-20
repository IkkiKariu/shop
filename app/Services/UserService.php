<?php

namespace App\Services;

use App\Models\PersonalAccessToken;
use App\Models\User;

class UserService
{
    public function delete(string $token)
    {
        $user = $this->retrieveUserModel($token);
        if (!$user)
        {
            return false;   
        }

        $user->tokens()->delete();
        $user->delete();

        return true;
    }

    private function retrieveUserModel(string $token, ?array $properties = null)
    {
        $tokenModel = PersonalAccessToken::where('token', hash('sha256', $token))->first();

        if ($properties) 
        {
            $userModel = User::where('id', $tokenModel->tokenable_id)->select($properties)->first();
        } 
        else {
            $userModel = User::where('id', $tokenModel->tokenable_id)->first();
        }
        
        return $userModel;
    }

    public function retrieveCredentials(string $token)
    {
        $tokenModel = PersonalAccessToken::where('token', hash('sha256', $token))->first();

        $userModel = $this->retrieveUserModel($token, ['id', 'login', 'name', 'email', 'created_at', 'updated_at']);

        return $userModel->toArray();
    } 
}