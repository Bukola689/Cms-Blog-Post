@component('mail::message')

Welcome {{ $first_name }}

!please view this notification to check whats was sent to you

@component('mail::button', ['url' => ''])
Clich here
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
