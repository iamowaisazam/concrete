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
                'user' => new UserProfileResource($user),
            ],
        ]);

    }

      public function profileUpdate(Request $request)
    {   

        $user = $request->user();
        $validator = Validator::make($request->all(),[
                'companyName' => 'required|string|max:255',
                'companyAddress1' => 'required|string|max:255',
                'companyAddress2' => 'required|string|max:255',
                'businessType' => 'required|string|max:255',
                'companyReg' => 'required|string|max:255',
                'townCity' => 'required|string|max:255',
                'country' => 'required|string|max:255',
                'website' => 'required|url',
                'postcode' => 'required|string|max:255',
                'telephone' => 'required|string|max:255',
                'businessEmail' => ['required','string','email','max:255',Rule::unique('users', 'businessEmail')->ignore($user->id)],
                'motorTradeInsurance' => 'required|string|max:255',
                'vatNumber' => 'required|string|max:255',

                'firstName' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'jobTitle' => 'required|string|max:255',
                'source' => 'nullable|string|max:255',
                'phone' => 'required|string|max:255',
                
                // 'avatar' => 'required|file|mimes:jpg,png,pdf|max:4096',
                // 'motorTradeProof' => 'nullable|file|mimes:jpg,png,pdf|max:4096',
                // 'addressProof' => 'nullable|file|mimes:jpg,png,pdf|max:4096',

                'personalEmail' => ['required','string','email','max:255',Rule::unique('users', 'businessEmail')->ignore($user->id)],
                'password' => 'string|min:6',
            ],
            [],
            [
                'companyName' => 'Company Name',
                'companyAddress1' => 'Address Line 1',
                'companyAddress2' => 'Address Line 2',
                'townCity' => 'Town or City',
                'country' => 'Country',
                'postcode' => 'Postcode',
                'telephone' => 'Telephone Number',
                'businessType' => 'Business Type',
                'companyReg' => 'Company Registration Number',
                'website' => 'Company Website',
                'businessEmail' => 'Business Email',
                'motorTradeInsurance' => 'Motor Trade Insurance',
                'vatNumber' => 'VAT Number',
                'firstName' => 'First Name',
                'surname' => 'Surname',
                'jobTitle' => 'Job Title',
                'password' => 'Password',
                'phone' => 'Phone Number',
                'personalEmail' => 'Personal Email',
                'password' => 'Password',
                'uploadID' => 'Upload ID',
                'motorTradeProof' => 'Motor Trade Proof',
                'addressProof' => 'Address Proof',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        // dd($request->all());


        //Profile Company
        $user->companyName = $request->companyName;
        $user->companyAddress1 = $request->companyAddress1;
        $user->companyAddress2 = $request->companyAddress2;
        $user->businessType = $request->businessType;
        $user->companyReg = $request->companyReg;
        $user->website = $request->website;
        $user->businessEmail = $request->businessEmail;
        $user->motorTradeInsurance = $request->motorTradeInsurance;
        $user->vatNumber = $request->vatNumber;
        $user->townCity = $request->townCity;
        $user->country = $request->country;
        $user->postcode = $request->postcode;
        $user->telephone = $request->telephone;
        

        //Profile
        $user->firstName = $request->firstName;
        $user->surname = $request->surname;
        $user->jobTitle = $request->jobTitle;
        $user->title = $request->jobTitle;
        $user->source = $request->source;
        $user->phone = $request->phone;
        
      
        if ($request->file('uploadID')) {
            // Remove existing thumbnail if it exists
            if ($user->avatar && file_exists(public_path('uploads/' . $user->uploadID))) {
                unlink(public_path('uploads/' . $user->uploadID));
            }
            $fileName = time() . '__ff__' . $request->file('uploadID')->getClientOriginalName();
            $filePath = public_path('uploads/uploadID');
            $request->file('uploadID')->move($filePath, $fileName);
            $user->uploadID = $fileName;
        }

         if ($request->file('avatar')) {
            // Remove existing thumbnail if it exists
            if ($user->avatar && file_exists(public_path('uploads/' . $user->avatar))) {
                unlink(public_path('uploads/' . $user->avatar));
            }
            $fileName = time() . '__ff__' . $request->file('avatar')->getClientOriginalName();
            $filePath = public_path('uploads/avatar');
            $request->file('avatar')->move($filePath, $fileName);
            $user->avatar = $fileName;
        }

        //License
        if ($request->file('motorTradeProof')) {
            // Remove existing thumbnail if it exists
            if ($user->motorTradeProof && file_exists(public_path('uploads/' . $user->motorTradeProof))) {
                unlink(public_path('uploads/' . $user->motorTradeProof));
            }
            $fileName = time() . '__ff__' . $request->file('motorTradeProof')->getClientOriginalName();
            $filePath = public_path('uploads/motorTradeProof');
            $request->file('motorTradeProof')->move($filePath, $fileName);
            $user->motorTradeProof = $fileName;
        }

        if ($request->file('addressProof')) {
            // Remove existing thumbnail if it exists
            if ($user->addressProof && file_exists(public_path('uploads/' . $user->addressProof))) {
                unlink(public_path('uploads/' . $user->addressProof));
            }
            $fileName = time() . '__ff__' . $request->file('addressProof')->getClientOriginalName();
            $filePath = public_path('uploads/addressProof');
            $request->file('addressProof')->move($filePath, $fileName);
            $user->addressProof = $fileName;
        }

        //Account
        $user->personalEmail = $request->personalEmail;
        if($request->password) {
            $user->password = Hash::make($request->password);
        }
        
        // $user->email_verification_token = null;
        // $user->email_verification_token_status = 1;
        // $user->status = 1;
        // $user->user_type = 0;

        $user->save();

   
        return response()->json([
            'message' => "Profile Updated Successfuly",
            'data' =>[
                'user' => new UserProfileResource($user),
            ],  
        ],200);


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
                        'user' => new UserProfileResource($user),
                        'token' => $token
                    ],
                ]);
        }

        return response()->json([
            'message' => 'Login Request Failed Contact To Support',
        ],422);

    }



     public function register(Request $request)
    {   
        $validator = Validator::make($request->all(),[
                'companyName' => 'required|string|max:255',
                'companyAddress1' => 'required|string|max:255',
                'companyAddress2' => 'required|string|max:255',
                'businessType' => 'required|string|max:255',
                'companyReg' => 'required|string|max:255',
                'townCity' => 'required|string|max:255',
                'country' => 'required|string|max:255',
                'website' => 'required|url',
                'postcode' => 'required|string|max:255',
                'telephone' => 'required|string|max:255',
                'businessEmail' => 'required|string|email|max:255|unique:users',
                'motorTradeInsurance' => 'required|string|max:255',
                'vatNumber' => 'required|string|max:255',

                'firstName' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'jobTitle' => 'required|string|max:255',
                'source' => 'required|string|max:255',
                'phone' => 'required|string|max:255',
                'avatar' => 'required|file|mimes:jpg,png,pdf|max:4096',

                'motorTradeProof' => 'nullable|file|mimes:jpg,png,pdf|max:4096',
                'addressProof' => 'nullable|file|mimes:jpg,png,pdf|max:4096',

                'personalEmail' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string',
            ],
            [],
            [
                'companyName' => 'Company Name',
                'companyAddress1' => 'Address Line 1',
                'companyAddress2' => 'Address Line 2',
                'townCity' => 'Town or City',
                'country' => 'Country',
                'postcode' => 'Postcode',
                'telephone' => 'Telephone Number',
                'businessType' => 'Business Type',
                'companyReg' => 'Company Registration Number',
                'website' => 'Company Website',
                'businessEmail' => 'Business Email',
                'motorTradeInsurance' => 'Motor Trade Insurance',
                'vatNumber' => 'VAT Number',
                'firstName' => 'First Name',
                'surname' => 'Surname',
                'jobTitle' => 'Job Title',
                'password' => 'Password',
                'phone' => 'Phone Number',
                'personalEmail' => 'Personal Email',
                'password' => 'Password',
                'uploadID' => 'Upload ID',
                'motorTradeProof' => 'Motor Trade Proof',
                'addressProof' => 'Address Proof',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        // dd($request->all());


        //Profile Company
        $user = new User();
        $user->companyName = $request->companyName;
        $user->companyAddress1 = $request->companyAddress1;
        $user->companyAddress2 = $request->companyAddress2;
        $user->businessType = $request->businessType;
        $user->companyReg = $request->companyReg;
        $user->website = $request->website;
        $user->businessEmail = $request->businessEmail;
        $user->motorTradeInsurance = $request->motorTradeInsurance;
        $user->vatNumber = $request->vatNumber;
        $user->townCity = $request->townCity;
        $user->country = $request->country;
        $user->postcode = $request->postcode;
        $user->telephone = $request->telephone;
        

        //Profile
        $user->firstName = $request->firstName;
        $user->surname = $request->surname;
        $user->jobTitle = $request->jobTitle;
        $user->title = $request->jobTitle;
        $user->source = $request->source;
        $user->phone = $request->phone;
        if ($request->file('avatar')) {
            // Remove existing thumbnail if it exists
            if ($user->avatar && file_exists(public_path('uploads/' . $user->avatar))) {
                unlink(public_path('uploads/' . $user->avatar));
            }
            $fileName = time() . '__ff__' . $request->file('avatar')->getClientOriginalName();
            $filePath = public_path('uploads/avatar');
            $request->file('avatar')->move($filePath, $fileName);
            $user->avatar = $fileName;
        }

        //License
        if ($request->file('motorTradeProof')) {
            // Remove existing thumbnail if it exists
            if ($user->motorTradeProof && file_exists(public_path('uploads/' . $user->motorTradeProof))) {
                unlink(public_path('uploads/' . $user->motorTradeProof));
            }
            $fileName = time() . '__ff__' . $request->file('motorTradeProof')->getClientOriginalName();
            $filePath = public_path('uploads/motorTradeProof');
            $request->file('motorTradeProof')->move($filePath, $fileName);
            $user->motorTradeProof = $fileName;
        }

        if ($request->file('addressProof')) {
            // Remove existing thumbnail if it exists
            if ($user->addressProof && file_exists(public_path('uploads/' . $user->addressProof))) {
                unlink(public_path('uploads/' . $user->addressProof));
            }
            $fileName = time() . '__ff__' . $request->file('addressProof')->getClientOriginalName();
            $filePath = public_path('uploads/addressProof');
            $request->file('addressProof')->move($filePath, $fileName);
            $user->addressProof = $fileName;
        }

        //Account
        $user->personalEmail = $request->personalEmail;
        if($request->password) {
            $user->password = Hash::make($request->password);
        }
        
        $user->email_verification_token = null;
        $user->email_verification_token_status = 1;
        $user->status = 1;
        $user->user_type = 0;
        $user->save();

        $token = $user->createToken('autoboli_token')->plainTextToken;   
        return response()->json([
            'message' => "User Created Successfuly",
            'data' =>[
                'user' => new UserProfileResource($user),
                'token' => $token
            ],  
        ],200);



   
        // if ($request->plan_id == 2) {

        //     $user = $this->AccountCreate($request);
        //     $transactionId = "00";
        //     $this->planCreate($user, $transactionId, $plan, $request);
        //     Auth::login($user);

        //     return response()->json([
        //         'message' => 'Registration Successful.',
        //     ], 201);
        // } else {

        //     $validator = Validator::make($request->all(), [
        //         'payment_method' => 'required|string',
        //     ]);

        //     if ($validator->fails()) {
        //         return response()->json([
        //             'message' => 'Request Failed',
        //             'errors' => $validator->errors()
        //         ], 422);
        //     }
        // }




        //Stripe Process

        // Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        // try {

        //     $intent = PaymentIntent::create([
        //         'amount' => round($plan->price * 100),
        //         'currency' => 'gbp',
        //         'automatic_payment_methods' => [
        //             'enabled' => true,
        //             'allow_redirects' => 'never',
        //         ],
        //         'confirm' => true,
        //         'payment_method' => $request->payment_method
        //     ]);
        // } catch (\Exception $e) {
        //     return response()->json([
        //         "message" => $e->getMessage(),
        //     ], 500);
        // }


        // if ($intent->status == 'succeeded') {

        //     $user = $this->AccountCreate($request);
        //     $transactionId = $intent->latest_charge;
        //     $this->planCreate($user, $transactionId, $plan, $request);
        //     Auth::login($user);

        //     return response()->json([
        //         'message' => 'Registration and payment successful.',
        //     ], 201);
        // } elseif ($intent->status == 'requires_action' && $intent->next_action->type == 'use_stripe_sdk') {

        //     return response()->json([
        //         "message" => "Additional authentication is required (e.g. 3D Secure).",
        //     ], 500);
        // } else {

        //     $errorMessage = $intent->last_payment_error->message ?? 'Payment failed or incomplete.';
        //     return response()->json([
        //         'message' => $errorMessage,
        //         'status' => $intent->status,
        //     ], 500);
        // }


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

