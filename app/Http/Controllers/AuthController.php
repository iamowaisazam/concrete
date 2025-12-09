<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Plan;
use App\Models\Auction;
use App\Http\Controllers\DeviceController;
use App\Models\Membership;
use App\Models\MembershipPayment;
use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use DataTables;
use Illuminate\Support\Facades\Hash as FacadesHash;
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




class AuthController extends Controller
{


    public function checkout(Request $request)
    {

        if ($request->isMethod('post')) {

            // dd($request->all());

            $validator = Validator::make(
                $request->all(),
                [
                    "first_name" => 'required|string',
                    "last_name" => 'required|string',
                    "phone" => 'required|string',
                    "country" => 'required|string',
                    "state" => 'required|string',
                    "city" => 'required|string',
                    "zip_code" => 'required|string',
                    "address" => 'required|string',
                ],
                [],
                [
                    "first_name" => 'First Name',
                    "last_name" => 'Last Name',
                    "phone" => 'Phone',
                    "country" => 'Country',
                    "state" => 'State',
                    "city" => 'City',
                    "zip_code" => 'Zip Code',
                    "address" => 'Address',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Request Failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $plan = Plan::find($request->plan_id);
            if (!$plan) {
                return response()->json([
                    'message' => 'Plan Not Found',
                ], 422);
            }



            if ($plan->id == 2) {

                $transactionId = "";
                $this->planCreate($transactionId, $plan, $request);
                return response()->json([
                    'message' => 'Registration and payment successful.',
                ], 201);
            }


            if (!$request->payment_method) {
                return response()->json([
                    'message' => 'Add Payment Details',
                ], 422);
            }

            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            try {

                $intent = PaymentIntent::create([
                    'amount' => round($plan->price * 100),
                    'currency' => 'gbp',
                    'automatic_payment_methods' => [
                        'enabled' => true,
                        'allow_redirects' => 'never',
                    ],
                    'confirm' => true,
                    'payment_method' => $request->payment_method
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    "message" => $e->getMessage(),
                ], 500);
            }



            if ($intent->status == 'succeeded') {

                $transactionId = $intent->latest_charge;
                $this->planCreate($transactionId, $plan, $request);
                return response()->json([
                    'message' => 'Registration and payment successful.',
                ], 201);
            } elseif ($intent->status == 'requires_action' && $intent->next_action->type == 'use_stripe_sdk') {

                return response()->json([
                    "message" => "Additional authentication is required (e.g. 3D Secure).",
                ], 500);
            } else {

                $errorMessage = $intent->last_payment_error->message ?? 'Payment failed or incomplete.';
                return response()->json([
                    'message' => $errorMessage,
                    'status' => $intent->status,
                ], 500);
            }


            return response()->json([
                'message' => 'Successfull',
            ], 200);
        }
        // _____________________________________________


        $plans = Plan::all();
        return view('web.checkout', compact('plans'));
    }


    private function planCreate($transactionId, $plan, $request)
    {


        $user = Auth::user();
        $startDate = now();
        $expiryDate = now()->addMonths($plan->duration_value);

        $membership = Membership::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'membership_start_date' => $startDate,
            'membership_expiry_date' => $expiryDate,
            'membership_status' => 'Pending',
            'membership_type' => 'monthly',
        ]);

        MembershipPayment::create([
            'membership_id' => $membership->id,
            'payment_date' => now(),
            'payment_method' => 'stripe',
            'transaction_id' => $transactionId,
            'charge_id' => $transactionId,
            'payer_id' => $transactionId,
            'amount' => $plan->price,
            'currency' => 'GBP',
            'payment_status' => 'Completed',
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'zip_code' => $request->zip_code,
            'address' => $request->address,
        ]);

        $membership->update(['membership_status' => 'Active']);
    }


    public function register(Request $request)
    {
        $id = $request->input('plan_id');

        // if (Auth::check()) {
        //     return redirect('/dashboard')->with('message', 'You are already logged in.');
        // }

        $plans = Plan::where('status', 1)->orderBy('sort_by')->get();

        return view('web.register', compact('plans', 'id'));
    }


    public function register_submit(Request $request)
    {
        if (Auth::check()) {
            return redirect('/dashboard')->with('message', 'You are already logged in.');
        }

        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6',
            'companyName' => 'required|string|max:255',
            'companyAddress1' => 'required|string|max:255',
            'companyAddress2' => 'nullable|string|max:255',
            'townCity' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'postcode' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
            'businessType' => 'required|string|max:255',
            'companyReg' => 'required|string|max:255',
            'website' => 'required|url',
            'businessEmail' => 'required|string|email|max:255|unique:users',
            'motorTradeInsurance' => 'required|string|max:255',
            'vatNumber' => 'required|string|max:255',
            'firstName' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'personalEmail' => 'required|string|email|max:255|unique:users',
            'avatar' => 'required|file|mimes:jpg,png,pdf|max:4096',
            'proof_motor_trade' => 'required|file|mimes:jpg,png,pdf|max:4096',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // âœ… Create user
        $user = new User();
        $user->fill($request->only([
            'companyName',
            'businessType',
            'companyReg',
            'website',
            'businessEmail',
            'motorTradeInsurance',
            'vatNumber',
            'companyAddress1',
            'companyAddress2',
            'townCity',
            'country',
            'postcode',
            'telephone',
            'firstName',
            'surname',
            'title',
            'phone',
            'personalEmail'
        ]));
        $user->jobTitle = $request->input('title');
        $user->user_type = 0;
        $user->email_verification_token_status = 0;
        $user->password = Hash::make($request->password);
        $user->email_verification_token = strtoupper(Str::random(6));

        // âœ… Avatar upload
        if ($request->file('avatar')) {
            $fileName = time() . '__' . $request->file('avatar')->getClientOriginalName();
            $filePath = public_path('uploads/avatar');
            $request->file('avatar')->move($filePath, $fileName);
            $user->avatar = $fileName;
        }
        if ($request->file('proof_motor_trade')) {
            $fileName = time() . '__' . $request->file('proof_motor_trade')->getClientOriginalName();
            $filePath = public_path('uploads/avatar');
            $request->file('proof_motor_trade')->move($filePath, $fileName);
            $user->avatar = $fileName;
        }

        $user->save();


        try {
            Mail::to($user->personalEmail)->send(new VerifyEmail($user));
        } catch (\Exception $e) {
            \Log::error('Email sending failed: ' . $e->getMessage());
        }


        $verifyUrl = route('verify.email.show', ['email' => $user->personalEmail]);

        return response()->json([
            'success' => true,
            'redirect_url' => $verifyUrl,
            'message' => 'Please verify your email'
        ]);
    }

    public function show($email)
    {

        $user = User::where('personalEmail', $email)->first();
        if (!$user) {
            return redirect('/login')->with('error', 'User not found.');
        }
        if ($user->email_verification_token_status != 0 || !$user->email_verification_token) {
            return redirect('/login')->with('error', 'Email already verified or no verification token found.');
        }
        return view('auth.verify-email', [
            'email' => $user->personalEmail
        ]);
    }


    public function resendToken(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('personalEmail', $request->email)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Email not found.']);
        }

        if ($user->status == 0) {
            return response()->json(['success' => false, 'message' => 'Account is blocked.']);
        }


        if ($user->last_resend_at && !Carbon::parse($user->last_resend_at)->isToday()) {
            $user->resend_count = 0;
        }


        $user->resend_count += 1;
        $user->last_resend_at = now();


        if ($user->resend_count > 3) {
            $user->status = 0;
            $user->save();
            return response()->json([
                'success' => false,
                'message' => 'Too many resend attempts. Your account has been blocked.'
            ]);
        }


        $token = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6));
        $user->email_verification_token = $token;
        $user->save();


        Mail::to($user->personalEmail)->send(new VerifyEmail($user));

        return response()->json([
            'success' => true,
            'message' => 'Verification code sent successfully.',
            'resend_count' => $user->resend_count
        ]);
    }




    public function verifyToken(Request $request)
    {
        $request->validate([
            'token' => 'required|size:6',
            'email' => 'required|email',
        ]);

        $user = User::where('personalEmail', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ], 404);
        }


        if ($user->status == 0) {
            if ($user->last_resend_at && Carbon::parse($user->last_resend_at)->addHours(24)->isPast()) {

                $user->status = 1;
                $user->resend_count = 0;
                $user->save();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Your account is blocked. Please try again after 24 hours or contact support.'
                ], 403);
            }
        }


        if ($user->email_verification_token !== $request->token) {
            $user->resend_count = $user->resend_count + 1;

            if ($user->resend_count >= 3) {
                // Block the user & save time
                $user->status = 0;
                $user->last_resend_at = Carbon::now();
                $user->save();

                return response()->json([
                    'success' => false,
                    'message' => 'Too many invalid attempts. Your account has been blocked for 24 hours.'
                ], 403);
            }

            $user->save();

            return response()->json([
                'success' => false,
                'message' => 'Invalid verification code. Attempt ' . $user->resend_count . ' of 3.'
            ], 422);
        }


        $user->email_verification_token_status = 1;
        $user->resend_count = 0;
        $user->save();

        Auth::login($user);

        return response()->json([
            'success' => true,
            'message' => 'Email verified successfully!',
            'redirect_url' => url('/dashboard')
        ]);
    }



    public function register_submit1(Request $request)
    {
        if (Auth::check()) {
            return redirect('/dashboard')->with('message', 'You are already logged in.');
        }

        $validator = Validator::make(
            $request->all(),
            [
                'payment_method' => 'nullable|string',
                'password' => 'required|string',
                'companyName' => 'required|string|max:255',
                'companyAddress1' => 'required|string|max:255',
                'companyAddress2' => 'required|string|max:255',
                'townCity' => 'required|string|max:255',
                'country' => 'required|string|max:255',
                'postcode' => 'required|string|max:255',
                'telephone' => 'required|string|max:255',
                'businessType' => 'required|string|max:255',
                'companyReg' => 'required|string|max:255',
                'plan_id' => 'required',
                'website' => 'required|url',
                'businessEmail' => 'required|string|email|max:255|unique:users',
                'motorTradeInsurance' => 'required|string|max:255',
                'vatNumber' => 'required|string|max:255',

                'firstName' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'title' => 'required|string|max:255',
                'jobTitle' => 'required|string|max:255',

                'phone' => 'required|string|max:255',
                'personalEmail' => 'required|string|email|max:255|unique:users',

                'uploadID' => 'required|file|mimes:jpg,png,pdf|max:4096',
                'motorTradeProof' => 'required|file|mimes:jpg,png,pdf|max:4096',
                'addressProof' => 'required|file|mimes:jpg,png,pdf|max:4096',
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
                'title' => 'Title',
                'jobTitle' => 'Job Title',
                'password' => 'Password',
                'plan_id' => 'Plan',
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
                'message' => 'Request Failed',
                'errors' => $validator->errors()
            ], 422);
        }


        $plan = Plan::find($request->plan_id);
        if (!$plan) {
            return response()->json([
                'message' => 'Plan Not Found',
            ], 422);
        }


        if ($request->plan_id == 2) {

            $user = $this->AccountCreate($request);
            $transactionId = "00";
            $this->planCreate($user, $transactionId, $plan, $request);
            Auth::login($user);

            return response()->json([
                'message' => 'Registration Successful.',
            ], 201);
        } else {

            $validator = Validator::make($request->all(), [
                'payment_method' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Request Failed',
                    'errors' => $validator->errors()
                ], 422);
            }
        }




        //Stripe Process

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        try {

            $intent = PaymentIntent::create([
                'amount' => round($plan->price * 100),
                'currency' => 'gbp',
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never',
                ],
                'confirm' => true,
                'payment_method' => $request->payment_method
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage(),
            ], 500);
        }


        if ($intent->status == 'succeeded') {

            $user = $this->AccountCreate($request);
            $transactionId = $intent->latest_charge;
            $this->planCreate($user, $transactionId, $plan, $request);
            Auth::login($user);

            return response()->json([
                'message' => 'Registration and payment successful.',
            ], 201);
        } elseif ($intent->status == 'requires_action' && $intent->next_action->type == 'use_stripe_sdk') {

            return response()->json([
                "message" => "Additional authentication is required (e.g. 3D Secure).",
            ], 500);
        } else {

            $errorMessage = $intent->last_payment_error->message ?? 'Payment failed or incomplete.';
            return response()->json([
                'message' => $errorMessage,
                'status' => $intent->status,
            ], 500);
        }
    }




    // Login

    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect('/dashboard')->with('message', 'You are already logged in.');
        }

        return view('web.login');
    }



    public function login_submit(Request $request)
    {

        if (Auth::check()) {
            return redirect('/dashboard')->with('message', 'You are already logged in.');
        }

        // dd($request->email);

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);



        // Find the user with personalEmail and user_type = 0
        $user = User::where('personalEmail', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User not found or not authorized.');
        }

        // Check user account status


        if ($user->email_verification_token_status == 0) {
            return response()->json([
                'success' => false,
                'message' => 'This user verification not be done'
            ], 403);
        }

        if ($user->status == 0) {
            return redirect()->back()->with('error', 'Your account is deactivated or blocked. Please contact support.');
        }

        // Check membership status
        // $membership = \DB::table('memberships')
        //                 ->where('user_id', $user->id)
        //                 ->where('membership_status', 'Active')
        //                 ->whereDate('membership_start_date', '<=', now())
        //                 ->whereDate('membership_expiry_date', '>=', now())
        //                 ->first();

        // if (!$membership) {
        //     return redirect()->back()->with('error', 'No active membership found. Please subscribe or renew your plan.');
        // }

        // Check credentials
        if (Auth::attempt(['personalEmail' => $request->email, 'password' => $request->password])) {
            $deviceController = new DeviceController();
            $deviceController->storeDeviceInfo($request);
            return redirect()->intended('dashboard');
        } else {
            return redirect()->back()->with('error', 'Invalid credentials. Please try again.');
        }
    }



    public function forgotpassword()
    {
        return view('user.forgetPassword.forgetPassword');
    }


    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,personalEmail',
        ]);

        $email = $request->email;
        $token = Str::random(64);

        DB::table('password_reset_tokens')->where('email', $email)->delete();

        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        $resetLink = url('/reset-password-form?token=' . $token . '&email=' . urlencode($email));

        Mail::to($email)->send(new PasswordResetMail($resetLink));
        return response()->json(['message' => 'Reset link sent successfully!']);
    }

    public function resetpasswordvalidation(Request $request)
    {
        $token = $request->query('token');
        $email = $request->query('email');

        if (!$token || !$email) {
            abort(400, 'Invalid reset link.');
        }
        $exists = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('token', $token)
            ->first();

        if (!$exists) {
            abort(403, 'This password reset link is invalid or has expired.');
        }

        return view('user.forgetPassword.resetfrom', compact('token', 'email'));
    }

    public function resetpasswordsubmit(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:users,personalEmail',
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $tokenData = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$tokenData) {
            return response()->json(['message' => 'Invalid or expired token.'], 422);
        }

        User::where('personalEmail', $request->email)
            ->update(['password' => FacadesHash::make($request->password)]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json(['message' => 'Password reset successfully!']);
    }
}