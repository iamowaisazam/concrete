@component('mail::message')
# Hello {{ $name }},

Thanks for registering on **Autoboli**!

Your verification code is:

@component('mail::panel')
**{{ $token }}**
@endcomponent

Or click the button below to verify your email:

@component('mail::button', ['url' => $verifyUrl])
Verify Email
@endcomponent

If you did not create this account, please ignore this email.

Thanks,  
**The Autoboli Team**
@endcomponent
