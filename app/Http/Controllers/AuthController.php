<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Validator;

class AuthController extends Controller
{
    //
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=> 'failed', 'message' => $validator->errors()], 422);
        }

        $userData['name'] = $request->input('name');
        $userData['email'] = $request->input('email');
        $userData['password'] = bcrypt($request->input('password'));

        if ($request->has('role')) {
            $userData['role'] = $request->input('role');
        }

        $user = $this->userRepository->createUser($userData);

        if (!$user['status']) {
            return response()->json(['status' => 'failed', 'message'=> 'something went wrong'], 500);
        }

        return response()->json(['status' => 'success', 'data'=> $user]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=> 'failed', 'message' => $validator->errors()], 400);
        }

        $loginData = $request->all();

        $user = $this->userRepository->login($loginData);

        if (!$user['status']) {
            return response()->json(['status' => 'failed', 'message'=> $user['message']], 500);
        }

        return response()->json(['status' => 'success', 'data'=> $user['user']]);

    }
}
