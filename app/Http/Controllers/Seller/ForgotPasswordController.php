<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        // Clear old session data when visiting fresh
        if (!session()->has('reset_step')) {
            session()->forget(['reset_email', 'reset_otp', 'reset_step', 'otp_sent_at']);
        }
        return view('seller.auth.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255|exists:users,email',
        ], [
            'email.exists' => 'This email is not registered with us',
        ]);

        $email = $validated['email'];

        // 🚫 Resend limit (30 seconds)
        if (session('otp_sent_at') && now()->diffInSeconds(session('otp_sent_at')) < 30) {
            return redirect()->route('forgot-password')
                ->withErrors(['email' => 'Please wait 30 seconds before requesting another OTP.'])
                ->withInput();
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('forgot-password')
                ->withErrors(['email' => 'This email is not registered'])
                ->withInput();
        }

        // 🔐 Generate OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // 🔐 Store in session (hashed for security)
        session([
            'reset_email' => $email,
            'reset_otp' => Hash::make($otp),
            'reset_step' => 2,  // ✅ Move to step 2
            'otp_sent_at' => now(),
        ]);
        session()->save(); // ✅ Critical: Save before redirect

        try {
            Mail::send([], [], function ($message) use ($email, $otp) {
                $message->to($email)
                    ->subject('🔐 Password Reset OTP - Fleetshyp')
                    ->from(config('mail.from.address'), config('mail.from.name'))
                    ->html("
                        <div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;padding:20px'>
                            <h2 style='color:#2C3E50'>🔐 Password Reset OTP</h2>
                            <p>Your OTP is:</p>
                            <h1 style='color:#D4AF37;font-size:32px;letter-spacing:8px;text-align:center'>{$otp}</h1>
                            <p style='color:#666'>This OTP is valid for 10 minutes.</p>
                        </div>
                    ");
            });

            // ✅ SUCCESS: Redirect to same route, blade will show step 2 via session
            return redirect()->route('forgot-password')
                ->with('status', '✅ OTP sent successfully to your email!');
                
        } catch (\Exception $e) {
            \Log::error('OTP Email Failed: ' . $e->getMessage());
            
            // ❌ FAILED: Stay on step 1 with error
            return redirect()->route('forgot-password')
                ->withErrors(['email' => 'Failed to send email. Please try again.'])
                ->withInput();
        }
    }

    public function verifyOtp(Request $request)
    {
        $validated = $request->validate([
            'otp' => 'required|digits:6',
            'email' => 'required|email',
        ], [
            'otp.digits' => 'OTP must be exactly 6 digits',
        ]);

        $inputOtp = $validated['otp'];
        $sessionOtp = session('reset_otp');
        $sessionEmail = session('reset_email');

        // ❌ Session mismatch or expired
        if (!$sessionEmail || $validated['email'] !== $sessionEmail) {
            return redirect()->route('forgot-password')
                ->withErrors(['otp' => 'Session expired. Please request a new OTP.'])
                ->withInput();
        }

        // ⏰ OTP Expiry (10 minutes)
        if (!session('otp_sent_at') || now()->diffInMinutes(session('otp_sent_at')) > 10) {
            session()->forget(['reset_otp', 'reset_email', 'reset_step', 'otp_sent_at']);
            return redirect()->route('forgot-password')
                ->withErrors(['otp' => 'OTP expired. Please request a new one.'])
                ->withInput();
        }

        // 🔐 Verify HASHED OTP
        if (!Hash::check($inputOtp, $sessionOtp)) {
            // ❌ WRONG OTP: Stay on step 2 with error
            return redirect()->route('forgot-password')
                ->withErrors(['otp' => 'Invalid OTP. Please try again.'])
                ->withInput();
        }

        // ✅ CORRECT OTP: Move to step 3
        session(['reset_step' => 3]);
        session()->save();

        return redirect()->route('forgot-password')
            ->with('status', '✅ OTP verified! Now set your new password.');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required|min:8|confirmed|regex:/[A-Z]/|regex:/[0-9]/',
            'email' => 'required|email',
        ], [
            'password.min' => 'Password must be at least 8 characters',
            'password.confirmed' => 'Passwords do not match',
            'password.regex' => 'Password must contain uppercase letter and number',
        ]);

        $sessionEmail = session('reset_email');

        // ❌ Session mismatch
        if (!$sessionEmail || $request->email !== $sessionEmail) {
            return redirect()->route('forgot-password')
                ->withErrors(['email' => 'Session expired. Please start again.'])
                ->withInput();
        }

        try {
            $user = User::where('email', $sessionEmail)->first();

            if (!$user) {
                return redirect()->route('forgot-password')
                    ->withErrors(['email' => 'User not found'])
                    ->withInput();
            }

            $user->update([
                'password' => Hash::make($validated['password']),
                'password_updated_at' => now(),
            ]);

            // ✅ Send confirmation email
            try {
                Mail::send([], [], function ($message) use ($sessionEmail) {
                    $message->to($sessionEmail)
                        ->subject('🔐 Password Updated Successfully')
                        ->from('noreply@fleetshyp.com', 'Fleetshyp Security')
                        ->html("
                            <div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;padding:20px'>
                                <h2 style='color:#27ae60'>✅ Password Updated</h2>
                                <p>Your password has been changed successfully.</p>
                                <p>If this was not you, contact support immediately.</p>
                            </div>
                        ");
                });
            } catch (\Exception $e) {
                \Log::warning('Confirmation email failed: ' . $e->getMessage());
            }

            // 🧹 Clear sensitive session data
            session()->forget(['reset_otp', 'reset_email', 'reset_step', 'otp_sent_at']);

            // ✅ SUCCESS: Redirect to login
            return redirect()->route('seller.login')
                ->with('success', '🎉 Password updated successfully! Please login.');

        } catch (\Exception $e) {
            \Log::error('Password update failed: ' . $e->getMessage());
            return redirect()->route('forgot-password')
                ->withErrors(['password' => 'Something went wrong. Please try again.'])
                ->withInput();
        }
    }
}