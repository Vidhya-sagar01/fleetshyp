<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - FleetSheep</title>
    <title>Seller Login - FleetShyp</title>
    <meta name="description" content="Login to FleetShyp seller dashboard for order management and shipping solutions.">

    <link rel="icon" type="image/png" href="{{ asset('logo/fleetsheep1.png') }}">
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script> 
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { 
            font-family: 'Inter', sans-serif; 
            background: #F5F1E8;
        }
        
        /* Custom Gold Colors */
        .bg-gold { background: #D4AF37; }
        .bg-gold-dark { background: #B8941F; }
        .text-gold { color: #D4AF37; }
        .border-gold { border-color: #D4AF37; }
        .hover\:bg-gold:hover { background: #D4AF37; }
        .hover\:text-gold:hover { color: #D4AF37; }
        
        /* Gradient backgrounds */
        .gradient-bg {
            background: linear-gradient(135deg, #F5F1E8 0%, #EDE4D3 50%, #D4AF37 100%);
        }
        .bg-gradient-gold {
            background: linear-gradient(135deg, #D4AF37 0%, #B8941F 100%);
        }
        
        /* Card hover effects */
        .dashboard-card {
            transition: all 0.3s ease;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(212, 175, 55, 0.15);
        }
        
        /* Input focus styles */
        .input-focus:focus {
            border-color: #D4AF37;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15);
        }
        
        /* Button hover effect */
        .btn-gold {
            background: linear-gradient(135deg, #D4AF37 0%, #B8941F 100%);
            transition: all 0.3s ease;
        }
        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(212, 175, 55, 0.4);
        }
        
        /* Logo container */
        .logo-container {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.1) 0%, rgba(184, 148, 31, 0.05) 100%);
            border: 2px solid rgba(212, 175, 55, 0.3);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen">
    <div class="min-h-screen flex flex-col lg:flex-row">
        
        {{-- Left Side - Features & Branding --}}
        <div class="lg:w-1/2 p-8 lg:p-12 xl:p-16 flex flex-col justify-center relative overflow-hidden">
            {{-- Background Decorative Elements --}}
            <div class="absolute top-0 left-0 w-full h-full opacity-20 pointer-events-none">
                <div class="absolute top-20 left-20 w-48 h-48 bg-gold rounded-full blur-3xl"></div>
                <div class="absolute bottom-20 right-20 w-56 h-56 bg-gold-dark rounded-full blur-3xl"></div>
            </div>

            <div class="relative z-10 max-w-xl">
                {{-- Logo --}}
                <div class="flex items-center gap-3 mb-10">
                    <div class="logo-container w-40 h-20 rounded-2xl flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('logo/fleetsheep1.png') }}" 
                             alt="FleetSheep Logo" 
                             class="w-40 h-40 object-contain">
                    </div>
                  <!-- <h1 class="text-3xl font-bold text-gray-900">
    Fleet<span class="text-[#D4AF37]">Shyp</span>
</h1> -->
                </div>

                {{-- Heading --}}
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                    Smart Shipping,<br>
                    <span class="text-gold">Simplified Logistics</span>
                </h1>

                {{-- Features List --}}
                <div class="space-y-4 mb-10">
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 bg-gold rounded-full flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-check text-white text-xs"></i>
                        </div>
                        <span class="text-gray-700 font-medium">Multi-Courier Integration</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 bg-gold rounded-full flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-check text-white text-xs"></i>
                        </div>
                        <span class="text-gray-700 font-medium">Real-Time Tracking Dashboard</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 bg-gold rounded-full flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-check text-white text-xs"></i>
                        </div>
                        <span class="text-gray-700 font-medium">Automated NDR Management</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 bg-gold rounded-full flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-check text-white text-xs"></i>
                        </div>
                        <span class="text-gray-700 font-medium">RTO Reduction Up to 40%</span>
                    </div>
                </div>

                {{-- Integration Logos --}}
                <div class="mb-10">
                    <p class="text-sm text-gray-500 mb-4 font-medium">Trusted Integrations</p>
                    <div class="grid grid-cols-3 gap-3">
                        <div class="bg-white/80 backdrop-blur px-4 py-3 rounded-xl border border-gray-200 flex items-center justify-center gap-2 hover:border-gold transition-all">
                            <i class="fa-brands fa-shopify text-green-600 text-lg"></i>
                            <span class="text-sm font-medium text-gray-700">Shopify</span>
                        </div>
                        <div class="bg-white/80 backdrop-blur px-4 py-3 rounded-xl border border-gray-200 flex items-center justify-center gap-2 hover:border-gold transition-all">
                            <i class="fa-brands fa-wordpress text-blue-600 text-lg"></i>
                            <span class="text-sm font-medium text-gray-700">WooCommerce</span>
                        </div>
                        <div class="bg-white/80 backdrop-blur px-4 py-3 rounded-xl border border-gray-200 flex items-center justify-center gap-2 hover:border-gold transition-all">
                            <i class="fa-brands fa-magento text-orange-600 text-lg"></i>
                            <span class="text-sm font-medium text-gray-700">Magento</span>
                        </div>
                        <div class="bg-white/80 backdrop-blur px-4 py-3 rounded-xl border border-gray-200 flex items-center justify-center hover:border-gold transition-all">
                            <span class="text-sm font-bold text-gray-700">ekart</span>
                        </div>
                        <div class="bg-white/80 backdrop-blur px-4 py-3 rounded-xl border border-gray-200 flex items-center justify-center hover:border-gold transition-all">
                            <span class="text-sm font-bold text-blue-700">DELHIVERY</span>
                        </div>
                        <div class="bg-white/80 backdrop-blur px-4 py-3 rounded-xl border border-gray-200 flex items-center justify-center hover:border-gold transition-all">
                            <span class="text-sm font-bold text-red-600">amazon</span>
                        </div>
                    </div>
                </div>

                {{-- Dashboard Preview --}}
                <div class="bg-white rounded-2xl shadow-xl p-4 border border-gray-200 transform hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-3">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-red-400"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                            <div class="w-3 h-3 rounded-full bg-green-400"></div>
                        </div>
                        <div class="text-xs text-gray-400">FleetSheep Dashboard</div>
                    </div>
                    <div class="grid grid-cols-3 gap-3 mb-3">
                        <div class="bg-cream p-3 rounded-lg border border-gold/20">
                            <div class="text-xs text-gray-500 mb-1">Total Orders</div>
                            <div class="text-2xl font-bold text-gold">25M</div>
                        </div>
                        <div class="bg-cream p-3 rounded-lg border border-gold/20">
                            <div class="text-xs text-gray-500 mb-1">In Transit</div>
                            <div class="text-2xl font-bold text-blue-600">10M</div>
                        </div>
                        <div class="bg-cream p-3 rounded-lg border border-gold/20">
                            <div class="text-xs text-gray-500 mb-1">Delivered</div>
                            <div class="text-2xl font-bold text-green-600">40M</div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full w-4/5 bg-gradient-gold rounded-full"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500">
                            <span>Monthly Shipments: 25M</span>
                            <span class="text-gold font-medium">+24% Growth</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Side - Login Form --}}
        <div class="lg:w-1/2 bg-white/60 backdrop-blur-sm min-h-screen flex items-center justify-center p-6 lg:p-12">
            <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-8 lg:p-10 border border-gray-100">
                
                {{-- Header --}}
                <div class="mb-8 text-center">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Welcome Back</h2>
                    <p class="text-gray-600 text-sm">Sign in to manage your shipments & grow your business</p>
                </div>

                <div class="relative mb-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500">Or continue with</span>
                    </div>
                </div>

                {{-- Login Form --}}
                <form method="POST" action="{{ route('seller.login') }}">
                    @csrf
                    
                    {{-- Email Field --}}
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-regular fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}" 
                                   placeholder="your@email.com" 
                                   class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl input-focus transition-all outline-none @error('email') @enderror" 
                                   required autofocus>
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-500"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password Field --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" name="password" id="password" 
                                   placeholder="••••••••" 
                                   class="w-full pl-11 pr-12 py-3 border border-gray-200 rounded-xl input-focus transition-all outline-none @error('password') @enderror" 
                                   required>
                            <button type="button" onclick="togglePassword()" 
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gold transition-colors">
                                <i class="fa-regular fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-500"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Remember Me & Forgot Password --}}
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="remember" id="remember" 
                                   class="w-4 h-4 text-gold border-gray-300 rounded focus:ring-gold">
                            <label for="remember" class="text-sm text-gray-600 cursor-pointer select-none">Remember me</label>
                        </div>
                        <a href="{{route('forgot-password')}}" class="text-sm text-gold hover:text-gold-dark font-medium hover:underline transition-colors">
                            Forgot Password?
                        </a>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" 
                            class="w-full py-3.5 px-4 btn-gold text-white font-semibold rounded-xl shadow-md">
                        <i class="fa-solid fa-right-to-bracket mr-2"></i>Sign In to FleetShyp
                    </button>
                </form>

                {{-- Sign Up Link --}}
                <div class="mt-8 text-center pt-6 border-t border-gray-100">
                    <p class="text-gray-600 text-sm">
                        New to FleetShyp? 
                        <a href="{{ route('seller.register') }}" class="text-gold font-semibold hover:text-gold-dark hover:underline transition-colors">
                            Create Account
                        </a>
                    </p>
                </div>

                {{-- Security Badge --}}
                <div class="mt-6 flex items-center justify-center gap-2 text-xs text-gray-400">
                    <i class="fa-solid fa-shield-halved text-gold"></i>
                    <span>Secured with 256-bit SSL encryption</span>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Password Toggle Functionality
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }

        // Form Submit Animation
        document.querySelector('form')?.addEventListener('submit', function(e) {
            const btn = this.querySelector('button[type="submit"]');
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-spinner animate-spin mr-2"></i> Signing In...';
            btn.disabled = true;
            btn.classList.add('opacity-80', 'cursor-not-allowed');
        });

        // Input Focus Effects Enhancement
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.closest('.relative')?.classList.add('ring-2', 'ring-gold/20', 'rounded-xl');
            });
            input.addEventListener('blur', function() {
                this.closest('.relative')?.classList.remove('ring-2', 'ring-gold/20', 'rounded-xl');
            });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href'))?.scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>