<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserProfileResource;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{


     public function profile(Request $request)
    {

        $user = $request->user();
        return response()->json([
            'message' => 'Get Profile Details',
            'data' => [
                'user' => $user
            ],
        ]);

    }


 


    public function login(Request $request)
    {

        $validator = Validator::make($request->all(),
        [
            "email" => 'required|string',
            "password" => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Find the user with personalEmail and user_type = 0
        $user = User::where('personalEmail', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found or not authorized.',], 422);
        }

        if ($user->email_verification_token_status == 0) {
            return response()->json(['message' => 'This user verification not be done',], 422);
        }

        if ($user->status == 0) {
            return response()->json(['message' => 'Your account is deactivated or blocked. Please contact support.',], 422);
        }


        if (Hash::check($request->password, $user->password)) {
                // Create token
                $token = $user->createToken('autoboli_token')->plainTextToken;
                return response()->json([
                    'message' => 'Login Success',
                    'data' =>[
                        'user' =>$user,
                        'token' => $token
                    ],
                ]);
        }

        return response()->json([
            'message' => 'Login Request Failed Contact To Support',
        ],422);

    }


 
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|min:6|string',
            'new_password' => 'required|string|min:6|confirmed', // password_confirmation field required
        ]);

        $user = $request->user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'Current password does not match'
            ], 422);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'message' => 'Password changed successfully'
        ], 200);
    }





}

