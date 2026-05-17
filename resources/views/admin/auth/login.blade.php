<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin Login - FleetSheep</title>
    <link rel="icon" type="image/png" href="{{ asset('logo/fleetsheep1.png') }}">
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        /* Gold accent for FleetSheep branding */
        .text-gold { color: #D4AF37; }
        .bg-gold { background: #D4AF37; }
        .border-gold { border-color: #D4AF37; }
        .focus-gold:focus {
            border-color: #D4AF37;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15);
        }
        
        /* Logo container */
        .logo-badge {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.95) 0%, rgba(30, 41, 59, 0.95) 100%);
            border: 2px solid rgba(212, 175, 55, 0.3);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        /* Button gradient */
        .btn-admin {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            transition: all 0.2s ease;
        }
        .btn-admin:hover {
            background: linear-gradient(135deg, #334155 0%, #475569 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .btn-admin:active {
            transform: translateY(0);
        }
        
        /* Input animations */
        .input-group:focus-within i {
            color: #64748b;
        }
        
        /* Fade in animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.4s ease-out;
        }
    </style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md animate-fade-in">
        
        {{-- Login Card --}}
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            
            {{-- Header with Logo --}}
            <div class="bg-linear-to-br from-slate-800 to-slate-900 px-8 py-6 text-center border-b border-slate-700">
                {{-- FleetSheep Logo --}}
                <div class="flex items-center justify-center gap-3 mb-4">
                    <div class="logo-badge w-12 h-12 rounded-xl flex items-center justify-center">
                        <img src="{{ asset('logo/fleetsheep1.png') }}" 
                             alt="FleetSheep" 
                             class="w-8 h-8 object-contain">
                    </div>
                    <div class="text-left">
                        <h1 class="text-xl font-bold text-white leading-tight">
                            Fleet<span class="text-gold">Sheep</span>
                        </h1>
                        <p class="text-xs text-slate-400">Admin Console</p>
                    </div>
                </div>
                <p class="text-slate-300 text-sm">Secure access to your management dashboard</p>
            </div>

            {{-- Form Section --}}
            <div class="p-8">
                
                {{-- Error Messages --}}
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-r mb-6" role="alert">
                        <div class="flex items-start gap-3">
                            <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
                            <ul class="text-sm space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                {{-- Success Message --}}
                @if (session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-r mb-6" role="alert">
                        <div class="flex items-start gap-3">
                            <i class="fa-solid fa-circle-check mt-0.5"></i>
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login') }}" class="space-y-5">
                    @csrf
                    
                    {{-- Email Field --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-2">
                            Admin Email <span class="text-red-500">*</span>
                        </label>
                        <div class="relative input-group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-regular fa-envelope text-slate-400 transition-colors"></i>
                            </div>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                                class="w-full pl-11 pr-4 py-3 border border-slate-300 rounded-lg focus-gold focus:outline-none transition-all bg-slate-50 focus:bg-white" 
                                placeholder="admin@fleetsheep.com">
                        </div>
                        @error('email')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Password Field --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative input-group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-lock text-slate-400 transition-colors"></i>
                            </div>
                            <input type="password" name="password" id="password" required
                                class="w-full pl-11 pr-12 py-3 border border-slate-300 rounded-lg focus-gold focus:outline-none transition-all bg-slate-50 focus:bg-white" 
                                placeholder="••••••••">
                            <button type="button" onclick="togglePassword()" 
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                                <i class="fa-regular fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Remember & Forgot --}}
                    <div class="flex items-center justify-between pt-2">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" name="remember" 
                                   class="w-4 h-4 text-slate-700 border-slate-300 rounded focus:ring-slate-500 focus:ring-offset-0">
                            <span class="text-sm text-slate-600 group-hover:text-slate-800 transition-colors">Remember me</span>
                        </label>
                        <a href="#" class="text-sm text-slate-500 hover:text-gold font-medium transition-colors">
                            Forgot Password?
                        </a>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" 
                        class="w-full btn-admin text-white font-semibold py-3 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2">
                        <i class="fa-solid fa-right-to-bracket mr-2"></i>Sign In to Admin Panel
                    </button>
                </form>

                {{-- Security Notice --}}
                <div class="mt-6 pt-6 border-t border-slate-200">
                    <div class="flex items-center justify-center gap-2 text-xs text-slate-400">
                        <i class="fa-solid fa-shield-halved text-gold"></i>
                        <span>Admin access is logged and monitored</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer Note --}}
        <p class="text-center text-slate-500 text-xs mt-6">
            &copy; {{ date('Y') }} FleetSheep. All rights reserved.
            <br>
            <span class="text-slate-400">Authorized personnel only</span>
        </p>

    </div>

    <script>
        // Password Toggle
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Form Submit Loading State
        document.querySelector('form')?.addEventListener('submit', function(e) {
            const btn = this.querySelector('button[type="submit"]');
            if (btn && !btn.disabled) {
                const original = btn.innerHTML;
                btn.innerHTML = '<i class="fa-solid fa-spinner animate-spin mr-2"></i>Verifying...';
                btn.disabled = true;
                btn.classList.add('opacity-80', 'cursor-wait');
            }
        });

        // Enter key submit enhancement
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' && this.form) {
                    this.form.requestSubmit();
                }
            });
        });
    </script>
</body>
</html>