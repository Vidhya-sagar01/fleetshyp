<aside class="group w-16 hover:w-64 bg-[#1E2A3A] text-white flex flex-col h-full shrink-0 transition-all duration-300 z-50 relative overflow-x-hidden shadow-xl">

    {{-- <div class="h-16 flex items-center justify-center border-b border-white/10 shrink-0 group-hover:justify-start group-hover:px-4">
        <div class="flex items-center min-w-max">
            <div class="w-10 h-10 rounded-xl bg-linear-to-br from-[#D4AF37] to-[#B8941F] flex items-center justify-center shadow-lg overflow-hidden">
                <img src="{{ asset('logo/fleetsheep1.png') }}" alt="SmartShip Logo" class="w-12 h-7 object-contain">
            </div>
            <div class="ml-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                <span class="text-xl font-bold text-white tracking-tight">Smart<span class="text-[#D4AF37]">Ship</span></span> --}}
            {{-- </div>
        </div>
    </div> --}}
    <div class="h-16 flex items-center justify-center border-b border-white/10 shrink-0">

    <div class="flex items-center justify-center w-full">

        <div class="w-100 h-10 rounded-xl bg-linear-to-br from-[#D4AF37] to-[#B8941F] flex items-center justify-center shadow-lg overflow-hidden">
            <img src="{{ asset('logo/fleetsheep1.png') }}" alt="SmartShip Logo"
                class="w-12 h-7 object-contain">
        </div>

    </div>

</div>

    <div class="flex-1 overflow-y-auto py-4 space-y-1 scrollbar-hide">
        
        <!-- Dashboard -->
        <div class="px-2">
            <a href="{{ route('seller.dashboard') }}" class="sidebar-link {{ request()->routeIs('seller.dashboard') ? 'active' : '' }} flex items-center justify-center group-hover:justify-start px-3 py-3 text-[#D4AF37] hover:bg-white/5 rounded-lg transition-all duration-300 relative min-w-max">
                <i class="fa-solid fa-chart-pie text-lg w-6 text-center text-[#D4AF37]"></i>
                <span class="ml-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap font-medium text-sm">Dashboard</span>
            </a>
        </div>

        <div class="px-3 py-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <div class="h-px bg-white/10"></div>
        </div>

        <!-- Order Section -->
        <div class="px-3 py-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Order</p>
        </div>

        <!-- Mini Order -->
        <div class="px-2">
            <a href="{{route('orders.index')}}" class="sidebar-link {{ request()->routeIs('seller.company.*') ? 'active' : '' }} flex items-center justify-center group-hover:justify-start px-3 py-3 text-[#D4AF37] hover:bg-white/5 rounded-lg transition-all duration-300 relative min-w-max">
                <i class="fa-solid fa-building text-lg w-6 text-center text-[#D4AF37]"></i>
                <span class="ml-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap font-medium text-sm">B2C Order</span>
            </a>
        </div>
         <div class="px-2">
            <a href="{{route('rapidshyp.b2c.orders.index')}}" class="sidebar-link {{ request()->routeIs('seller.company.*') ? 'active' : '' }} flex items-center justify-center group-hover:justify-start px-3 py-3 text-[#D4AF37] hover:bg-white/5 rounded-lg transition-all duration-300 relative min-w-max">
                <i class="fa-solid fa-building text-lg w-6 text-center text-[#D4AF37]"></i>
                <span class="ml-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap font-medium text-sm">B2B Orders</span>
            </a>
        </div>
          <div class="px-2">
            <a href="{{route('shipping.create')}}" class="sidebar-link {{ request()->routeIs('seller.company.*') ? 'active' : '' }} flex items-center justify-center group-hover:justify-start px-3 py-3 text-[#D4AF37] hover:bg-white/5 rounded-lg transition-all duration-300 relative min-w-max">
                <i class="fa-solid fa-building text-lg w-6 text-center text-[#D4AF37]"></i>
                <span class="ml-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap font-medium text-sm">B2B Shipping</span>
            </a>
        </div>

        

        <!-- ✅ NDR Dropdown - Unified Toggle -->
        <div class="px-2">
            <button type="button" onclick="toggleMenu('ndr')" 
                class="w-full flex items-center justify-between px-3 py-3 text-[#D4AF37] hover:bg-white/5 rounded-lg  duration-300 min-w-max cursor-pointer">
                <a href="#" class="flex items-center  sidebar-link {{ request()->routeIs('seller.ndr.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-box-open text-lg w-6 text-center"></i>
                    <span class="ml-3  text-sm">NDR</span>
                </a>
                <i id="arrow-ndr" class="fa-solid fa-chevron-down text-xs opacity-0 group-hover:opacity-100 transition-transform duration-300"></i>
            </button>
            <div id="menu-ndr" class="hidden flex-col gap-1 mt-1 pl-10 pr-2">
                <a href="{{ route('fship.ndr.action') }}"
                    class="block py-2 px-3 text-sm rounded-md transition-colors
                    {{ request()->routeIs('seller.ndr.mini') ? 'text-[#D4AF37] bg-white/5 font-medium' : 'text-gray-400 hover:text-[#D4AF37] hover:bg-white/5' }}">
                    <i class="fa-solid fa-layer-group mr-2"></i> B2C NDR
                </a>
            </div>
        </div>

        <!-- ✅ REVERSE Link -->
        <div class="px-2">
            <a href="{{ route('index') }}"
                class="sidebar-link {{ request()->routeIs('seller.NDR.reversed') ? 'active' : '' }} flex items-center justify-center group-hover:justify-start px-3 py-3 text-[#D4AF37] hover:bg-white/5 rounded-lg transition-all duration-300 relative min-w-max">
                <i class="fa-solid fa-arrow-rotate-left text-lg w-6 text-center text-[#D4AF37]"></i>
                <span class="ml-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap font-medium text-sm">REVERSE</span>
            </a>
        </div>

        <div class="px-3 py-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <div class="h-px bg-white/10"></div>
        </div>

        <!-- Operations Section -->
        <div class="px-3 py-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Operations</p>
        </div>

        <!-- ✅ Billing Dropdown - Unified Toggle -->
        <div class="px-2">
            <button type="button" onclick="toggleMenu('billing')"
                class="w-full flex items-center justify-between px-3 py-3 text-[#D4AF37] hover:bg-white/5 rounded-lg transition-all duration-300 min-w-max cursor-pointer">
                <div class="flex items-center">
                    <i class="fa-solid fa-file-invoice text-lg w-6 text-center text-[#D4AF37]"></i>
                    <span class="ml-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap font-medium text-sm">Billing</span>
                </div>
                <i id="arrow-billing" class="fa-solid fa-chevron-down text-xs opacity-0 group-hover:opacity-100 transition-transform duration-300"></i>
            </button>
            <div id="menu-billing" class="hidden flex-col gap-1 mt-1 pl-10 pr-2">
                <a href="{{ route('transactions.index') }}"
                    class="block py-2 px-3 text-sm text-gray-400 hover:text-[#D4AF37] hover:bg-white/5 rounded-md transition-colors relative before:content-[''] before:absolute before:w-1.5 before:h-1.5 before:bg-gray-500 before:rounded-full before:-left-3 before:top-1/2 before:-translate-y-1/2 hover:before:bg-[#D4AF37]">
                    Wallet Transactions
                </a>
                <a href="{{ route('wallet.recharges') }}"
                    class="block py-2 px-3 text-sm text-gray-400 hover:text-[#D4AF37] hover:bg-white/5 rounded-md transition-colors relative before:content-[''] before:absolute before:w-1.5 before:h-1.5 before:bg-gray-500 before:rounded-full before:-left-3 before:top-1/2 before:-translate-y-1/2 hover:before:bg-[#D4AF37]">
                    Recharge History
                </a>
                <a href="{{route('seller.billing.codRemittance')}}"
                    class="block py-2 px-3 text-sm text-gray-400 hover:text-[#D4AF37] hover:bg-white/5 rounded-md transition-colors relative before:content-[''] before:absolute before:w-1.5 before:h-1.5 before:bg-gray-500 before:rounded-full before:-left-3 before:top-1/2 before:-translate-y-1/2 hover:before:bg-[#D4AF37]">
                    COD Remittance
                </a>
                <a href="{{route('seller.billing.shipping')}}" 
                    class="block py-2 px-3 text-sm text-gray-400 hover:text-[#D4AF37] hover:bg-white/5 rounded-md transition-colors relative before:content-[''] before:absolute before:w-1.5 before:h-1.5 before:bg-gray-500 before:rounded-full before:-left-3 before:top-1/2 before:-translate-y-1/2 hover:before:bg-[#D4AF37]">
                    Shipping Charges
                </a>
            </div>
        </div>

        <!-- ✅ Tools Dropdown with Nested - Unified Toggle -->
        <div class="px-2">
            <button type="button" onclick="toggleMenu('tools')"
                class="w-full flex items-center justify-between px-3 py-3 text-[#D4AF37] hover:bg-white/5 rounded-lg transition-all duration-300 min-w-max cursor-pointer">
                <div class="flex items-center">
                    <i class="fa-solid fa-tools text-lg w-6 text-center text-[#D4AF37]"></i>
                    <span class="ml-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap font-medium text-sm">Tools</span>
                </div>
                <i id="arrow-tools" class="fa-solid fa-chevron-down text-xs opacity-0 group-hover:opacity-100 transition-transform duration-300"></i>
            </button>
            <div id="menu-tools" class="hidden flex-col gap-1 mt-1 pl-10 pr-2">

                <!-- Rate Card Nested -->
             <a href="{{ route('ratecard.index') }}"
                     class="w-full flex items-center justify-between py-2 px-3 text-sm text-gray-400 hover:text-[#D4AF37] hover:bg-white/5 rounded-md transition-colors">
                         <span class="flex items-center">
                           <i class="fa-solid fa-tag mr-2"></i> Rate Card
                        </span>
              </a>
            </div>
        </div>

        <!-- Reports -->
        {{-- <div class="px-2">
            <a href="{{ route('seller.report.index') }}"
                class="sidebar-link {{ request()->routeIs('seller.communication.*') ? 'active' : '' }} flex items-center justify-center group-hover:justify-start px-3 py-3 text-[#D4AF37] hover:bg-white/5 rounded-lg transition-all duration-300 relative min-w-max">
                <i class="fa-solid fa-book text-lg w-6 text-center text-[#D4AF37]"></i>
                <span class="ml-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap font-medium text-sm">Reports</span>
            </a>
        </div> --}}

        <!-- Buyers Communication -->
       

        <div class="px-3 py-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <div class="h-px bg-white/10"></div>
        </div>

        <!-- Configuration Section -->
        <div class="px-3 py-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Configuration</p>
        </div>

       
     

       

        <!-- Settings -->
        <div class="px-2">
            <a href="{{ route('seller.settings') }}" class="sidebar-link {{ request()->routeIs('seller.settings') ? 'active' : '' }} flex items-center justify-center group-hover:justify-start px-3 py-3 text-[#D4AF37] hover:bg-white/5 rounded-lg transition-all duration-300 relative min-w-max">
                <i class="fa-solid fa-gear text-lg w-6 text-center text-[#D4AF37]"></i>
                <span class="ml-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap font-medium text-sm">Settings</span>
            </a>
        </div>

        <!-- ✅ Help Center Dropdown - Unified Toggle -->
        <div class="px-2">
            <button type="button" onclick="toggleMenu('helpCenter')"
                class="w-full flex items-center justify-between px-3 py-3 text-[#D4AF37] hover:bg-white/5 rounded-lg transition-all duration-300 min-w-max cursor-pointer">
                <div class="flex items-center">
                    <i class="fa-solid fa-circle-question text-lg w-6 text-center text-[#D4AF37]"></i>
                    <span class="ml-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap font-medium text-sm">Help Center</span>
                </div>
                <i id="arrow-helpCenter" class="fa-solid fa-chevron-down text-xs opacity-0 group-hover:opacity-100 transition-transform duration-300"></i>
            </button>
            <div id="menu-helpCenter" class="hidden flex-col gap-1 mt-1 pl-10 pr-2">
                <a href="/seller/ticket/index"
                    class="block py-2 px-3 text-sm text-gray-400 hover:text-[#D4AF37] hover:bg-white/5 rounded-md transition-colors relative before:content-[''] before:absolute before:w-1.5 before:h-1.5 before:bg-gray-500 before:rounded-full before:-left-3 before:top-1/2 before:-translate-y-1/2 hover:before:bg-[#D4AF37]">
                    <i class="fa-solid fa-ticket mr-2"></i> Ticket
                </a>
            </div>
        </div>

    </div>
</aside>

<style>
    .sidebar-link.active {
        background: rgba(212, 175, 55, 0.2) !important;
        color: #D4AF37 !important;
        border-left: 3px solid #D4AF37;
    }
    .sidebar-link.active i { color: #D4AF37 !important; }
    .sidebar-link:hover { background: rgba(255, 255, 255, 0.08); }
    
    /* Smooth dropdown transitions */
    [id^="menu-"] {
        transform-origin: top;
        transition: all 0.3s ease-in-out;
    }
    [id^="arrow-"] {
        transition: transform 0.3s ease;
    }
    [id^="arrow-"].rotated {
        transform: rotate(180deg);
    }
</style>

<script>
    // ✅ SINGLE TOGGLE FUNCTION FOR ALL MENUS
    function toggleMenu(menuKey) {
        const menu = document.getElementById('menu-' + menuKey);
        const arrow = document.getElementById('arrow-' + menuKey);
        
        if (!menu || !arrow) return;
        
        const isHidden = menu.classList.contains('hidden');
        
        // Close ALL menus first (accordion style - optional, remove if you want multiple open)
        document.querySelectorAll('[id^="menu-"]').forEach(m => {
            if (m.id !== 'menu-' + menuKey) {
                m.classList.add('hidden');
                m.classList.remove('flex');
                const arr = document.getElementById(m.id.replace('menu-', 'arrow-'));
                if (arr) arr.classList.remove('rotated');
            }
        });
        
        // Toggle clicked menu
        if (isHidden) {
            menu.classList.remove('hidden');
            menu.classList.add('flex');
            arrow.classList.add('rotated');
        } else {
            menu.classList.add('hidden');
            menu.classList.remove('flex');
            arrow.classList.remove('rotated');
        }
    }

    // ✅ Close all menus when sidebar collapses (on mobile/small hover out)
    document.querySelector('aside')?.addEventListener('mouseleave', function() {
        if (!this.classList.contains('group-hover:w-64')) {
            document.querySelectorAll('[id^="menu-"]').forEach(m => {
                m.classList.add('hidden');
                m.classList.remove('flex');
            });
            document.querySelectorAll('[id^="arrow-"]').forEach(a => a.classList.remove('rotated'));
        }
    });

    // ✅ Keep active parent menu open on page load
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('[id^="menu-"]').forEach(menu => {
            if (menu.querySelector('.sidebar-link.active, [class*="text-[#D4AF37]"].font-medium')) {
                menu.classList.remove('hidden');
                menu.classList.add('flex');
                const arrowId = menu.id.replace('menu-', 'arrow-');
                const arrow = document.getElementById(arrowId);
                if (arrow) arrow.classList.add('rotated');
            }
        });
    });
</script>