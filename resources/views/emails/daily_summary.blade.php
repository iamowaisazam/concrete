@component('mail::message')
# 🚗 Daily Vehicle Summary ({{ $summary['date'] }})

Here is the summary of today's activity:

- **New Vehicles:** {{ $summary['total_new'] }}
- **Sold Vehicles:** {{ $summary['total_sold'] }}
- **Unsold Vehicles:** {{ $summary['total_unsold'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
