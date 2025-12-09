<?php

namespace App\Http\Resources;

use App\Models\Membership;
use App\Models\UserDevice;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Request;

class UserProfileResource extends JsonResource
{

    public function toArray($request)
    {

      

        $current = Membership::where('user_id',$this->id)
        ->with(['plan'])
        ->where('membership_status', 'Active')
        ->whereDate('membership_start_date', '<=', now())
        ->whereDate('membership_expiry_date', '>=', now())
        ->first();

         $membership = Membership::with(['plan'])->where('user_id',$this->id)
        ->orderBy('created_at','desc')
        ->get();

        $userDevices = UserDevice::where('user_id', $this->id)
                    ->orderByDesc('logged_in_at')
                    ->limit(10)
                    ->get();

        return [

            // Basic user info
            'id' => $this->id,
            'user_type' => $this->user_type,
            'role' => $this->user_type ? 'Admin' : 'User',
            'status' => $this->status,

             // Personal details
            'firstName'         => $this->firstName,
            'surname'           => $this->surname,
            'title'             => $this->title,
            'jobTitle'          => $this->jobTitle,
            'phone'             => $this->phone,
            'personalEmail'     => $this->personalEmail,
            'joined' => 'Joined 10 Apr 2025',

            // Company details
            'companyName'       => $this->companyName,
            'companyAddress1'   => $this->companyAddress1,
            'companyAddress2'   => $this->companyAddress2,
            'townCity'          => $this->townCity,
            'country'           => $this->country,
            'postcode'          => $this->postcode,
            'telephone'         => $this->telephone,
            'businessType'      => $this->businessType,
            'companyReg'        => $this->companyReg,
            'website'           => $this->website,
            'businessEmail'     => $this->businessEmail,
            'motorTradeInsurance' => $this->motorTradeInsurance,
            'vatNumber'         => $this->vatNumber,

           

            // Authentication
            'password'                      => $this->password,
            'email_verification_token'      => $this->email_verification_token,
            'email_verification_token_status' => $this->email_verification_token_status,
            'resend_count'                  => $this->resend_count,
            'last_resend_at'                => $this->last_resend_at,

            // Uploaded files
            'uploadID'          => $this->uploadID ?  env('APP_URL').'public/uploads/uploadID/'.$this->uploadID : null,
            'motorTradeProof'   => $this->motorTradeProof ? env('APP_URL').'public/uploads/motorTradeProof/'.$this->motorTradeProof : null,
            'addressProof'      => $this->addressProof ? env('APP_URL').'public/uploads/addressProof/'.$this->addressProof : null,

            // Avatar with full URL
            'avatar' => $this->avatar ? env('APP_URL') . 'public/uploads/avatar/' . $this->avatar: null,

            // Metadata
            'source' => $this->source,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'plans' => $current,
            'billingHistory' => $membership,    
            'userDevices' => $userDevices,         

      
        ];
    }
}
