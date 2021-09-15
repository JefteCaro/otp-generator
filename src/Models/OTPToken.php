<?php

namespace Jefte\OTPGenerator\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class OTPToken extends Model
{
    protected $table = 'otp_tokens';

    public $timestamps = false;

    protected $generatedToken;

    protected $fillable = [
        'owner_type',
        'owner_id',
        'token',
        'expires_at',
    ];

    public function owner()
    {
        return $this->morphTo();
    }

    public function generate()
    {
        $chars = (config('otp.chars')) ?: '0123456789';

        $str = '';

        $len = config('otp.length') ?: 6;

        for ($i=0; $i < $len; $i++)
        {
            $str .= substr($chars, rand(0, strlen($chars) - 1), 1);
        }

        return $str;
    }

    public function getGeneratedToken()
    {
        return $this->generatedToken;
    }

    public function verifyToken($token)
    {
        return Hash::check($token, $this->token);
    }

    public static function booted()
    {
        static::creating(function($data) {
            $data->generatedToken = $data->generate();
            $data->token = Hash::make($data->generatedToken);
            $data->created_at = Carbon::now();
            $data->expires_at = Carbon::now()->addSeconds((config('otp.ttl')) ?: 3600);
        });
    }
}
