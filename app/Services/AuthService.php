<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerificationOtpMail;
use Carbon\Carbon;

class AuthService
{
    public function register(array $data): array
    {
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }

    public function login(array $data): array|bool
    {
        $user = User::findByEmail($data['email']);

        if (! $user || ! Hash::check($data['password'], $user->password) || ! $user->is_active) {
            return false;
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }

    public function sendEmailVerificationOtp(User $user): void
    {
        $otp = $this->generateOtp();
        $time = config('auth.passwords.users.otp_expire');

        $user->update([
            'email_verification_otp' => $otp,
            'email_otp_expires_at'   => Carbon::now()->addMinutes($time),
        ]);

        Mail::to($user->email)->queue(new EmailVerificationOtpMail($user->name, $time, $otp));
    }

    public function verifyPasswordResetOtp(User $user, string $otp): bool
    {
        return (
            $user->email_verification_otp === $otp &&
            $user->email_otp_expires_at &&
            Carbon::now()->lessThanOrEqualTo($user->email_otp_expires_at)
        );
    }

    public function resetPassword(User $user, string $password): void
    {
        $user->update([
            'password' => Hash::make($password),
            'email_verification_otp' => null,
            'email_otp_expires_at' => null,
        ]);
    }

    private function generateOtp(): string
    {
        $length = config('auth.passwords.users.otp_length');

        // Generate the first digit (1-9) to ensure it's non-zero
        $firstDigit = random_int(1, 9);
        
        // Generate the remaining digits (0-9) as a random number with $length - 1 digits
        $remainingDigits = str_pad(random_int(0, pow(10, $length - 1) - 1), $length - 1, '0', STR_PAD_LEFT);

        return (int) ($firstDigit . $remainingDigits);
    }
}
