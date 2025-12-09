<?php
namespace App\Http\Controllers;

use App\Models\Alert;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Auction;
use App\Models\Membership;
use App\Models\Plan;
use App\Models\UserDevice;
use App\Models\Interest;
use App\Models\UserLogin;
use App\Models\UserPaymentMethod;
use App\Models\UserNotificationSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

class ProfileSettingController extends Controller
{


    
public function userProfile()
{
    $alerts = Alert::with('user')->get();
    $user = Auth::user();

    $userDevices = UserDevice::where('user_id', $user->id)
        ->orderBy('logged_in_at', 'desc')
        ->get();


$recentViews = $user->recentViews()
    ->with('vehicle')
    ->latest()
    ->take(5)
    ->get()
    ->map(function ($recent) {
        if ($recent->vehicle && $recent->vehicle->images) {
            $imagesArray = explode(',', $recent->vehicle->images);
            $recent->vehicle->first_image = $imagesArray[0]; 
        } else {
            $recent->vehicle->first_image = null;
        }
        return $recent;
    });
       $interests = Interest::with(['make', 'model', 'variant'])
        ->where('user_id', $user->id)
        ->latest()
        ->get();
      

    return view('user.account-setting.userprofile', compact('alerts', 'user', 'userDevices', 'recentViews','interests'));
}


    
    

    // Show the profile form
    public function profile(Request $request)
    {   

         $user = Auth::user();

        if($request->isMethod('post')) {

               $data = $request->validate([
                'firstName' => 'required|string|max:255',
                'lastName' => 'required|string|max:255',
                'title' => 'required|string|max:255',
                'organization' => 'required|string|max:255',
                'phoneNumber' => 'required|string|max:255',
                'companyAddress1' => 'required|string|max:255',
                'companyAddress2' => 'required|string|max:255',
                'townCity' => 'required|string|max:255',
                'country' => 'required|string|max:255',
                'zipCode' => 'required|string|max:10',
                'telephone' => 'required|string|max:255',
                'website' => 'required|string|max:255',
                'businessEmail' => 'required|string|email|max:255|unique:users,businessEmail,' . $user->id,
                'motorTradeInsurance' => 'required|string|max:255',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1000',
            ]);

    
            // Save all data to user model
            $user->update([
                'firstName' => $data['firstName'],
                'surname' => $data['lastName'],
                'title' => $data['title'],
                'jobTitle' => $data['organization'],
                'phone' => $data['phoneNumber'],
                'companyAddress1' => $data['companyAddress1'],
                'companyAddress2' => $data['companyAddress2'],
                'townCity' => $data['townCity'],
                'country' => $data['country'],
                'postcode' => $data['zipCode'],
                'telephone' => $data['telephone'],
                'website' => $data['website'],
                'businessEmail' => $data['businessEmail'],
                'motorTradeInsurance' => $data['motorTradeInsurance'], 
            ]);


            if ($request->file('avatar')) {
                // Remove existing thumbnail if it exists
                if ($user->avatar && file_exists(public_path('uploads/' . $user->avatar))) {
                    unlink(public_path('uploads/' . $user->avatar));
                }
                $fileName = time() . '__ff__' . $request->file('avatar')->getClientOriginalName();
                $filePath = public_path('uploads/avatar');
                $request->file('avatar')->move($filePath, $fileName);
                $user->avatar = $fileName;
                $user->save();
            }

            return back()->with('success','Profile Updated...');

        }


        return view('user.account-setting.profile', compact('user'));
    }


    public function changePassword(Request $request)
    {
        $user = Auth::user();

        if ($request->isMethod('post')) {

            $request->validate([
                'currentPassword' => 'required',
                'newPassword' => 'required|min:8|confirmed',
            ]);

            if (!Hash::check($request->currentPassword, $user->password)) {
                return back()->withErrors(['currentPassword' => 'Current password is incorrect.']);
            }

            $user->password = Hash::make($request->newPassword);
            $user->save();

            return back()->with('success', 'Password changed successfully.');
        }

        $userDevices = UserDevice::where('user_id', $user->id)
                        ->orderByDesc('logged_in_at')
                        ->limit(10)
                        ->get();

        return view('user.account-setting.changePassword', compact('user', 'userDevices'));
    }



 public function billing(Request $request)
{
    $user = Auth::user();

    $plans = Plan::all();
    $membership = Membership::where('user_id',$user->id)
        ->orderBy('created_at','desc')
        ->get();

    $current = Membership::where('user_id',$user->id)
        ->where('membership_status', 'Active')
        ->whereDate('membership_start_date', '<=', now())
        ->whereDate('membership_expiry_date', '>=', now())
        ->first();

    // yahan payment methods le aao
    $paymentMethods = UserPaymentMethod::where('user_id', $user->id)->get();

    return view('user.account-setting.billing', compact(
        'user','membership','plans','current','paymentMethods'
    ));
}

public function Notifications(Request $request)
{
    $user = Auth::user();

    $notificationTypes = [
        'auction_activity' => [
            'new_auction_finder'   => 'New Auction Finder Alerts',
            'upcoming_reminder'    => 'Upcoming Auction Reminder',
            'auction_result'       => 'Auction Result Published',
            'reauction'            => 'Reauction Alerts',
            'auction_updates'      => 'Auction Delays / Status Updates',
        ],
        'vehicle_tracking' => [
            'interest_alerts'      => 'Interest-Based Alerts',
        ],
        'scheduling' => [
            'calendar_reminder'    => 'Auction Calendar Reminder',
            'auction_digest'       => 'Daily/Weekly Auction Digest',
        ],
        'system' => [
            'membership_billing'   => 'Membership / Billing Updates',
            'system_updates'       => 'System Updates & New Features',
            'security_alerts'      => 'Security Alerts',
        ],
        'news_engagement' => [
            'news_and_blog'        => 'News & Blog Updates',
            'special_offers'       => 'Special Offers & Promotions',
            'survey_feedback'      => 'Survey & Feedback Requests',
        ],
    ];


    $settings = $user->notificationSettings->keyBy('type');


    $globalSetting = $user->notificationSettings()->first();

    return view('user.account-setting.Notification', compact('notificationTypes', 'settings', 'globalSetting'));
}


    public function storenotification(Request $request)
    {
        $user = Auth::user();

        
        $notificationTypes = [
            'auction_activity' => [
                'new_auction_finder',
                'upcoming_reminder',
                'auction_result',
                'reauction',
                'auction_updates',
            ],
            'vehicle_tracking' => [
                'interest_alerts',
            ],
            'scheduling' => [
                'calendar_reminder',
                'auction_digest',
            ],
            'system' => [
                'membership_billing',
                'system_updates',
                'security_alerts',
            ],
            'news_engagement' => [
                'news_and_blog',
                'special_offers',
                'survey_feedback',
            ],
        ];

        foreach ($notificationTypes as $category => $types) {
            foreach ($types as $type) {
                $values = $request->types[$type] ?? []; 

                UserNotificationSetting::updateOrCreate(
                    ['user_id' => $user->id, 'type' => $type],
                    [
                        'email' => !empty($values['email']) ? 1 : 0,
                        'browser' => !empty($values['browser']) ? 1 : 0,
                        'send_preference' => $request->sendNotification ?? 'anytime', 
                    ]
                );
            }
        }

        return back()->with('success', 'Notification settings updated successfully!');
    }


  public function store(Request $request)
    {
        $request->validate([
            'payment_type' => 'required|in:card,paypal',
            'account_number' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'expiry_date' => 'nullable|string|max:10',
            'cvv' => 'nullable|string|max:4',
        ]);

    
        $exists = UserPaymentMethod::where('user_id', Auth::id())
            ->where('card_number', $request->account_number)
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['account_number' => 'This card is already saved!']);
        }

    
        if ($request->payment_type === 'card' && !$this->isValidCard($request->account_number)) {
            return redirect()->back()->withErrors(['account_number' => 'Invalid card number!']);
        }

        $method = new UserPaymentMethod();
        $method->user_id = Auth::id();
        $method->payment_type = $request->payment_type;
        $method->card_number = $request->account_number;
        $method->card_holder_name = $request->account_name;
        $method->expiry_date = $request->expiry_date;
        $method->cvv = $request->cvv;
        $method->save();

        return redirect()->back()->with('success', 'Payment method saved successfully!');
    }


    private function isValidCard($number)
    {
        $number = preg_replace('/\D/', '', $number);
        $sum = 0;
        $alt = false;

        for ($i = strlen($number) - 1; $i >= 0; $i--) {
            $n = intval($number[$i]);

            if ($alt) {
                $n *= 2;
                if ($n > 9) {
                    $n -= 9;
                }
            }
            $sum += $n;
            $alt = !$alt;
        }

        return ($sum % 10 == 0);
    }


        public function destroy($id)
        {
            $method = UserPaymentMethod::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $method->delete();

            return redirect()->back()->with('success', 'Payment method deleted successfully!');
        }


    
    public function editSecuritySettings()
    {
        $userLoginLogs = UserLogin::where('user_id', auth()->id())
                            ->orderByDesc('login_at')
                            ->limit(10)
                            ->get();

        return view('user.profile.changepassword', compact('userLoginLogs'));
    }











}
