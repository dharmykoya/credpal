<?php


namespace App\Repositories;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class UserRepository
{
    public function createUser($userDetail)
    {
            try {
                $user = User::create($userDetail);
                $user['token'] = $user->createToken('AppName')->accessToken;
                return ['status' => true, 'data' => $user];
            } catch (\Exception $e) {
//                dd($e);
                return ['success' => false, 'message' => 'something went wrong'];
            }

    }

    public function login($loginData)
    {

        if (!auth()->attempt($loginData)) {
            return ['status' => false, 'message' => 'Invalid Credentials'];
        }

        $user = auth()->user();
        $user['token'] = auth()->user()->createToken('credPal')->accessToken;

        return ['status' => true, 'user' => $user];

    }
}
