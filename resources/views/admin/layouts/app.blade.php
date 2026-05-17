<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta property="og:title" content="Seller Login - FleetShyp">
     <meta property="og:image" content="{{ asset('logo/fleetsheep1.png') }}">
     <meta property="og:type" content="website">
    <title>Admin fleetshyp</title>
    <link rel="icon" type="image/png" href="{{ asset('logo/fleetsheep1.png') }}">
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
   
   
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Custom scrollbar for a clean look */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 h-screen overflow-hidden flex">

    @include('admin.layouts.partials.sidebar')

    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        
        @include('admin.layouts.partials.topbar')

        <main class="flex-1 overflow-y-auto p-6 bg-[#F8F9FA]">
            @yield('content')
            
            @include('admin.layouts.partials.footer')
        </main>

    </div>

   @stack('scripts')

    <script>
        const sidebar = document.getElementById('sidebar');
        const openBtn = document.getElementById('openSidebar');
        const closeBtn = document.getElementById('closeSidebar');
        const overlay = document.getElementById('sidebarOverlay');

        // Function to toggle sidebar classes
        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // Add event listeners
        if(openBtn) openBtn.addEventListener('click', toggleSidebar);
        if(closeBtn) closeBtn.addEventListener('click', toggleSidebar);
        if(overlay) overlay.addEventListener('click', toggleSidebar);
    </script>
    <script>
    // Toastr Configuration
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "5000"
    };

    // 1. Success Message [cite: 5, 7]
    @if(session('success'))
        toastr.success("{{ session('success') }}"); [cite: 7]
    @endif

    // 2. Error Message [cite: 10, 12]
    @if(session('error'))
        toastr.error("{{ session('error') }}"); [cite: 12]
    @endif

    // 3. Validation Errors [cite: 15, 21]
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}"); [cite: 21]
        @endforeach
    @endif
</script>
</body>
</html>