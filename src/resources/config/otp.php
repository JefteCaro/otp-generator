<?php


return [

    'chars' => env('OTP_CHARACTERS', '0123456789'),


    'length' => env('OTP_LENGTH', 6),


    'model' => Jefte\OTPGenerator\Models\OTPToken::class,


    'ttl' => env('OTP_TTL', 3600)

];
