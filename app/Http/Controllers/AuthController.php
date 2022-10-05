<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Fridge;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create User
     * @param Request $request
     * @return User 
     */
    public function createUser(Request $request)
    {
        try {

            //Validated
            $validateUser = Validator::make($request->all(), 
            [
                'nickname' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]);

            $user = User::where('nickname', '=', $request->nickname)->first();

            if($user){
                return response()->json([
                    'status' => false,
                    'message' => "Ce nom d'utilisateur est déjà utilisé.",
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Erreur de validation.',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'nickname' => $request->nickname,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            
            $fridge = Fridge::create([
                'user_id' => $user->id,
            ]);
            

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken,
                'user' => $user,
                'fridge' => $fridge,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Erreur de validation.',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => "L'email où le mot de passe ne correspondent pas.",
                ], 401);
            }

            $user = User::where('email', $request->email)->first();
            $fridge = Fridge::where('user_id', $user->id)->first();

            return response()->json([
                'status' => true,
                'message' => 'Authentification réussie.',
                'token' => $user->createToken("API TOKEN")->plainTextToken,
                'user' => $user,
                'fridge' => $fridge,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}