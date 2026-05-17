<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Wallet;

class AuthController extends Controller
{

    /* ================= ADMIN LOGIN ================= */

    // public function showAdminLogin()
    // {
    //     return view('admin.auth.login'); 
    // }

    public function showAdminLogin()
{
    if (Auth::check()) {

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if (Auth::user()->role === 'seller_admin') {
            return redirect()->route('seller.dashboard');
        }
    }

    return view('admin.auth.login'); 
}

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            // ❌ Allow only admin
            if (Auth::user()->role !== 'admin') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Admin access only.'
                ]);
            }

            $request->session()->regenerate();
            //dd('Admin logged in successfully');
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials',
        ]);
    }


  

    public function showSellerLogin()
{
    if (Auth::check()) {

        if (Auth::user()->role === 'seller_admin') {
            return redirect()->route('seller.dashboard');
        }

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
    }

    return view('seller.auth.login');
}

    public function sellerLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            // ❌ Allow only seller_admin
            if (Auth::user()->role !== 'seller_admin') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Seller access only.'
                ]);
            }

            $request->session()->regenerate();

            return redirect()->route('seller.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials',
        ]);
    }


    /* ================= SELLER REGISTER ================= */

    public function showSellerRegister()
    {
        return view('seller.auth.register');
    }



private function generateUniqueUserCode()
{
    do {
        $code = random_int(100000, 999999);
    } while (\App\Models\User::where('remember_token', $code)->exists());

    return $code;
}

// public function sellerRegister(Request $request)
// {
//     // Combine first and last name
//     $request->merge([
//         'name' => trim($request->first_name . ' ' . $request->last_name),
//     ]);

//     // Validator
//     $validator = Validator::make($request->all(), [
//         'name' => 'required|string|max:255',
//         'email' => 'required|email|unique:users,email',
//         'password' => 'required|min:8',
//         'phone' => 'required|string|max:20', // 👈 add this
//         'terms' => 'accepted',
//     ]);

//     if ($validator->fails()) {
//         return back()->withErrors($validator)->withInput();
//     }

//     try {
//         DB::beginTransaction();

//         // 🔢 Generate unique 6 digit ID
//         $userCode = $this->generateUniqueUserCode();

//         // 👤 Create User (manual assign - FIXED)
//         $user = new User();
//         $user->name = $request->name;
//         $user->email = $request->email;
//         $user->phone = $request->phone; // ✅ now will save
//         $user->password = Hash::make($request->password);
//         $user->role = 'seller_admin';

//         // ⚠️ testing only
//         $user->remember_password = $request->password;

//         // 🔢 6 digit code
//         $user->remember_token = $userCode;

//         $user->save();

//         // 💰 Wallet create
//         Wallet::create([
//             'user_id' => $user->id,
//             'balance' => 0.00,
//         ]);

//         DB::commit();

//         Auth::login($user);

//         return redirect()->route('seller.dashboard');

//     } catch (\Exception $e) {
//         DB::rollBack();

//         \Log::error('Seller Registration Error: ' . $e->getMessage());

//         return back()->withInput()->withErrors([
//             'error' => 'Something went wrong during registration. Please try again.'
//         ]);
//     }
// }



public function sellerRegister(Request $request)
{
    // Combine first and last name
    $request->merge([
        'name' => trim($request->first_name . ' ' . $request->last_name),
    ]);

    // Validator
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'phone' => 'required|string|max:20',
        'terms' => 'accepted',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    try {
        DB::beginTransaction();

        // 🔢 Generate unique 6 digit ID
        $userCode = $this->generateUniqueUserCode();

        // 👤 Create User
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        
        // ✅ MAIN LOGIN PASSWORD - ENCRYPTED (for security)
        $user->password = Hash::make($request->password);
        
        $user->role = 'seller_admin';

        // ✅ FIXED: Save PLAIN TEXT password in remember_password column
        $user->remember_password = $request->password;  // 🔓 Unencrypted - for testing only

        // 🔢 6 digit user code
        $user->user_code = $userCode;

        $user->save();

        // 💰 Wallet create
        Wallet::create([
            'user_id' => $user->id,
            'balance' => 0.00,
        ]);

        DB::commit();

        Auth::login($user);

        return redirect()->route('seller.dashboard');

    } catch (\Exception $e) {
        DB::rollBack();

        \Log::error('Seller Registration Error: ' . $e->getMessage());

        return back()->withInput()->withErrors([
            'error' => 'Something went wrong during registration. Please try again.'
        ]);
    }
}
//     /* ================= LOGOUT ================= */

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login'); // default redirect
    }

     public function sellerLogout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/seller/login'); 
    }
}