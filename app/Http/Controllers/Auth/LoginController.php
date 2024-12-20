<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Socialite;
use App\User;
use Auth;
use Illuminate\Support\Str;
use Session;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function Callback($provider)
    {
        $userSocial = Socialite::driver($provider)->stateless()->user();
        $users = User::where(['email' => $userSocial->getEmail()])->first();

        if ($users) {
            Auth::login($users);
            return redirect('/')->with('success', 'You are logged in from ' . $provider);
        } else {
            $user = User::create([
                'name' => $userSocial->getName(),
                'email' => $userSocial->getEmail(),
                'image' => $userSocial->getAvatar(),
                'provider_id' => $userSocial->getId(),
                'provider' => $provider,
            ]);
            return redirect()->route('home');
        }
    }

    // Refresh Captcha
    public function refreshCaptcha()
    {
        return response()->json(['captcha' => captcha_img('math'), 'captcha_code' => Str::random(6)]);
    }

    // Attempt Login with reCAPTCHA
    protected function attemptLogin(Request $request)
    {
        // Verify CAPTCHA token before login
        $this->validateCaptcha($request);

        return $this->guard()->attempt(
            $this->credentials($request),
            $request->filled('remember')
        );
    }

    // Validate reCAPTCHA
    private function validateCaptcha(Request $request)
    {
        // Get the CAPTCHA token from the form
        $captchaToken = $request->input('captcha_code');

        // Verify the CAPTCHA token with Google's API
        $secret = env('RECAPTCHA_SECRET_KEY');  // Your secret key from the .env
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secret,
            'response' => $captchaToken
        ]);

        dd($response->json());

        $body = $response->json();

        // If CAPTCHA verification fails, abort login and return error
        if (!$body['success']) {
            throw new \Exception('Captcha verification failed. Please try again.');
        }
    }

    // Define login credentials
    public function credentials(Request $request)
    {
        return [
            'email' => $request->email,
            'password' => $request->password,
            'status' => 'active',
            'role' => 'admin',
            'captcha' => $request->captcha_code,
        ];
    }
}
