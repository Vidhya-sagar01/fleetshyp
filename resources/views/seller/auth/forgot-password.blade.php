<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - fleetshyp</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gold: '#D4AF37',
                        'gold-dark': '#B8941F',
                        cream: '#F5F1E8',
                        'cream-dark': '#EDE4D3'
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; background: #F5F1E8; }
        .gradient-bg { background: linear-gradient(135deg, #F5F1E8 0%, #EDE4D3 50%, #D4AF37 100%); }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fadeIn { animation: fadeIn 0.4s ease-out forwards; }
        @keyframes shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-5px); } 75% { transform: translateX(5px); } }
        .animate-shake { animation: shake 0.3s ease-in-out; }
        .spinner { width: 20px; height: 20px; border: 2px solid rgba(255,255,255,0.3); border-radius: 50%; border-top-color: #fff; animation: spin 1s linear infinite; display: inline-block; }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>
<body class="gradient-bg min-h-screen">

<div class="min-h-screen bg-gradient-to-br from-[#F5F1E8] via-[#F9F7F2] to-[#F5F1E8] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    
    <!-- Decorative Background -->
    <div class="absolute top-20 left-10 w-72 h-72 bg-[#D4AF37]/5 rounded-full blur-3xl"></div>
    <div class="absolute bottom-20 right-10 w-96 h-96 bg-[#2C3E50]/5 rounded-full blur-3xl"></div>

    <div class="max-w-lg w-full space-y-8 relative z-10">
        
        <!-- Main Card -->
        <div class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-[0_20px_60px_-15px_rgba(0,0,0,0.1)] border border-[#E8E4DA]/80 p-8 sm:p-10 relative overflow-hidden">
            
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#B8941F] via-[#D4AF37] to-[#C4A532]"></div>

            <!-- Header -->
            <div class="text-center mb-8">
                <div class="relative inline-block mb-5">
                    <div class="w-18 h-18 bg-gradient-to-br from-[#D4AF37] to-[#B8941F] rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fa-solid fa-key text-white text-2xl"></i>
                    </div>
                </div>
                <h2 class="text-2xl font-bold text-[#2C3E50] mb-2">Forgot Password?</h2>
                <p class="text-gray-500 text-sm" id="step-description">Enter your registered email to receive a secure OTP</p>
            </div>

            <!-- Progress Steps -->
            <div class="mb-8">
                <div class="flex items-center justify-between relative">
                    <div class="absolute top-5 left-0 w-full h-0.5 bg-gray-200 -z-10"></div>
                    <div class="absolute top-5 left-0 h-0.5 bg-gradient-to-r from-[#D4AF37] to-transparent -z-10 transition-all duration-500" id="progress-fill" style="width: 0%"></div>
                    
                    @foreach([1=>'Email', 2=>'OTP', 3=>'Password'] as $num => $label)
                    <div class="flex flex-col items-center z-10">
                        <div id="step-{{$num}}-dot" class="w-9 h-9 rounded-full {{ $num <= (session('reset_step') ?? 1) ? 'bg-[#D4AF37] text-white' : 'bg-gray-200 text-gray-400' }} flex items-center justify-center font-bold shadow border-4 border-white transition-all">
                            <i class="fa-solid fa-check text-xs opacity-0" id="step-{{$num}}-check"></i>
                            <span id="step-{{$num}}-num">{{ $num }}</span>
                        </div>
                        <span class="text-[10px] font-{{ $num <= (session('reset_step') ?? 1) ? 'semibold text-[#D4AF37]' : 'medium text-gray-400' }} mt-2">{{ $label }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- ✅ SERVER ERROR DISPLAY -->
            @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg animate-fadeIn">
                <div class="flex items-start">
                    <i class="fa-solid fa-circle-exclamation text-red-500 mt-0.5 mr-3"></i>
                    <div>
                        <p class="font-medium text-red-800 text-sm">Please fix the following errors:</p>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            @if(session('status'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg animate-fadeIn">
                <div class="flex items-center">
                    <i class="fa-solid fa-circle-check text-green-500 mr-3"></i>
                    <p class="text-green-700 text-sm">{{ session('status') }}</p>
                </div>
            </div>
            @endif

            <!-- STEP 1: Email Form -->
            <form id="step-1-form" action="{{ route('send-email-forgot-password') }}" method="POST" class="step-form space-y-5 {{ (session('reset_step') ?? 1) == 1 ? '' : 'hidden' }} animate-fadeIn">
                @csrf
                <input type="hidden" name="step" value="1">
                
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-semibold text-[#2C3E50]">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-envelope text-gray-400 group-focus-within:text-[#D4AF37] transition-colors"></i>
                        </div>
                        <input type="email" id="email" name="email" autocomplete="email" value="{{ old('email') }}"
                            class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border-2 @error('email') border-red-300 @else @enderror rounded-xl focus:bg-white focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 outline-none transition-all text-[#2C3E50] placeholder-gray-400 @error('email') animate-shake @enderror
                            placeholder="name@company.com" required>
                    </div>
                    @error('email')
                    <p class="text-xs text-red-500 flex items-center gap-1">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                    </p>
                    @enderror
                    <p class="text-xs text-gray-500 flex items-center gap-1">
                        <i class="fa-solid fa-circle-info text-[#D4AF37]"></i>
                        We'll send a 6-digit code to verify your identity
                    </p>
                </div>

                <button type="submit" id="btn-send-otp" 
                    class="w-full py-3.5 bg-gradient-to-r from-[#D4AF37] via-[#C4A532] to-[#B8941F] hover:from-[#C4A532] hover:via-[#B8941F] hover:to-[#A88420] text-white font-bold rounded-xl shadow-lg hover:shadow-[0_15px_40px_rgba(212,175,55,0.4)] transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center gap-3 group">
                    <span id="btn-send-text">Send Verification Code</span>
                    <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    <span id="btn-send-loading" class="hidden"><span class="spinner"></span></span>
                </button>

                <div class="text-center pt-3 border-t border-gray-100">
                    <p class="text-sm text-gray-500">
                        Remember your password? 
                        <a href="{{ route('seller.login') }}" class="text-[#D4AF37] font-semibold hover:text-[#B8941F] transition-colors">Sign in</a>
                    </p>
                </div>
            </form>

            <!-- STEP 2: OTP Verification -->
            <form id="step-2-form" action="{{ route('forgot-password.verify-otp') }}" method="POST" class="step-form space-y-5 {{ (session('reset_step') ?? 1) == 2 ? '' : 'hidden' }} animate-fadeIn">
                @csrf
                <input type="hidden" name="step" value="2">
                <input type="hidden" name="email" value="{{ old('email') ?? session('reset_email') }}">
                
                <div class="text-center mb-3">
                    <p class="text-sm text-gray-600">
                        Enter the code sent to <br>
                        <span id="otp-email-display" class="font-semibold text-[#2C3E50]">
                            {{ session('reset_email') ?: old('email') ?: 'your@email.com' }}
                        </span>
                    </p>
                </div>

                <div class="space-y-4">
                    <label class="block text-sm font-semibold text-[#2C3E50] text-center">Verification Code</label>
                    <div class="flex justify-center gap-2">
                        @for($i = 0; $i < 6; $i++)
                        <input type="text" maxlength="1" 
                            class="otp-input w-12 h-14 text-center text-xl font-bold bg-gray-50 border-2 @error('otp') border-red-300 @else @enderror rounded-xl focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 outline-none transition-all text-[#2C3E50] @error('otp') animate-shake @enderror" 
                            onkeyup="moveToNext(this, event)" 
                            name="otp_digit_{{ $i }}"
                            value="{{ old('otp_digit_'.$i) }}">
                        @endfor
                    </div>
                    <input type="hidden" id="otp-value" name="otp" value="{{ old('otp') }}">
                    
                    @error('otp')
                    <p class="text-xs text-red-500 text-center flex items-center justify-center gap-1">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                    </p>
                    @enderror
                    
                    <div class="text-center">
                        <p class="text-xs text-gray-500">
                            Didn't receive code? 
                            <button type="button" id="resend-btn" class="text-[#D4AF37] font-semibold hover:text-[#B8941F] transition-colors disabled:opacity-50 disabled:cursor-not-allowed" onclick="resendOTP()" disabled>
                                Resend in <span id="resend-timer">30s</span>
                            </button>
                        </p>
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="goToStep(1)" 
                        class="flex-1 py-3.5 border-2 border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all">
                        Back
                    </button>
                    <button type="submit" id="btn-verify-otp"
                        class="flex-1 py-3.5 bg-gradient-to-r from-[#D4AF37] via-[#C4A532] to-[#B8941F] hover:from-[#C4A532] hover:via-[#B8941F] hover:to-[#A88420] text-white font-bold rounded-xl shadow-lg hover:shadow-[0_15px_40px_rgba(212,175,55,0.4)] transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <span id="btn-verify-text">Verify Code</span>
                        <span id="btn-verify-loading" class="hidden"><span class="spinner"></span></span>
                    </button>
                </div>
            </form>

            <!-- STEP 3: New Password -->
            <form id="step-3-form" action="{{ route('forgot-password.update') }}" method="POST" class="step-form space-y-5 {{ (session('reset_step') ?? 1) == 3 ? '' : 'hidden' }} animate-fadeIn">
                @csrf
                <input type="hidden" name="step" value="3">
                <input type="hidden" name="email" value="{{ session('reset_email') }}">
                
                <div class="text-center mb-2">
                    <div class="inline-flex items-center justify-center w-10 h-10 bg-green-100 rounded-full mb-2">
                        <i class="fa-solid fa-check text-green-600"></i>
                    </div>
                    <p class="text-sm text-gray-600">Code verified! Create your new password</p>
                </div>

                <div class="space-y-4">
                    <!-- New Password -->
                    <div>
                        <label for="new-password" class="block text-sm font-semibold text-[#2C3E50] mb-1.5">
                            New Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-lock text-gray-400 group-focus-within:text-[#D4AF37] transition-colors"></i>
                            </div>
                            <input type="password" id="new-password" name="password" autocomplete="new-password" 
                                class="w-full pl-11 pr-10 py-3.5 bg-gray-50 border-2 @error('password') border-red-300 @else @enderror rounded-xl focus:bg-white focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 outline-none transition-all text-[#2C3E50] placeholder-gray-400 @error('password') animate-shake @enderror"
                                placeholder="••••••••" required oninput="checkPasswordStrength(this.value)">
                            <button type="button" onclick="togglePassword('new-password')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-[#D4AF37] transition-colors">
                                <i class="fa-solid fa-eye" id="new-password-icon"></i>
                            </button>
                        </div>
                        @error('password')
                        <p class="text-xs text-red-500 mt-1 flex items-center gap-1">
                            <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                        </p>
                        @enderror
                        <!-- Password Strength -->
                        <div class="mt-2 flex items-center gap-2">
                            <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                <div id="password-strength-bar" class="h-full w-0 bg-gradient-to-r from-red-400 via-yellow-400 to-green-400 transition-all duration-300 rounded-full"></div>
                            </div>
                            <span id="strength-text" class="text-[10px] font-medium text-gray-500">Weak</span>
                        </div>
                        <ul class="mt-1.5 space-y-0.5 text-[10px] text-gray-500">
                            <li id="req-length" class="flex items-center gap-1"><i class="fa-solid fa-circle text-[4px] text-gray-300"></i> 8+ characters</li>
                            <li id="req-upper" class="flex items-center gap-1"><i class="fa-solid fa-circle text-[4px] text-gray-300"></i> 1 uppercase</li>
                            <li id="req-number" class="flex items-center gap-1"><i class="fa-solid fa-circle text-[4px] text-gray-300"></i> 1 number</li>
                        </ul>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="confirm-password" class="block text-sm font-semibold text-[#2C3E50] mb-1.5">
                            Confirm Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-lock text-gray-400 group-focus-within:text-[#D4AF37] transition-colors"></i>
                            </div>
                            <input type="password" id="confirm-password" name="password_confirmation" autocomplete="new-password"
                                class="w-full pl-11 pr-10 py-3.5 bg-gray-50 border-2 @error('password') border-red-300 @else @enderror rounded-xl focus:bg-white focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 outline-none transition-all text-[#2C3E50] placeholder-gray-400"
                                placeholder="••••••••" required oninput="checkPasswordMatch()">
                            <button type="button" onclick="togglePassword('confirm-password')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-[#D4AF37] transition-colors">
                                <i class="fa-solid fa-eye" id="confirm-password-icon"></i>
                            </button>
                        </div>
                        <p id="password-match-msg" class="text-[10px] mt-1 font-medium hidden"></p>
                    </div>
                </div>

                <div class="flex gap-3 pt-3">
                    <button type="button" onclick="goToStep(2)" 
                        class="flex-1 py-3.5 border-2 border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all">
                        Back
                    </button>
                    <button type="submit" id="btn-update-password"
                        class="flex-1 py-3.5 bg-gradient-to-r from-[#2C3E50] via-[#34495E] to-[#3d566e] hover:from-[#34495E] hover:via-[#3d566e] hover:to-[#45627a] text-white font-bold rounded-xl shadow-lg hover:shadow-[0_15px_40px_rgba(44,62,80,0.3)] transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-check"></i>
                        <span id="btn-update-text">Update Password</span>
                        <span id="btn-update-loading" class="hidden"><span class="spinner"></span></span>
                    </button>
                </div>
            </form>

        </div>

        <!-- Security Badge -->
        <div class="text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/60 backdrop-blur-sm rounded-full border border-[#E8E4DA]/60">
                <i class="fa-solid fa-shield-halved text-[#D4AF37] text-sm"></i>
                <span class="text-[10px] text-gray-600 font-medium">Secured with 256-bit encryption</span>
            </div>
        </div>

    </div>
</div>

<!-- JavaScript -->
<script>
    let currentStep = {{ session('reset_step') ?? 1 }};
    let resendCountdown = 30;
    let resendTimer = null;

    document.addEventListener('DOMContentLoaded', function() {
        // Show correct step based on session (server-driven)
        const step = {{ session('reset_step') ?? 1 }};
        showStep(step);
        
        if (step === 2) {
            document.getElementById('otp-email-display').textContent = '{{ session("reset_email") ?: old("email") }}';
            startResendTimer();
        }
        
        @if(session('status') && session('reset_step') == 2)
            startResendTimer();
        @endif
    });

    // Show specific step (server-driven navigation)
    function showStep(step) {
        document.querySelectorAll('.step-form').forEach(f => f.classList.add('hidden'));
        document.getElementById(`step-${step}-form`)?.classList.remove('hidden');
        updateProgress(step);
        
        const desc = {1:'Enter your registered email to receive a secure OTP', 2:'Enter the 6-digit code sent to your email', 3:'Create a strong password for your account'};
        document.getElementById('step-description').textContent = desc[step];
        
        if (step === 2) startResendTimer();
        currentStep = step;
    }

    // Client-side step navigation (for back buttons only)
    function goToStep(step) {
        if (step === 2 && !validateEmail()) {
            document.getElementById('email')?.focus();
            return;
        }
        showStep(step);
    }

    function updateProgress(step) {
        document.getElementById('progress-fill').style.width = `${((step-1)/2)*100}%`;
        for (let i=1; i<=3; i++) {
            const dot = document.getElementById(`step-${i}-dot`);
            const num = document.getElementById(`step-${i}-num`);
            const check = document.getElementById(`step-${i}-check`);
            const label = document.querySelector(`#step-${i}-dot + span`);
            
            if (i < step) {
                dot.className = 'w-9 h-9 rounded-full bg-[#D4AF37] text-white flex items-center justify-center font-bold shadow border-4 border-white';
                num?.classList.add('opacity-0'); check?.classList.remove('opacity-0');
                if(label) label.className = 'text-[10px] font-semibold text-[#D4AF37] mt-2';
            } else if (i === step) {
                dot.className = 'w-9 h-9 rounded-full bg-[#D4AF37] text-white flex items-center justify-center font-bold shadow border-4 border-white animate-pulse';
                num?.classList.remove('opacity-0'); check?.classList.add('opacity-0');
                if(label) label.className = 'text-[10px] font-semibold text-[#D4AF37] mt-2';
            } else {
                dot.className = 'w-9 h-9 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center font-bold border-4 border-white';
                num?.classList.remove('opacity-0'); check?.classList.add('opacity-0');
                if(label) label.className = 'text-[10px] font-medium text-gray-400 mt-2';
            }
        }
    }

    function validateEmail() {
        const email = document.getElementById('email');
        const value = email?.value.trim();
        if (!value) { showError(email, 'Email address is required'); return false; }
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) { showError(email, 'Please enter a valid email address'); return false; }
        clearError(email);
        return true;
    }

    function validateOTP() {
        const inputs = document.querySelectorAll('.otp-input');
        let otp = '';
        inputs.forEach(inp => otp += inp.value);
        if (otp.length !== 6) { alert('Please enter the complete 6-digit OTP'); return false; }
        if (!/^\d{6}$/.test(otp)) { alert('OTP must contain only numbers'); return false; }
        document.getElementById('otp-value').value = otp;
        return true;
    }

    function showError(input, msg) {
        if (!input) return;
        input.classList.add('border-red-300', 'animate-shake');
        input.classList.remove('border-gray-200');
    }
    function clearError(input) {
        if (!input) return;
        input.classList.remove('border-red-300', 'animate-shake');
        input.classList.add('border-gray-200');
    }

    function moveToNext(input, event) {
        input.value = input.value.replace(/[^0-9]/g, '');
        const inputs = document.querySelectorAll('.otp-input');
        const idx = Array.from(inputs).indexOf(input);
        if (input.value.length === 1 && idx < inputs.length - 1) inputs[idx+1].focus();
        if (event.key === 'Backspace' && !input.value && idx > 0) inputs[idx-1].focus();
        let otp = ''; inputs.forEach(i => otp += i.value);
        document.getElementById('otp-value').value = otp;
    }

    function startResendTimer() {
        resendCountdown = 30;
        updateResendTimer();
        const btn = document.getElementById('resend-btn');
        btn.disabled = true;
        btn.classList.add('opacity-50', 'cursor-not-allowed');
        clearInterval(resendTimer);
        resendTimer = setInterval(() => {
            resendCountdown--;
            updateResendTimer();
            if (resendCountdown <= 0) {
                clearInterval(resendTimer);
                btn.disabled = false;
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
                document.getElementById('resend-timer').textContent = 'Now';
            }
        }, 1000);
    }

    function updateResendTimer() {
        const el = document.getElementById('resend-timer');
        if (el) el.textContent = resendCountdown > 0 ? `${resendCountdown}s` : 'Now';
    }

    function resendOTP() {
        const email = document.getElementById('email')?.value || '{{ session("reset_email") }}';
        if (!email) { alert('Email not found'); return; }
        const btn = document.getElementById('resend-btn');
        btn.innerHTML = '<span class="spinner"></span> Sending...';
        btn.disabled = true;
        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = "{{ route('send-email-forgot-password') }}";
        form.innerHTML = `<input type="hidden" name="_token" value="${csrf}"><input type="hidden" name="email" value="${email}"><input type="hidden" name="resend" value="1">`;
        document.body.appendChild(form);
        form.submit();
    }

    function togglePassword(id) {
        const input = document.getElementById(id);
        const icon = document.getElementById(`${id}-icon`);
        if (input.type === 'password') { input.type = 'text'; icon.classList.replace('fa-eye','fa-eye-slash'); }
        else { input.type = 'password'; icon.classList.replace('fa-eye-slash','fa-eye'); }
    }

    function checkPasswordStrength(pwd) {
        const bar = document.getElementById('password-strength-bar');
        const text = document.getElementById('strength-text');
        let score = 0;
        ['req-length','req-upper','req-number'].forEach((id, i) => {
            const el = document.getElementById(id)?.querySelector('i');
            const met = (i===0 && pwd.length>=8) || (i===1 && /[A-Z]/.test(pwd)) || (i===2 && /[0-9]/.test(pwd));
            if (el) el.className = `fa-solid fa-circle text-[4px] ${met?'text-green-500':'text-gray-300'}`;
            if (met) score++;
        });
        const levels = [{w:'0%',c:'bg-gray-200',t:'Weak'}, {w:'33%',c:'bg-red-400',t:'Weak'}, {w:'66%',c:'bg-yellow-400',t:'Fair'}, {w:'100%',c:'bg-green-400',t:'Strong'}];
        const lvl = levels[Math.min(score, 3)];
        bar.className = `h-full transition-all duration-300 rounded-full ${lvl.c}`;
        bar.style.width = lvl.w;
        text.textContent = lvl.t;
        text.className = `text-[10px] font-medium ${score>=2?'text-green-600':'text-gray-500'}`;
    }

    function checkPasswordMatch() {
        const pwd = document.getElementById('new-password')?.value;
        const confirm = document.getElementById('confirm-password')?.value;
        const msg = document.getElementById('password-match-msg');
        if (!msg || !confirm) return;
        msg.classList.remove('hidden');
        if (pwd === confirm && confirm.length > 0) {
            msg.innerHTML = '<i class="fa-solid fa-circle-check text-green-500"></i> Passwords match';
            msg.className = 'text-[10px] mt-1 font-medium text-green-600 flex items-center gap-1';
        } else if (confirm.length > 0) {
            msg.innerHTML = '<i class="fa-solid fa-circle-xmark text-red-500"></i> Passwords do not match';
            msg.className = 'text-[10px] mt-1 font-medium text-red-500 flex items-center gap-1';
        } else {
            msg.classList.add('hidden');
        }
    }

    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const step = this.querySelector('input[name="step"]')?.value;
            const btn = step==1 ? document.getElementById('btn-send-otp') : step==2 ? document.getElementById('btn-verify-otp') : document.getElementById('btn-update-password');
            const textSpan = btn?.querySelector('span[id$="-text"]');
            const loadingSpan = btn?.querySelector('span[id$="-loading"]');
            if (btn && textSpan && loadingSpan) {
                textSpan.classList.add('hidden');
                loadingSpan.classList.remove('hidden');
                btn.disabled = true;
            }
        });
    });
</script>
</body>
</html>