<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
    * Register a user.
    *
    * @param Illuminate\Http\Request $request
    * @return Illuminate\Http\Response
    */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name'  => 'required|max:50',
            'email' => 'email|required',
            'password' => 'required|confirmed'
        ]);

        try {
            DB::beginTransaction();

            $validatedData['password'] = bcrypt($request->password);

            $user = User::create($validatedData);
            
            $tokens = $this->createToken($user);

            DB::commit();

            return response([
                'user'          => $user,
                'access_token'  => $tokens->accessToken,
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();

            return response([
                'message' => $e->getMessage(),
            ], 442);
        }
    }

    /**
    * Login user.
    *
    * @param Illuminate\Http\Request $request
    * @return Illuminate\Http\Response
    */
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response([
                'message' => 'Invalid Credentials'
            ], 422);
        }

        $user = auth()->user();

        $tokens = $this->createToken($user);

        return response([
            'user'          => auth()->user(),
            'access_token'  => $tokens->accessToken,
        ], 200);
    }

    /**
    * Get authenticated user.
    *
    * @param void
    * @return Illuminate\Http\Response
    */
    public function authUser()
    {
        $user = Auth::user();

        return response([
            'user' => $user,
        ], 200);
    }

    /**
    * Create Access Token
    *
    * @param App\User $user
    * @return object
    */
    public function createToken($user)
    {
        return $user->createToken('authToken');
    }
}
