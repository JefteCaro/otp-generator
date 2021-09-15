<?php

namespace Jefte\OTPGenerator\Traits;

use Jefte\OTPGenerator\Models\OTPToken;

trait HasOTPToken
{

    public function otpToken()
    {
        return $this->morphOne(
            (config('otp.model')) ?: OTPToken::class
            , 'owner');
    }

    public function createOtpToken()
    {
        return $this->otpToken()->create();
    }

    public function verifyOtpToken($token)
    {
        $otp = $this->otpToken()->orderBy('created_at', 'DESC')->first();

        return $otp->verifyToken($token);
    }

}
