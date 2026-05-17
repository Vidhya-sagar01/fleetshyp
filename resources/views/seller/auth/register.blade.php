<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - FleetSheep</title>
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
        
        /* Gold Text Gradient */
        .text-gradient-gold {
            background: linear-gradient(135deg, #D4AF37 0%, #B8941F 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
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
        
        /* Tab button styles */
        .tab-active {
            background: linear-gradient(135deg, #D4AF37 0%, #B8941F 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
        }
        .tab-inactive {
            background: transparent;
            color: #6B7280;
        }
        .tab-inactive:hover {
            background: rgba(212, 175, 55, 0.08);
            color: #D4AF37;
        }
        
        /* Logo container */
        .logo-container {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.15) 0%, rgba(184, 148, 31, 0.08) 100%);
            border: 2px solid rgba(212, 175, 55, 0.4);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.12);
        }
        
        /* Welcome heading animation */
        .welcome-heading {
            animation: fadeInUp 0.6s ease-out;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Checkbox custom style */
        .checkbox-gold:checked {
            background-color: #D4AF37;
            border-color: #D4AF37;
        }
    </style>
</head>
<body class="gradient-bg min-h-screen">
    <div class="min-h-screen flex flex-col lg:flex-row">
        
        {{-- Left Side - Branding --}}
        <div class="lg:w-1/2 p-8 lg:p-12 xl:p-16 flex flex-col justify-center relative overflow-hidden">
            {{-- Background Decorative Elements --}}
            <div class="absolute top-0 left-0 w-full h-full opacity-20 pointer-events-none">
                <div class="absolute top-20 left-20 w-48 h-48 bg-gold rounded-full blur-3xl"></div>
                <div class="absolute bottom-20 right-20 w-56 h-56 bg-gold-dark rounded-full blur-3xl"></div>
            </div>

            <div class="relative z-10 max-w-xl">
                {{-- Logo --}}
                <div class="flex items-center gap-4 mb-10">
                    <div class="logo-container w-20 h-20 lg:w-24 lg:h-24 rounded-3xl flex items-center justify-center overflow-hidden shrink-0">
                        <img src="{{ asset('logo/fleetsheep1.png') }}" 
                             alt="FleetSheep Logo" 
                             class="w-14 h-14 lg:w-16 lg:h-16 object-contain drop-shadow-sm">
                    </div>
                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900">
                        Fleet<span class="text-[#D4AF37]">Shyp</span>
                    </h1>
                </div>

                {{-- Heading --}}
                <h1 class="welcome-heading text-4xl lg:text-5xl xl:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                    <span class="block">Join FleetSheep,</span>
                    <span class="text-gradient-gold">Ship Smarter! 🚀</span>
                </h1>

                <p class="text-lg text-gray-600 mb-8 max-w-md">
                    Start your journey with India's most trusted logistics platform. Free setup, zero hidden charges.
                </p>

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

                {{-- Platform Logos --}}
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

        {{-- Right Side - Forms --}}
        <div class="lg:w-1/2 bg-white/60 backdrop-blur-sm min-h-screen flex items-center justify-center p-6 lg:p-12">
            <div class="w-full max-w-lg bg-white rounded-3xl shadow-2xl p-8 lg:p-10 border border-gray-100">
                
                {{-- Toggle Tabs --}}
                <div class="bg-cream/50 p-1.5 rounded-2xl flex mb-6 border border-gold/20">
                    {{-- For Sellers Tab --}}
                    <button onclick="showTab('seller')" id="sellerTab" 
                            class="tab-active flex-1 py-3 px-4 rounded-xl flex items-center gap-3 transition-all duration-300">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-store text-white text-sm"></i>
                        </div>
                        <div class="text-left">
                            <div class="font-semibold text-sm">For Sellers</div>
                            <div class="text-white/85 text-xs">Sign up with a FREE account</div>
                        </div>
                    </button>
                    
                    {{-- For Buyers Tab --}}
                    <button onclick="showTab('buyer')" id="buyerTab" 
                            class="tab-inactive flex-1 py-3 px-4 rounded-xl flex items-center gap-3 transition-all duration-300">
                        <div class="w-8 h-8 bg-gray-200 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-user text-gray-600 text-sm"></i>
                        </div>
                        <div class="text-left">
                            <div class="font-semibold text-sm">For Buyers</div>
                            <div class="text-gray-500 text-xs">Track your order instantly</div>
                        </div>
                    </button>
                </div>

                {{-- Seller Signup Form --}}
                <div id="sellerForm" class="block">
                    <div class="mb-6 text-center">
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Create Seller Account</h3>
                        <p class="text-sm text-gray-500">Start shipping with FleetSheep today</p>
                    </div>

                    <form method="POST" action="{{ route('seller.register') }}">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">First Name <span class="text-red-500">*</span></label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" 
                                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg input-focus outline-none @error('first_name') @enderror">
                                @error('first_name')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name" 
                                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg input-focus outline-none @error('last_name') @enderror">
                                @error('last_name')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fa-regular fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="work@email.com" 
                                       class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg input-focus outline-none @error('email') @enderror">
                            </div>
                            @error('email')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fa-solid fa-phone absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="+91 98765 43210" 
                                       class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg input-focus outline-none @error('phone') @enderror">
                            </div>
                            @error('phone')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="password" name="password" id="sellerPassword" placeholder="Create strong password" 
                                       class="w-full pl-10 pr-10 py-2.5 border border-gray-200 rounded-lg input-focus outline-none @error('password') @enderror">
                                <button type="button" onclick="togglePassword('sellerPassword', 'eyeIconSeller')" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gold transition-colors">
                                    <i class="fa-regular fa-eye" id="eyeIconSeller"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-5 flex items-start gap-2">
                            <input type="checkbox" name="terms" id="terms" class="mt-1 w-4 h-4 text-gold border-gray-300 rounded checkbox-gold focus:ring-gold">
                            <label for="terms" class="text-sm text-gray-600">
                                By signing up, you agree to our 
                                <a href="#" class="text-gold hover:text-gold-dark font-medium hover:underline">Privacy Policy</a> and 
                                <a href="#" class="text-gold hover:text-gold-dark font-medium hover:underline">Terms of Service</a>
                            </label>
                        </div>
                        @error('terms')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror

                        <button type="submit" class="w-full mt-6 py-3.5 px-4 btn-gold text-white font-semibold rounded-xl shadow-md">
                            <i class="fa-solid fa-user-plus mr-2"></i>Create Free Account
                        </button>
                    </form>

                    <p class="mt-6 text-center text-sm text-gray-600">
                        Already have an account? 
                        <a href="{{ route('seller.login') }}" class="text-gold font-semibold hover:text-gold-dark hover:underline transition-colors">
                            Sign In
                        </a>
                    </p>
                </div>

                {{-- Buyer Order Tracking Form --}}
                <div id="buyerForm" class="hidden">
                    <div class="mb-6 text-center">
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Track Your Order</h3>
                        <p class="text-sm text-gray-500">No account needed - check status instantly</p>
                    </div>

                    <form action="#" method="POST" class="space-y-4">
                        @csrf
                        <div class="flex gap-4 mb-4 justify-center">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="tracking_type" value="order_id" checked 
                                       class="w-4 h-4 text-gold border-gray-300 focus:ring-gold" onchange="toggleTrackingType('order')">
                                <span class="text-sm font-medium text-gray-700">Order ID</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="tracking_type" value="awb" 
                                       class="w-4 h-4 text-gold border-gray-300 focus:ring-gold" onchange="toggleTrackingType('awb')">
                                <span class="text-sm font-medium text-gray-700">AWB Number</span>
                            </label>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" id="trackingLabel">Order ID <span class="text-red-500">*</span></label>
                            <input type="text" name="tracking_id" id="trackingInput" placeholder="Enter Order ID" 
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg input-focus outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Registered Mobile <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fa-solid fa-mobile absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="tel" name="mobile" placeholder="+91 98765 43210" 
                                       class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg input-focus outline-none">
                            </div>
                        </div>

                        <button type="submit" class="w-full py-3.5 px-4 btn-gold text-white font-semibold rounded-xl shadow-md">
                            <i class="fa-solid fa-magnifying-glass mr-2"></i>Track Order
                        </button>
                    </form>

                    <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                        <p class="text-sm text-gray-600">
                            Are you a seller? 
                            <a href="#" onclick="showTab('seller'); return false;" class="text-gold font-semibold hover:text-gold-dark hover:underline transition-colors">
                                Create Seller Account
                            </a>
                        </p>
                    </div>
                </div>

                {{-- Security Badge --}}
                <div class="mt-8 flex items-center justify-center gap-2 text-xs text-gray-400">
                    <i class="fa-solid fa-shield-halved text-gold"></i>
                    <span>Your data is secured with 256-bit SSL encryption</span>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Tab Switching Function
        function showTab(tabType) {
            const sellerTab = document.getElementById('sellerTab');
            const buyerTab = document.getElementById('buyerTab');
            const sellerForm = document.getElementById('sellerForm');
            const buyerForm = document.getElementById('buyerForm');

            if (tabType === 'seller') {
                // Activate Seller Tab
                sellerTab.classList.remove('tab-inactive');
                sellerTab.classList.add('tab-active');
                sellerTab.querySelector('i').classList.remove('text-gray-600');
                sellerTab.querySelector('i').classList.add('text-white');
                sellerTab.querySelector('.text-xs').classList.remove('text-gray-500');
                sellerTab.querySelector('.text-xs').classList.add('text-white/85');
                
                // Deactivate Buyer Tab
                buyerTab.classList.remove('tab-active');
                buyerTab.classList.add('tab-inactive');
                buyerTab.querySelector('i').classList.remove('text-white');
                buyerTab.querySelector('i').classList.add('text-gray-600');
                buyerTab.querySelector('.text-xs').classList.remove('text-white/85');
                buyerTab.querySelector('.text-xs').classList.add('text-gray-500');

                // Show Seller Form
                sellerForm.classList.remove('hidden');
                sellerForm.classList.add('block');
                buyerForm.classList.add('hidden');
                buyerForm.classList.remove('block');
            } else {
                // Activate Buyer Tab
                buyerTab.classList.remove('tab-inactive');
                buyerTab.classList.add('tab-active');
                buyerTab.querySelector('i').classList.remove('text-gray-600');
                buyerTab.querySelector('i').classList.add('text-white');
                buyerTab.querySelector('.text-xs').classList.remove('text-gray-500');
                buyerTab.querySelector('.text-xs').classList.add('text-white/85');
                
                // Deactivate Seller Tab
                sellerTab.classList.remove('tab-active');
                sellerTab.classList.add('tab-inactive');
                sellerTab.querySelector('i').classList.remove('text-white');
                sellerTab.querySelector('i').classList.add('text-gray-600');
                sellerTab.querySelector('.text-xs').classList.remove('text-white/85');
                sellerTab.querySelector('.text-xs').classList.add('text-gray-500');

                // Show Buyer Form
                buyerForm.classList.remove('hidden');
                buyerForm.classList.add('block');
                sellerForm.classList.add('hidden');
                sellerForm.classList.remove('block');
            }
        }

        // Toggle Tracking Type (Order ID / AWB)
        function toggleTrackingType(type) {
            const label = document.getElementById('trackingLabel');
            const input = document.getElementById('trackingInput');
            
            if (type === 'order') {
                label.innerHTML = 'Order ID <span class="text-red-500">*</span>';
                input.placeholder = 'Enter Order ID';
                input.name = 'tracking_id';
            } else {
                label.innerHTML = 'AWB Number <span class="text-red-500">*</span>';
                input.placeholder = 'Enter AWB / Tracking Number';
                input.name = 'awb_number';
            }
        }

        // Password Toggle Functionality
        function togglePassword(inputId, eyeIconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(eyeIconId);
            
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
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const btn = this.querySelector('button[type="submit"]');
                if(btn) {
                    const originalContent = btn.innerHTML;
                    btn.innerHTML = '<i class="fa-solid fa-spinner animate-spin mr-2"></i> Processing...';
                    btn.disabled = true;
                    btn.classList.add('opacity-80', 'cursor-not-allowed');
                }
            });
        });

        // Input Focus Effects
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.classList.add('ring-2', 'ring-gold/20');
            });
            input.addEventListener('blur', function() {
                this.classList.remove('ring-2', 'ring-gold/20');
            });
        });
    </script>
</body>
</html>