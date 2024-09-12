@component('mail::message')
# Your Registration Has Been Approved

Congratulations! Your registration has been approved.

@component('mail::button', ['url' => $loginUrl])
Log In
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
