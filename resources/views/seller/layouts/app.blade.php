<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Panel - fleetshyp</title>
    <link rel="icon" type="image/png" href="{{ asset('logo/fleetsheep1.png') }}">
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script> 
    
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background: #F5F1E8;
        }
        /* Hide scrollbar for sidebar */
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Custom Gold Colors */
        .bg-gold { background: #D4AF37; }
        .bg-gold-dark { background: #B8941F; }
        .text-gold { color: #D4AF37; }
        .border-gold { border-color: #D4AF37; }
        .hover\:bg-gold:hover { background: #D4AF37; }
        .hover\:text-gold:hover { color: #D4AF37; }
        
        /* Gradient backgrounds */
        .bg-gradient-gold {
            background: linear-gradient(135deg, #D4AF37 0%, #B8941F 100%);
        }
        .bg-gradient-cream {
            background: linear-gradient(135deg, #F5F1E8 0%, #EDE4D3 100%);
        }
        
        /* Card hover effects */
        .dashboard-card {
            transition: all 0.3s ease;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        /* Sidebar active state */
        .sidebar-link.active {
            background: rgba(212, 175, 55, 0.15);
            color: #D4AF37;
            border-left: 3px solid #D4AF37;
        }
        
        /* Smooth transitions */
        .transition-all-300 {
            transition: all 0.3s ease;
        }
    </style>
     @stack('styles')
</head>
<body class="h-screen overflow-hidden flex">

    @include('seller.layouts.partials.sidebar')

   <div class="flex-1 flex flex-col h-screen overflow-hidden">
        
        @include('seller.layouts.partials.topbar')

         <main class="flex-1 overflow-y-auto p-6 bg-[#F5F1E8]">
            @yield('content')
            
            @include('seller.layouts.partials.footer')
        </main>

    </div>



      <script>
        // Profile Dropdown Logic
        document.addEventListener('DOMContentLoaded', function() {
            const profileBtn = document.getElementById('profileDropdownBtn');
            const profileMenu = document.getElementById('profileDropdownMenu');
            const profileIcon = document.getElementById('profileDropdownIcon');

            profileBtn.addEventListener('click', function(event) {
                event.stopPropagation();
                
                if (profileMenu.classList.contains('hidden')) {
                    profileMenu.classList.remove('hidden');
                    setTimeout(() => {
                        profileMenu.classList.remove('opacity-0', 'scale-95');
                        profileMenu.classList.add('opacity-100', 'scale-100');
                        profileIcon.style.transform = "rotate(180deg)";
                    }, 10);
                } else {
                    closeMenu();
                }
            });

            function closeMenu() {
                profileMenu.classList.remove('opacity-100', 'scale-100');
                profileMenu.classList.add('opacity-0', 'scale-95');
                profileIcon.style.transform = "rotate(0deg)";
                setTimeout(() => {
                    profileMenu.classList.add('hidden');
                }, 200);
            }

            document.addEventListener('click', function(event) {
                if (!profileBtn.contains(event.target) && !profileMenu.contains(event.target)) {
                    if (!profileMenu.classList.contains('hidden')) {
                        closeMenu();
                    }
                }
            });

            // Sidebar Link Active State
            document.querySelectorAll('.sidebar-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    document.querySelectorAll('.sidebar-link').forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>
    
    @stack('scripts')

</body>
</html>