<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\users;
use Validator;
use App\Models\Professeur;
use App\Models\Etudiant;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register_prof','register_etudiant']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register_prof(Request $request) {
        $validator = Validator::make($request->all(), [
            'utilisateur' => 'required|string|between:2,100',
            'prenom' => 'required|string|between:2,100',
            'nom' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = users::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));


                Professeur::create([
                    'nom' => $request->input('nom'),
                    'prenom'=>$request->input('prenom'),
                    'email' => $request->input('email'),
                    'user_id' => $user->id,
                ]);


        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    public function register_etudiant(Request $request) {
        $validator = Validator::make($request->all(), [
            'utilisateur' => 'required|string|between:2,100',
            'prenom' => 'required|string|between:2,100',
            'nom' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = users::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));


                Etudiant::create([
                    'nom' => $request->input('nom'),
                    'prenom'=>$request->input('prenom'),
                    'email' => $request->input('email'),
                    'user_id' => $user->id,
                ]);


        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'users' => auth()->user()
        ]);
    }

}
