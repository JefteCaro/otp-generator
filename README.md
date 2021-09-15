## OTP (One-Time Password) Generator for Laravel



### Requirements
- Laravel v6.0 or above
- Composer


### Installation

Via Composer, run:

`composer require jefte/otpgenerator`

Publish migration for OTP Tokens:

`php artisan vendor:publish --provider=Jefte\OTPGenerator\OTPServiceProvider --tag=otp-migration`

then run `php artisan migrate`

### Usage

Include the `HasOTPToken` trait into your model

```php
<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jefte\OTPGenerator\Traits\HasOTPToken;

class User extends Authenticatable
{
  use HasFactory, Notifiable, HasOTPToken;
  
  
}
```


To Generate an OTP Token, use the `createOtpToken` method from the model

```php
class HomeController extends Controller
{
   public function requestOtpToken(Request $request)
   {
      $user = $request->user();
      
      // Creating Token
      $token = $user->createOtpToken();
      
      
      // Accessing the created token
      $token->getGeneratedToken();
      
      // Sample Use Case
      $user->notify(new SendOtpNotification($token));
      
      
   }
   
   public function verifyOtpToken(Request $request)
   {
      
      $user = $request->user();
      
      // To Verify Token
      $token = $request->input('otp_token');
      
      if(! $user->verifyToken($myToken))
      {
          return response()->json([
              'message' => 'Invalid OTP'
          ], 422);
      }
      
   }
    
}
```

### Customization

Publish config

`php artisan vendor:publish --provider=Jefte\OTPGenerator\OTPServiceProvider --tag=otp-config`


In your .env file
```env

# Default Characters generated OTP Token

OTP_CHARACTERS=123456789


# Default Length

OTP_LENGTH=6


# Token default TTL
# 3600 secs = 1Hour
# Use seconds as unit

OTP_TTL=3600

```
