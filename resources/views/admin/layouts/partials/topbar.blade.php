<header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 sm:px-6 shrink-0 relative z-40">
    
    <div class="flex items-center flex-1 max-w-xl">
        
        <button id="openSidebar" class="mr-4 md:hidden text-gray-500 hover:text-indigo-600 focus:outline-none">
            <i class="fa-solid fa-bars text-xl"></i>
        </button>

        <div class="relative w-full">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input type="text" placeholder="AWB / Order Id" 
                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm transition-colors">
        </div>
    </div>

    <div class="flex items-center space-x-4 sm:space-x-6 ml-4">
        <div class="hidden sm:flex items-center space-x-4">
            <div class="text-right">
                <p class="text-[10px] font-bold text-gray-500 uppercase">Wallet</p>
                <p class="text-sm font-bold text-green-600">₹ 4,250.00</p>
            </div>
            <button class="bg-[#7C5CFC] hover:bg-[#684be0] text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center shadow-sm">
                <i class="fa-solid fa-wallet mr-2"></i> Recharge
            </button>
        </div>

        <div class="hidden sm:block h-6 w-px bg-gray-200"></div>

        <div class="flex items-center space-x-3 sm:space-x-4 text-gray-500">
            <button class="hover:text-indigo-600 transition-colors relative">
                <i class="fa-regular fa-bell text-lg"></i>
                <span class="absolute top-0 right-0 h-2 w-2 bg-red-500 rounded-full border-2 border-white"></span>
            </button>
            <button class="hover:text-indigo-600 transition-colors sm:hidden"><i class="fa-solid fa-wallet text-lg"></i></button>
        </div>

        <div class="relative">
            <div id="adminProfileBtn" class="w-9 h-9 rounded-full bg-indigo-100 border border-indigo-200 flex items-center justify-center text-indigo-700 font-bold text-sm cursor-pointer shrink-0 transition hover:bg-indigo-200 uppercase">
                {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
            </div>

            <div id="adminProfileMenu" class="hidden absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50 transform opacity-0 scale-95 transition-all duration-200 origin-top-right">
                
                <div class="px-4 py-3 border-b border-gray-100">
                    <p class="text-sm font-bold text-gray-800 truncate capitalize">{{ Auth::user()->name ?? 'Admin User' }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email ?? 'admin@smartship.com' }}</p>
                </div>
                
                <div class="py-1">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                        <i class="fa-regular fa-id-card mr-2 w-4 text-center"></i> My Profile
                    </a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                        <i class="fa-solid fa-gear mr-2 w-4 text-center"></i> Settings
                    </a>
                </div>
                
                <div class="border-t border-gray-100 my-1"></div>
                
                <form method="POST" action="{{ url('/logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors">
                        <i class="fa-solid fa-arrow-right-from-bracket mr-2 w-4 text-center"></i> Logout
                    </button>
                </form>
            </div>
        </div>

    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const adminBtn = document.getElementById('adminProfileBtn');
        const adminMenu = document.getElementById('adminProfileMenu');

        // Toggle function on click
        if(adminBtn && adminMenu) {
            adminBtn.addEventListener('click', function(event) {
                event.stopPropagation();
                
                if (adminMenu.classList.contains('hidden')) {
                    adminMenu.classList.remove('hidden');
                    setTimeout(() => {
                        adminMenu.classList.remove('opacity-0', 'scale-95');
                        adminMenu.classList.add('opacity-100', 'scale-100');
                    }, 10);
                } else {
                    adminMenu.classList.remove('opacity-100', 'scale-100');
                    adminMenu.classList.add('opacity-0', 'scale-95');
                    setTimeout(() => {
                        adminMenu.classList.add('hidden');
                    }, 200);
                }
            });

            // Close when clicking outside
            document.addEventListener('click', function(event) {
                if (!adminBtn.contains(event.target) && !adminMenu.contains(event.target)) {
                    if (!adminMenu.classList.contains('hidden')) {
                        adminMenu.classList.remove('opacity-100', 'scale-100');
                        adminMenu.classList.add('opacity-0', 'scale-95');
                        setTimeout(() => {
                            adminMenu.classList.add('hidden');
                        }, 200);
                    }
                }
            });
        }
    });
</script>