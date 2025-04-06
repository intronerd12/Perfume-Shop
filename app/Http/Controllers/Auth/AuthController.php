<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('frontend.pages.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('users', 'public');
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => $photoPath,
            'role' => 'user', // Default role
            'status' => 'active',
        ]);

        // Send verification email
        event(new Registered($user));

        // Don't automatically login the user
        return redirect()->route('login.form')
            ->with('register_success', 'Registration successful! Please check your email to verify your account.');
    }

    public function showLoginForm()
    {
        return view('frontend.pages.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Check if email is verified
            if (!$user->hasVerifiedEmail()) {
                Auth::logout();
                return redirect()->route('login.form')
                    ->with('error', 'You need to verify your email first. We have sent you a verification link.')
                    ->withInput();
            }

            return redirect()->intended(route('home'));
        }

        return redirect()->back()
            ->with('error', 'Invalid credentials')
            ->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.form');
    }

    public function socialLogin($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function socialLoginCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
            
            // Check if user exists with this email
            $user = User::where('email', $socialUser->getEmail())->first();
            
            if (!$user) {
                // Create new user
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'password' => Hash::make(Str::random(16)),
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'email_verified_at' => now(), // Social login users are considered verified
                    'role' => 'user',
                    'status' => 'active',
                ]);
            }
            
            Auth::login($user);
            return redirect()->intended(route('home'));
            
        } catch (\Exception $e) {
            return redirect()->route('login.form')
                ->with('error', 'Social login failed. Please try again.');
        }
    }
}