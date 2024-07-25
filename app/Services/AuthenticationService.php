<?php

namespace App\Services;

use App\Models\PersonalAccessToken;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthenticationService
{
    public function authenticate(array $credentials)
    {
        if (!$this->validateData($credentials))
        {
            return null;
        }

        $guessedUser = User::where('login', $credentials['login'])->first();
        if (!$guessedUser)
        {
            return null;
        }

        if (!Hash::check($credentials['password'], $guessedUser->password))
        {
            return null;
        }

        $newToken = $guessedUser->createToken('auth_token');

        return explode('|', $newToken->plainTextToken)[1];
    }

    public function deauthenticate(string $token)
    {
        $tokenModel = PersonalAccessToken::where('token', hash('sha256', $token))->first();

        $userModel = User::where('id', $tokenModel->tokenable_id)->first();
        if (!$userModel)
        {
            return false;
        }

        $userModel->tokens()->where('id', $tokenModel->id)->delete();

        return true;
    }

    private function validateData(array $data)
    {
        $validationRules = [
            'login' => 'required|alpha_num|min:8|max:128',
            'password' => 'required|alpha_num|min:8|max:128'
        ];

        $validator = Validator::make($data, $validationRules);
        if($validator->fails()) { return false; }

        return true;
    }
}