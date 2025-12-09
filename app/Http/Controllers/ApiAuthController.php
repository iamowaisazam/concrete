<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Plan;
use App\Models\Auction;
use App\Http\Controllers\DeviceController;
use App\Models\Membership;
use App\Models\MembershipPayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\PasswordResetMail;
use Symfony\Component\Mime\Part\TextPart;
use Symfony\Component\Mime\Part\HtmlPart;
use App\Models\UserDevice;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Http;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Hash;


class ApiAuthController extends Controller
{


     public function profile(Request $request)
    {

            $user = $request->user();

            return response()->json([
                'message' => 'Get Profile Details',
                'account' => [
                    'name' => $user->title,
                    'email' => $user->personalEmail,
                    'phone' => $user->phone,
                    'user_type' =>  $user->user_type == 0 ? 'Admin' : 'User',
                    'avatar' => ENV('APP_URL').'public/uploads/avatar/'.$user->avatar,
                    'status' => $user->status,
                    'email_verification_token_status' => $user->email_verification_token_status,
                ],
                'business' =>[
                    
                ],
                'permissions' => [],
                'membership' => '',
                'notification' => 0,
            ]);

    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(),[
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

                //  $deviceController = new DeviceController();
                //  $deviceController->storeDeviceInfo($request);

                return response()->json([
                    'message' => 'Login Success',
                    'user' => $user,
                    'token' => $token,
                ]);
                
        }

        return response()->json([
            'message' => 'Login Request Failed Contact To Support',
        ],422);

    }

}
