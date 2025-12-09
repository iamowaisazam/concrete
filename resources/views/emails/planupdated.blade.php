@component('mail::message')
# Hello {{ $user->name }},

We have an exciting update! The plan **{{ $plan->plan_name }}** is now available with special officer/discount benefits.

**Short Description:** {{ $plan->short_desc }}

**Price:** ${{ number_format($plan->price, 2) }}

**Duration:** {{ $plan->duration_value }} {{ ucfirst($plan->duration_unit) }}

@component('mail::button', ['url' => url('/plans')])
View Plan
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
