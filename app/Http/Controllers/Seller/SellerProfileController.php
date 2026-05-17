<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SellerProfileController extends Controller
{
     public function index()
    {
        $user = Auth::user(); // login user

        return view('seller.profile.sellerprofile', compact('user'));
    }

    /**
     * Update Profile Image
     */
public function updateImage(Request $request)
{
    $request->validate([
        'profile_image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $user = auth()->user();

    if ($request->hasFile('profile_image')) {

        // 🔥 Delete old image (important)
        if ($user->profile_image && \Storage::disk('public')->exists($user->profile_image)) {
            \Storage::disk('public')->delete($user->profile_image);
        }

        $file = $request->file('profile_image');

        // unique filename
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // store
        $path = $file->storeAs('profile_images', $filename, 'public');

        // save in DB
        $user->profile_image = $path;
        $user->save();
    }

    return back()->with('success', 'Profile image updated successfully');
}
    public function updateProfile(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:15',
    ]);

    $user = auth()->user();

    $user->name = $request->name;
    $user->phone = $request->phone;
    $user->save();

    return back()->with('success', 'Profile updated successfully');
}
// change password

public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:6|confirmed',
    ]);

    $user = auth()->user();

    // check old password
    if (!Hash::check($request->current_password, $user->password)) {
        return back()->with('error', 'Old password is incorrect');
    }

    // update password
    $user->password = Hash::make($request->new_password);
    $user->save();

    return back()->with('success', 'Password updated successfully');
}
}

