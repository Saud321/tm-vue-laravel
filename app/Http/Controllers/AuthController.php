<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)  :JsonResponse
    {

        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => ['required', 'email', 'unique:users'],
                'password' => 'required',
            ]);

            if($validator->fails()){
                return response()->json([
                    'success' => false,
                    'message' => 'Validation Error.',
                    'data' => $validator->errors()

                ], 400);
            }


            $input = $request->all();
            $input['password'] = bcrypt($input['password']);

            $user = User::create($input);

            $success['name'] =  $user->name;

            return response()->json([
                'success' => true,
                'Message' => 'User register successfully.',
                'data' => $success
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function login(LoginRequest $request)  :JsonResponse {
        try {

            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

                $user = Auth::user();
                $success['token'] =  $user->createToken('auth_token')->plainTextToken;
                $success['name'] =  $user->name;

                return response()->json([
                    'success' => true,
                    'Message' => 'User login successfully.',
                    'data' => $success
                ], 200);

            } else {
                return response()->json([
                    'success' => true,
                    'Message' => 'Unauthorised',
                    'data' =>  ['error'=>'Unauthorised']
                ], 401);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function user(Request $request): JsonResponse {
        try {
            return response()->json($request->user());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function logout(Request $request)  :JsonResponse {
        try {


            if(Auth::user()) {

                $user = Auth::user();
                $user->tokens()->delete();

                return response()->json([
                    'success' => true,
                    'Message' => '`User logout successfully.',
                    'data' => []
                ], 200);


            } else {

                return response()->json([
                    'success' => true,
                    'Message' => 'Unauthorised',
                    'data' =>  ['error'=>'Unauthorised']
                ], 200);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
