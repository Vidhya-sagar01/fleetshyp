@extends('seller.layouts.app')

@section('content')
<div class="min-h-screen bg-[#F5F1E8] py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">

        @php
        $user = auth()->user();
        @endphp

        <!-- Messages -->
        @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            {{ session('error') }}
        </div>
        @endif

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#2C3E50]">Account Settings</h1>
            <p class="text-gray-500 mt-1">Manage your profile information</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- LEFT SIDEBAR -->
            <div class="lg:col-span-4 xl:col-span-3">
                <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-[#E8E4DA] p-6 sticky top-6">

                    <!-- Profile Picture -->
                    <div class="relative mb-6 flex justify-center">
                        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-[#D4AF37] to-[#B8941F] p-1 shadow-xl">
                            <div class="w-full h-full rounded-full overflow-hidden bg-gray-100 flex items-center justify-center">

                       @if($user->profile_image)
    <img src="{{ asset('storage/' . $user->profile_image) }}"
         class="w-full h-full object-cover object-top">
@else
    <i class="fa-solid fa-user text-4xl text-gray-400"></i>
@endif
                            </div>
                        </div>
                    </div>

                    <!-- Name & Email -->
                    <div class="text-center mb-6">
                        <h2 class="text-2xl font-bold text-[#2C3E50] mb-1">{{ $user->name }}</h2>
                        <p class="text-gray-500 text-sm">{{ $user->email }}</p>

                        <span class="inline-flex items-center px-3 py-1 mt-3 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                            Active Seller
                        </span>
                    </div>

                    <!-- Button -->
                    <a href="#" onclick="openModal()"
                        class="w-full py-3 bg-[#D4AF37] hover:bg-[#B8941F] text-white font-bold rounded-xl text-center block">
                        <i class="fa-solid fa-camera mr-2"></i> Update Profile Pic
                    </a>
                </div>
            </div>

            <!-- RIGHT CONTENT -->
            <div class="lg:col-span-8 xl:col-span-9">

                <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-[#E8E4DA] p-8">

                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-full bg-[#F5F1E8] flex items-center justify-center">
                            <i class="fa-solid fa-user text-[#D4AF37]"></i>
                        </div>
                        <h3 class="text-xl font-bold text-[#2C3E50]">Personal Information</h3>
                    </div>

                    <!-- FORM -->
                    <form action="{{ route('seller.profile.update') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Name -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-[#2C3E50] mb-2">Full Name</label>
                                <input type="text" name="name" value="{{ $user->name }}"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            </div>

                            <!-- Phone -->
                            <div class="w-full">
                                <label class="block text-sm font-semibold text-[#2C3E50] mb-2">Phone Number</label>
                                <input type="tel" name="phone" value="{{ $user->phone }}"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            </div>

                            <!-- Email -->
                            <div class="w-full">
                                <label class="block text-sm font-semibold text-[#2C3E50] mb-2">Email Address</label>
                                <div class="px-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-gray-500">
                                    {{ $user->email }}
                                </div>
                            </div>

                        </div>

                        <!-- Buttons -->
                        <div class="flex flex-col sm:flex-row items-center justify-between mt-8 pt-6 border-t border-gray-100 gap-4">

                            <a href="#" onclick="openPasswordModal()" class="text-[#D4AF37] text-sm font-semibold">
                                Change Password?
                            </a>

                            <div class="flex gap-3">
                                <button type="button"
                                    class="px-6 py-3 border-2 border-gray-300 text-gray-600 font-bold rounded-xl">
                                    Cancel
                                </button>

                                <button type="submit"
                                    class="px-8 py-3 bg-gradient-to-r from-[#D4AF37] to-[#B8941F] text-white font-bold rounded-xl">
                                    Update Profile
                                </button>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>

        <!-- Profile Modal -->
        <div id="profileModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-xl relative">
                <button onclick="closeModal()" class="absolute top-3 right-3">✖</button>

                <h2 class="text-xl font-bold mb-4">Upload Profile Picture</h2>

                <form action="{{ route('seller.profile.update.image') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="file" name="profile_image" class="w-full border p-2 mb-4">

                    <button type="submit" class="w-full bg-[#D4AF37] text-white py-2 rounded-lg font-bold">
                        Update Profile
                    </button>
                </form>
            </div>
        </div>

        <!-- Password Modal -->
        <div id="passwordModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-xl relative">

                <button onclick="closePasswordModal()" class="absolute top-3 right-3">✖</button>

                <h2 class="text-xl font-bold mb-4">Change Password</h2>

                <form action="{{ route('seller.profile.change.password') }}" method="POST">
                    @csrf

                    <input type="password" name="current_password" placeholder="Old Password"
                        class="w-full border p-2 mb-1 rounded" required>
                    @error('current_password')
                    <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
                    @enderror

                    <input type="password" name="new_password" placeholder="Create New Password"
                        class="w-full border p-2 mb-1 rounded" required>
                    @error('new_password')
                    <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
                    @enderror

                    <input type="password" name="new_password_confirmation" placeholder="Confirm Password"
                        class="w-full border p-2 mb-4 rounded" required>

                    <button type="submit" class="w-full bg-[#D4AF37] text-white py-2 rounded-lg font-bold">
                        Update Password
                    </button>
                </form>

            </div>
        </div>

    </div>
</div>

<script>
function openModal() {
    document.getElementById('profileModal').classList.remove('hidden');
    document.getElementById('profileModal').classList.add('flex');
}

function closeModal() {
    document.getElementById('profileModal').classList.add('hidden');
}

function openPasswordModal() {
    document.getElementById('passwordModal').classList.remove('hidden');
    document.getElementById('passwordModal').classList.add('flex');
}

function closePasswordModal() {
    document.getElementById('passwordModal').classList.add('hidden');
}
</script>

@endsection