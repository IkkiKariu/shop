<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegistrationService
{
    public function register(array $userData)
    {
        $validatedSucced = $this->validateData($userData);
        if (!$validatedSucced) { return null; }

        $newUser = new User();
        $newUser->login = $userData['login'];
        $newUser->password = Hash::make($userData['password']);
        $newUser->name = $userData['name'];
        if (key_exists('email', $userData))
        {
            $newUser->email = $userData['email'];
        }    
        $newUser->save();

        return $newUser->toArray();
    }

    private function validateData(array $data)
    {
        $validationRules = [
            'login' => 'required|alpha_num|min:8|max:128|unique:users,login',
            'password' => 'required|alpha_num|min:8|max:128',
            'name' => 'required|alpha_num|min:3|max:64',
            'email' =>'email|unique:users,email' 
        ];
        $validator = Validator::make($data, $validationRules);
        if($validator->fails()) { return false; }

        return true;
    }
}