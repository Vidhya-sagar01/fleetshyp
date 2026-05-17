<!-- Mobile Overlay -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden transition-opacity opacity-0"></div>

<!-- Mobile Toggle Button (Header mein add karein) -->
<button id="openSidebar" class="md:hidden fixed top-4 left-4 z-50 bg-[#261E51] text-white p-2.5 rounded-lg shadow-lg hover:bg-indigo-900 transition">
    <i class="fa-solid fa-bars text-lg"></i>
</button>

<!-- Sidebar -->
<aside id="sidebar" class="w-64 bg-[#261E51] text-white flex flex-col h-screen shrink-0 transition-transform duration-300 fixed inset-y-0 left-0 z-50 transform -translate-x-full md:relative md:translate-x-0">
    
    <!-- Header -->
    <div class="h-16 flex items-center justify-between px-6 border-b border-indigo-900/50 shrink-0">
        <div class="flex items-center">
            <div class="bg-orange-500 text-white p-1.5 rounded-lg mr-3">
                <i class="fa-solid fa-truck-fast text-sm"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold tracking-wide">Fleetshyp</h1>
                <p class="text-[10px] text-indigo-300 uppercase tracking-wider -mt-1">Admin Console</p>
            </div>
        </div>
        <button id="closeSidebar" class="md:hidden text-indigo-300 hover:text-white focus:outline-none p-1">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>
    </div>

    <!-- Menu Items -->
    <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1 custom-scrollbar">
        
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2.5 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-500/20 text-indigo-100 border border-indigo-500/30' : 'text-indigo-200 hover:text-white hover:bg-indigo-900/50' }} rounded-lg transition-colors">
            <i class="fa-solid fa-chart-pie w-5 {{ request()->routeIs('admin.dashboard') ? 'text-indigo-400' : '' }}"></i>
            <span class="ml-3 font-medium text-sm">Dashboard Overview</span>
        </a>

        <!-- Customers Menu -->
        <div>
            <button type="button" 
                    data-submenu="customers-menu"
                    data-icon="customers-icon"
                    class="submenu-toggle w-full flex items-center justify-between px-3 py-2 text-indigo-200 hover:text-white hover:bg-indigo-900/50 rounded-lg transition-colors">
                <div class="flex items-center">
                    <i class="fa-solid fa-users w-5"></i>
                    <span class="ml-3 font-medium text-sm">Customers</span>
                </div>
                <i id="customers-icon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
            </button>
            <div id="customers-menu" class="submenu-content hidden flex-col pl-11 pr-3 py-1 space-y-2 mt-1">
                <a href="{{ route('admin.customers.index') }}" class="text-xs text-indigo-300 hover:text-white transition-colors relative before:content-[''] before:absolute before:w-1.5 before:h-1.5 before:bg-indigo-500 before:rounded-full before:-left-4 before:top-1/2 before:-translate-y-1/2">Customers List</a>
                <a href="{{route('kyc.pending')}}" class="text-xs text-indigo-300 hover:text-white transition-colors relative before:content-[''] before:absolute before:w-1.5 before:h-1.5 before:bg-indigo-500 before:rounded-full before:-left-4 before:top-1/2 before:-translate-y-1/2">KYC Details</a>
                <a href="{{route('kyc.approved')}}" class="text-xs text-indigo-300 hover:text-white transition-colors relative before:content-[''] before:absolute before:w-1.5 before:h-1.5 before:bg-indigo-500 before:rounded-full before:-left-4 before:top-1/2 before:-translate-y-1/2">KYC Appreved List</a>
                <a href="{{route('kyc.rejected')}}" class="text-xs text-indigo-300 hover:text-white transition-colors relative before:content-[''] before:absolute before:w-1.5 before:h-1.5 before:bg-indigo-500 before:rounded-full before:-left-4 before:top-1/2 before:-translate-y-1/2">KYC Rejected List</a>

            </div>
        </div>


         <div>
            <button type="button" 
                    data-submenu="agreements-menu"
                    data-icon="agreements-icon"
                    class="submenu-toggle w-full flex items-center justify-between px-3 py-2 text-indigo-200 hover:text-white hover:bg-indigo-900/50 rounded-lg transition-colors">
                <div class="flex items-center">
                    <i class="fa-solid fa-triangle-exclamation w-5"></i>
                    <span class="ml-3 font-medium text-sm">Agreements</span>
                </div>
                <i id="agreements-icon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
            </button>
            <div id="agreements-menu" class="submenu-content hidden flex-col pl-11 pr-3 py-1 space-y-2 mt-1">
                <a href="{{ route('admin.agreements.index')}}" class="text-xs text-indigo-300 hover:text-white transition-colors">Upload New Version</a>
                <a href="{{route('admin.agreements.signedList')}}" class="text-xs text-indigo-300 hover:text-white transition-colors">Agreements signed list</a>
            </div>
        </div>

        <!-- Bank Menu -->

        <div>
    <button type="button" 
            data-submenu="bank-menu"
            data-icon="bank-icon"
            class="submenu-toggle w-full flex items-center justify-between px-3 py-2 text-indigo-200 hover:text-white hover:bg-indigo-900/50 rounded-lg transition-colors">
        <div class="flex items-center">
            {{-- ✅ Fixed: Bank Icon instead of Cart --}}
            <i class="fa-solid fa-building-columns w-5"></i>
            <span class="ml-3 font-medium text-sm">Bank</span>
        </div>
        <i id="bank-icon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
    </button>
    
   
    <div id="bank-menu" class="submenu-content hidden flex-col pl-11 pr-3 py-1 space-y-2 mt-1">
        <a href="{{route('admin.bank.index')}}" 
           class="text-xs text-indigo-300 hover:text-white transition-colors relative before:content-[''] before:absolute before:w-1.5 before:h-1.5 before:bg-indigo-500 before:rounded-full before:-left-4 before:top-1/2 before:-translate-y-1/2">
            <i class="fa-solid fa-building-columns mr-2"></i>Seller Bank detials
        <a href="{{route('admin.bank.approved')}}" 
           class="text-xs text-indigo-300 hover:text-white transition-colors relative before:content-[''] before:absolute before:w-1.5 before:h-1.5 before:bg-indigo-500 before:rounded-full before:-left-4 before:top-1/2 before:-translate-y-1/2">
            <i class="fa-solid fa-money-bill-transfer mr-2"></i>Bank Apprevel list
        </a>
        {{-- <a href="#" 
           class="text-xs text-indigo-300 hover:text-white transition-colors relative before:content-[''] before:absolute before:w-1.5 before:h-1.5 before:bg-indigo-500 before:rounded-full before:-left-4 before:top-1/2 before:-translate-y-1/2">
            <i class="fa-solid fa-arrow-right-arrow-left mr-2"></i>Transactions
        </a> --}}
       
    </div>
</div>

        <div>
            <button type="button" 
                    data-submenu="orders-menu"
                    data-icon="orders-icon"
                    class="submenu-toggle w-full flex items-center justify-between px-3 py-2 text-indigo-200 hover:text-white hover:bg-indigo-900/50 rounded-lg transition-colors">
                <div class="flex items-center">
                    <i class="fa-solid fa-cart-shopping w-5"></i>
                    <span class="ml-3 font-medium text-sm">Orders</span>
                </div>
                <i id="orders-icon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
            </button>
            <div id="orders-menu" class="submenu-content hidden flex-col pl-11 pr-3 py-1 space-y-2 mt-1">
                <a href="{{Route('miniOerder.index')}}" class="text-xs text-indigo-300 hover:text-white transition-colors relative before:content-[''] before:absolute before:w-1.5 before:h-1.5 before:bg-indigo-500 before:rounded-full before:-left-4 before:top-1/2 before:-translate-y-1/2">Mini order</a>
                <a href="#" class="text-xs text-indigo-300 hover:text-white transition-colors relative before:content-[''] before:absolute before:w-1.5 before:h-1.5 before:bg-indigo-500 before:rounded-full before:-left-4 before:top-1/2 before:-translate-y-1/2">B2B Orders</a>
            </div>
        </div>

<div>

    <!-- COURIER MENU BUTTON -->
    <button type="button" 
        data-submenu="courier-menu"
        data-icon="courier-icon"
        class="submenu-toggle w-full flex items-center justify-between px-3 py-2 text-indigo-200 hover:text-white hover:bg-indigo-900/50 rounded-lg transition-colors">

        <div class="flex items-center">
            <i class="fa-solid fa-truck w-5"></i> 
            <span class="ml-3 font-medium text-sm">Courier Manage</span>
        </div>

        <i id="courier-icon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
    </button>

    <!-- SUBMENU -->
    <div id="courier-menu" class="submenu-content hidden flex-col pl-11 pr-3 py-1 space-y-2 mt-1">

        <!-- LIST -->
        <a href="{{ route('couriers.index') }}" 
            class="text-xs text-indigo-300 hover:text-white transition-colors relative before:content-[''] before:absolute before:w-1.5 before:h-1.5 before:bg-indigo-500 before:rounded-full before:-left-4 before:top-1/2 before:-translate-y-1/2">
             fship Couriers
        </a>

    </div>

</div>

<div>
        <button type="button" 
                data-submenu="card-menu"
                data-icon="rate-icon-chevron"
                class="submenu-toggle w-full flex items-center justify-between px-3 py-2 text-indigo-200 hover:text-white hover:bg-indigo-900/50 rounded-lg transition-colors">
                   <div class="flex items-center">
                       <i class="fa-solid fa-scale-balanced w-5"></i> 
                       <span class="ml-3 font-medium text-sm">Rate Card</span>
                  </div>
                <i id="rate-icon-chevron" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
        </button>
           <div id="card-menu" class="submenu-content hidden flex-col pl-11 pr-3 py-1 space-y-2 mt-1">
                <a href="{{route('rate-cards.index')}}" 
                     class="text-xs text-indigo-300 hover:text-white transition-colors relative before:content-[''] before:absolute before:w-1.5 before:h-1.5 before:bg-indigo-500 before:rounded-full before:-left-4 before:top-1/2 before:-translate-y-1/2">
                     Mini Parcel (500g)
                 </a>
                 <a href="{{route('rate-cards.index')}}" 
                      class="text-xs text-indigo-300 hover:text-white transition-colors relative before:content-[''] before:absolute before:w-1.5 before:h-1.5 before:bg-indigo-500 before:rounded-full before:-left-4 before:top-1/2 before:-translate-y-1/2">
                      Mini Parcel history
                </a>
                 <a href="{{route('Rapidshyp.rate-cards.index')}}" 
                    class="text-xs text-indigo-300 hover:text-white transition-colors relative before:content-[''] before:absolute before:w-1.5 before:h-1.5 before:bg-indigo-500 before:rounded-full before:-left-4 before:top-1/2 before:-translate-y-1/2">
                    B2B Orders
                 </a>
          </div>
</div>



        <!-- Reverse Orders -->
        <a href="#" class="flex items-center px-3 py-2 text-indigo-200 hover:text-white hover:bg-indigo-900/50 rounded-lg transition-colors">
            <i class="fa-solid fa-arrow-right-arrow-left w-5"></i>
            <span class="ml-3 font-medium text-sm">Reverse Orders</span>
        </a>

        <!-- Divider -->
        <div class="h-px bg-indigo-900/50 my-3"></div>

        <!-- NDR Management -->
        <div>
            <button type="button" 
                    data-submenu="ndr-menu"
                    data-icon="ndr-icon"
                    class="submenu-toggle w-full flex items-center justify-between px-3 py-2 text-indigo-200 hover:text-white hover:bg-indigo-900/50 rounded-lg transition-colors">
                <div class="flex items-center">
                    <i class="fa-solid fa-triangle-exclamation w-5"></i>
                    <span class="ml-3 font-medium text-sm">NDR Management</span>
                </div>
                <i id="ndr-icon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
            </button>
            <div id="ndr-menu" class="submenu-content hidden flex-col pl-11 pr-3 py-1 space-y-2 mt-1">
                <a href="#" class="text-xs text-indigo-300 hover:text-white transition-colors">NDR Pending</a>
                <a href="#" class="text-xs text-indigo-300 hover:text-white transition-colors">Fake Attempts</a>
                <a href="#" class="text-xs text-indigo-300 hover:text-white transition-colors">Re-Attempts</a>
            </div>
        </div>

        <!-- Seller Management -->
        <div>
            <button type="button" 
                    data-submenu="seller-menu"
                    data-icon="seller-icon"
                    class="submenu-toggle w-full flex items-center justify-between px-3 py-2 text-indigo-200 hover:text-white hover:bg-indigo-900/50 rounded-lg transition-colors">
                <div class="flex items-center">
                    <i class="fa-solid fa-users-gear w-5"></i>
                    <span class="ml-3 font-medium text-sm">Seller Management</span>
                </div>
                <i id="seller-icon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
            </button>
            <div id="seller-menu" class="submenu-content hidden flex-col pl-11 pr-3 py-1 space-y-2 mt-1">
                <a href="#" class="text-xs text-indigo-300 hover:text-white transition-colors">Profile & Login Info</a>
                <a href="#" class="text-xs text-indigo-300 hover:text-white transition-colors">KYC Approvals</a>
                <a href="#" class="text-xs text-indigo-300 hover:text-white transition-colors">Bank Approvals</a>
                <a href="#" class="text-xs text-indigo-300 hover:text-white transition-colors">Rate Card Settings</a>
                <a href="#" class="text-xs text-indigo-300 hover:text-white transition-colors">Credit Limits</a>
                <a href="#" class="text-xs text-indigo-300 hover:text-white transition-colors">Wallet & Transactions</a>
            </div>
        </div>

        <!-- Couriers Panel -->
        <a href="#" class="flex items-center px-3 py-2 text-indigo-200 hover:text-white hover:bg-indigo-900/50 rounded-lg transition-colors">
            <i class="fa-solid fa-plane-departure w-5"></i>
            <span class="ml-3 font-medium text-sm">Couriers Panel</span>
        </a>

        <!-- Divider -->
        <div class="h-px bg-indigo-900/50 my-3"></div>

        <!-- Billing & Payments -->
        <div>
            <button type="button" 
                    data-submenu="billing-menu"
                    data-icon="billing-icon"
                    class="submenu-toggle w-full flex items-center justify-between px-3 py-2 text-indigo-200 hover:text-white hover:bg-indigo-900/50 rounded-lg transition-colors">
                <div class="flex items-center">
                    <i class="fa-solid fa-file-invoice-dollar w-5"></i>
                    <span class="ml-3 font-medium text-sm">Billing & Payments</span>
                </div>
                <i id="billing-icon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
            </button>
            <div id="billing-menu" class="submenu-content hidden flex-col pl-11 pr-3 py-1 space-y-2 mt-1">
                <a href="{{route('user.rerharge.index')}}" class="text-xs text-indigo-300 hover:text-white transition-colors">Customer Wise Data</a>
                <a href="{{route('codRemittance.index')}}" class="text-xs text-indigo-300 hover:text-white transition-colors">Cod Remittances</a>
                <a href="#" class="text-xs text-indigo-300 hover:text-white transition-colors">Fship Payments</a>
            </div>
        </div>

        <!-- Issue Management -->
        <div>
            <button type="button" 
                    data-submenu="support-menu"
                    data-icon="support-icon"
                    class="submenu-toggle w-full flex items-center justify-between px-3 py-2 text-indigo-200 hover:text-white hover:bg-indigo-900/50 rounded-lg transition-colors">
                <div class="flex items-center">
                    <i class="fa-solid fa-headset w-5"></i>
                    <span class="ml-3 font-medium text-sm">Issue Management</span>
                </div>
                <i id="support-icon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
            </button>
            <div id="support-menu" class="submenu-content hidden flex-col pl-11 pr-3 py-1 space-y-2 mt-1">
                <a href="#" class="text-xs text-indigo-300 hover:text-white transition-colors">Weight Issues</a>
                <a href="#" class="text-xs text-indigo-300 hover:text-white transition-colors">Pickup & Delivery</a>
                <a href="#" class="text-xs text-indigo-300 hover:text-white transition-colors">Payment & COD</a>
            </div>
        </div>

        <!-- Divider -->
        <div class="h-px bg-indigo-900/50 my-3"></div>

        <!-- Tools -->
        <a href="#" class="flex items-center px-3 py-2 text-indigo-200 hover:text-white hover:bg-indigo-900/50 rounded-lg transition-colors">
            <i class="fa-solid fa-screwdriver-wrench w-5"></i>
            <span class="ml-3 font-medium text-sm">Tools</span>
        </a>

        <!-- Reports -->
        <a href="#" class="flex items-center px-3 py-2 text-indigo-200 hover:text-white hover:bg-indigo-900/50 rounded-lg transition-colors">
            <i class="fa-solid fa-chart-line w-5"></i>
            <span class="ml-3 font-medium text-sm">Reports</span>
        </a>

        <!-- User Management -->
        <a href="#" class="flex items-center px-3 py-2 text-indigo-200 hover:text-white hover:bg-indigo-900/50 rounded-lg transition-colors">
            <i class="fa-solid fa-user-shield w-5"></i>
            <span class="ml-3 font-medium text-sm">User Management</span>
        </a>

        <!-- Settings -->
        <a href="#" class="flex items-center px-3 py-2 text-indigo-200 hover:text-white hover:bg-indigo-900/50 rounded-lg transition-colors">
            <i class="fa-solid fa-gear w-5"></i>
            <span class="ml-3 font-medium text-sm">Settings</span>
        </a>

    </div>

    <!-- User Profile Footer -->
    <div class="p-4 border-t border-indigo-900/50 bg-[#1e1742] shrink-0">
        <div class="flex items-center">
            <div class="w-9 h-9 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold text-sm shadow-lg">
                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="ml-3 overflow-hidden flex-1">
                <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name ?? 'Admin User' }}</p>
                <p class="text-[10px] text-indigo-300 truncate">{{ Auth::user()->email ?? 'admin@smartship.io' }}</p>
            </div>
            
            <form method="POST" action="{{ route('logout') }}" class="ml-2">
                @csrf
                <button type="submit" class="text-indigo-400 hover:text-red-400 transition-colors p-1.5 rounded-lg hover:bg-indigo-900/50" title="Logout">
                    <i class="fa-solid fa-power-off text-sm"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- CSS for Custom Scrollbar -->
@push('styles')
<style>
    /* Custom Scrollbar for Sidebar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(99, 102, 241, 0.1);
        border-radius: 2px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(99, 102, 241, 0.4);
        border-radius: 2px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(99, 102, 241, 0.6);
    }
    
    /* Smooth transitions */
    #sidebar {
        will-change: transform;
    }
    
    /* Active link indicator */
    .submenu-content a:hover::before {
        background: #fff;
        transition: background 0.2s;
    }
</style>
@endpush

<!-- JavaScript for Sidebar Interactions -->
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const openBtn = document.getElementById('openSidebar');
    const closeBtn = document.getElementById('closeSidebar');
    
    // Open Sidebar (Mobile)
    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
        // Small delay for opacity transition
        setTimeout(() => overlay.classList.remove('opacity-0'), 10);
        document.body.style.overflow = 'hidden'; // Prevent background scroll
    }
    
    // Close Sidebar (Mobile)
    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('opacity-0');
        setTimeout(() => overlay.classList.add('hidden'), 300); // Match transition duration
        document.body.style.overflow = '';
    }
    
    // Event Listeners
    if (openBtn) openBtn.addEventListener('click', openSidebar);
    if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
    if (overlay) overlay.addEventListener('click', closeSidebar);
    
    // Submenu Toggle (Using data attributes - works for all menus)
    document.querySelectorAll('.submenu-toggle').forEach(button => {
        button.addEventListener('click', function() {
            const menuId = this.dataset.submenu;
            const iconId = this.dataset.icon;
            const menu = document.getElementById(menuId);
            const icon = document.getElementById(iconId);
            
            if (menu && icon) {
                // Toggle visibility
                menu.classList.toggle('hidden');
                menu.classList.toggle('flex');
                
                // Rotate icon
                icon.style.transform = menu.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
            }
        });
    });
    
    // Close sidebar on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) {
            closeSidebar();
        }
    });
    
    // Auto-open submenu if active link is inside
    document.querySelectorAll('.submenu-content a').forEach(link => {
        if (link.href === window.location.href) {
            const menu = link.closest('.submenu-content');
            const toggle = menu?.previousElementSibling;
            const iconId = toggle?.dataset.icon;
            const icon = iconId ? document.getElementById(iconId) : null;
            
            if (menu && toggle && icon) {
                menu.classList.remove('hidden');
                menu.classList.add('flex');
                icon.style.transform = 'rotate(180deg)';
            }
        }
    });
});
</script>
@endpush