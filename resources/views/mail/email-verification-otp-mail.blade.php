<x-mail::message>
# {{ $subject }}

Hello,

Your One-Time Password (OTP) for email verification is:

# {{ $otp }}

Please use this code to verify your email within the next **{{ $timeInMinutes }} minutes**. 

If you did not request this verification, please disregard this message.

Best regards,<br>
**{{ config('app.name') }}**
</x-mail::message>