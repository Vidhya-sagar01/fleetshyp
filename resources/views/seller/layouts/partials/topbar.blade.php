<style>
    .amt-btn {
        padding: 6px 14px;
        border-radius: 999px;
        border: 1px solid #e5ddd0;
        background: #f8f8f8;
        font-size: 13px;
        transition: 0.2s;
    }

    .amt-btn:hover {
        background: #eee;
    }

    .amt-btn.active {
        background: #2d1b4e;
        color: #fff;
        border-color: #2d1b4e;
    }
</style>

<header class="h-16 bg-white border-b border-[#E5DDD0] flex items-center justify-between px-6 shrink-0 shadow-sm relative z-40">

    {{-- Logo Section --}}
   <div class="flex items-center">
  <a href="{{ route('seller.dashboard') }}" class="flex items-center space-x-2">

        <!-- Logo Image (optional) -->
        <img src="{{ asset('logo/fleetsheep1.png') }}" 
             alt="SmartShip Logo"
           class="w-29 h-29 object-contain">
    </a>
</div>
    {{-- Search Bar --}}
    <div class="flex-1 max-w-md mx-8">
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                <i class="fa-solid fa-magnifying-glass text-sm"></i>
            </span>
            <input type="text" placeholder="AWB / Order Id" 
                class="w-full pl-11 pr-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#D4AF37]/30 focus:border-[#D4AF37] text-sm transition-all duration-200 shadow-inner">
        </div>
    </div>

    {{-- Right Section --}}
    <div class="flex items-center space-x-5">

        {{-- Wallet Section --}}
        <div class="flex items-center space-x-3">
            <div class="flex items-center space-x-2 bg-[#F5F1E8] px-3 py-1.5 rounded-lg border border-[#E5DDD0]">
                <span class="text-[#D4AF37] font-semibold">₹</span>
                <span class="text-sm font-semibold text-gray-700">
                    {{ number_format(Auth::user()->wallet->balance ?? 0, 2) }}
                </span>
            </div>
           <button onclick="openRechargeModal()" 
                class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-1.5 rounded-lg text-sm font-medium">
                Recharge Wallet
            </button>
        </div>

        {{-- Icons Section --}}
        <div class="flex items-center space-x-2">
            <button class="w-9 h-9 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-500 hover:text-gray-700 transition-all duration-200">
                <i class="fa-solid fa-grip text-lg"></i>
            </button>
            <button class="w-9 h-9 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-500 hover:text-gray-700 transition-all duration-200 relative">
                <i class="fa-regular fa-bell text-lg"></i>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
        </div>

        {{-- Profile Dropdown --}}
        <div class="relative">
            <div id="profileDropdownBtn" class="flex items-center cursor-pointer hover:bg-gray-50 rounded-lg px-2 py-1.5 transition-all duration-200 border-l border-gray-200 ml-1">
                {{-- Avatar --}}
                <div class="w-8 h-8 rounded-full bg-linear-to-br from-[#D4AF37] to-[#B8941F] flex items-center justify-center text-white text-sm font-semibold mr-2 shadow-sm">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
                <span class="text-sm font-medium text-gray-700 capitalize">{{ Auth::user()->name ?? 'User' }}</span>
                <i class="fa-solid fa-chevron-down text-[10px] ml-2 text-gray-400 transition-transform duration-200" id="profileDropdownIcon"></i>
            </div>

            {{-- Dropdown Menu --}}
            <div id="profileDropdownMenu" class="hidden absolute right-0 mt-3 w-52 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50 transform opacity-0 scale-95 transition-all duration-200 origin-top-right">
                
                {{-- User Info Header --}}
                <div class="px-4 py-3 border-b border-gray-100">
                    <p class="text-sm font-semibold text-gray-800 capitalize">
    {{ Auth::user()->name ?? 'User' }} 
    ({{ Auth::user()->user_code ?? '' }})
</p>
                    <p class="text-xs text-gray-500">{{ Auth::user()->email ?? '' }}</p>
                </div>

                <a href="/seller/profile/sellerprofile"
                    class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-[#F5F1E8] hover:text-[#B8941F] transition-colors">
                    <i class="fa-regular fa-id-badge mr-3 w-4 text-center text-gray-400"></i>
                    My Profile
                </a>
                
               
                
                <div class="border-t border-gray-100 my-1"></div>
                
                <form method="POST" action="{{ url('/seller/logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                        <i class="fa-solid fa-arrow-right-from-bracket mr-3 w-4 text-center"></i> Logout
                    </button>
                </form>
            </div>
        </div>

    </div>
</header>
<!-- Recharge Modal -->
<!-- <div id="rechargeModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-md rounded-xl shadow-xl p-6 relative">

        <!-- Close Button -->
        <!-- <button onclick="closeRechargeModal()" 
            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h2 class="text-lg font-semibold mb-4">Recharge Wallet</h2>

        <form method="POST" action="{{ route('wallet.recharge') }}">
            @csrf
           <!-- quick select -->
            <!-- <div class="mb-4">
                <label class="text-sm text-gray-600">Select Amount</label>

                <div class="flex gap-2 mt-2 flex-wrap">
                    <button type="button" onclick="setAmount(100, this)" class="amt-btn">₹100</button>
                    <button type="button" onclick="setAmount(500, this)" class="amt-btn ">₹500</button>
                    <button type="button" onclick="setAmount(1000, this)" class="amt-btn">₹1000</button>
                    <button type="button" onclick="setAmount(2500, this)" class="amt-btn">₹2500</button>
                    <button type="button" onclick="setAmount(5000, this) class="amt-btn">₹5000</button>
                </div>
            </div> -->

            <!-- Amount -->
            <!-- <div class="mb-4">
                <label class="text-sm text-gray-600">Enter Amount</label>
                <input type="number" id="amountInput" name="amount" required min="1"
                    class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#D4AF37]/30 focus:border-[#D4AF37]">
            </div> -->

            <!-- Submit -->
           <!-- <button type="button" onclick="payNow()"
                class="w-full bg-gray-800 text-white py-2 rounded-lg">
                Pay & Recharge
            </button>
        </form> -->

    <!-- </div>
</div> --> 
<div id="rechargeModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-md rounded-xl shadow-xl p-6 relative">
        <button onclick="closeRechargeModal()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h2 class="text-lg font-semibold mb-4 text-[#673ab7] flex items-center">
             <i class="fa-solid fa-mobile-screen-button mr-2"></i> Recharge via PhonePe
        </h2>

       <form id="phonepeForm" method="POST" action="{{ route('phonepe.pay') }}">  
            @csrf
            <div class="mb-4">
                <label class="text-sm text-gray-600">Select Amount</label>
                <div class="flex gap-2 mt-2 flex-wrap">
                    <button type="button" onclick="setAmount(100, this)" class="amt-btn">₹100</button>
                    <button type="button" onclick="setAmount(500, this)" class="amt-btn ">₹500</button>
                    <button type="button" onclick="setAmount(1000, this)" class="amt-btn">₹1000</button>
                    <button type="button" onclick="setAmount(2000, this)" class="amt-btn">₹2000</button>
                </div>
            </div>

            <div class="mb-4">
                <label class="text-sm text-gray-600">Enter Amount (Min ₹1)</label>
                <input type="number" id="amountInput" name="amount" required min="1"
                    class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#673ab7]/30 focus:border-[#673ab7]">
            </div>

            <button type="submit" class="w-full bg-[#673ab7] hover:bg-[#512da8] text-white py-2.5 rounded-lg font-semibold transition-all shadow-md">
                Proceed to Pay ₹ <span id="btnAmount">0</span>
            </button>
            
            <p class="text-[10px] text-gray-400 mt-3 text-center italic">
                You will be redirected to PhonePe secure payment gateway.
            </p>
        </form>
    </div>
</div>
<script>
function openRechargeModal() {
    document.getElementById('rechargeModal').classList.remove('hidden');
    document.getElementById('rechargeModal').classList.add('flex');
}

function closeRechargeModal() {

    const modal = document.getElementById('rechargeModal');

    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>
<script>
function setAmount(value, element) {

    const input = document.getElementById('amountInput');
    const btnSpan = document.getElementById('btnAmount');

    input.value = value;
    btnSpan.innerText = value;

    document.querySelectorAll('.amt-btn').forEach(btn => {
        btn.classList.remove('active');
    });

    element.classList.add('active');
}

// Input box mein manual change par button update karna
document.getElementById('amountInput').addEventListener('input', function(e) {
    document.getElementById('btnAmount').innerText = e.target.value || 0;
});
</script>