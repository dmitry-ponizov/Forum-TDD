@component('mail::message')
# One last step

We just need you to confirm your email address to prove that you`re a human.

@component('mail::button', ['url' => 'https://192.168.10.10/register/confirm?token='.$user->confirmation_token])
Confirm email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
