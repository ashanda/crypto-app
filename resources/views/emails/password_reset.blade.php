@component('mail::message')
# Reset Your Password

Hello,

We received a request to reset your password for your **{{ config('app.name') }}** account. Click the button below to reset your password:

@component('mail::button', ['url' => $resetUrl])
Reset Password
@endcomponent

If you did not request a password reset, no further action is required.

This link will expire in **60 minutes** for security reasons.

Thank you,  
**{{ config('app.name') }} Team**

@endcomponent
