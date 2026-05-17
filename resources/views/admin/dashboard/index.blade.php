@extends('admin.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    
    <div class="flex justify-between items-end mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Dashboard Overview</h2>
            <p class="text-sm text-slate-500 mt-1">Welcome back, Rahul 👋 — Here's what's happening today</p>
        </div>
        <div class="flex space-x-3">
            <button class="bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 flex items-center shadow-sm">
                <i class="fa-regular fa-calendar mr-2"></i> Today
            </button>
            <button class="bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 flex items-center shadow-sm">
                <i class="fa-solid fa-download mr-2"></i> Export
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 relative overflow-hidden">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Today's Orders</p>
            <h3 class="text-3xl font-bold text-slate-800 mb-4">1,284</h3>
            <div class="flex items-center text-xs">
                <span class="bg-green-100 text-green-700 font-bold px-2 py-1 rounded flex items-center">
                    <i class="fa-solid fa-arrow-trend-up mr-1 text-[10px]"></i> 12%
                </span>
                <span class="text-gray-400 ml-2">vs yesterday</span>
            </div>
            <div class="absolute top-5 right-5 w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-500">
                <i class="fa-solid fa-bag-shopping"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 relative overflow-hidden">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Today's Revenue</p>
            <h3 class="text-3xl font-bold text-slate-800 mb-4">₹4.28L</h3>
            <div class="flex items-center text-xs">
                <span class="bg-green-100 text-green-700 font-bold px-2 py-1 rounded flex items-center">
                    <i class="fa-solid fa-arrow-trend-up mr-1 text-[10px]"></i> 8.4%
                </span>
                <span class="text-gray-400 ml-2">vs yesterday</span>
            </div>
            <div class="absolute top-5 right-5 w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center text-green-500 font-bold text-lg">
                $
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 relative overflow-hidden">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Avg. Order Value</p>
            <h3 class="text-3xl font-bold text-slate-800 mb-4">₹333</h3>
            <div class="flex items-center text-xs">
                <span class="bg-red-100 text-red-600 font-bold px-2 py-1 rounded flex items-center">
                    <i class="fa-solid fa-arrow-trend-down mr-1 text-[10px]"></i> 2.1%
                </span>
                <span class="text-gray-400 ml-2">vs yesterday</span>
            </div>
            <div class="absolute top-5 right-5 w-10 h-10 bg-orange-50 rounded-lg flex items-center justify-center text-orange-500">
                <i class="fa-solid fa-chart-line"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 relative overflow-hidden">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Active Shipments</p>
            <h3 class="text-3xl font-bold text-slate-800 mb-4">8,921</h3>
            <div class="flex items-center text-xs">
                <span class="bg-green-100 text-green-700 font-bold px-2 py-1 rounded flex items-center">
                    <i class="fa-solid fa-arrow-trend-up mr-1 text-[10px]"></i> 5.6%
                </span>
                <span class="text-gray-400 ml-2">vs yesterday</span>
            </div>
            <div class="absolute top-5 right-5 w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center text-purple-500">
                <i class="fa-solid fa-truck-fast"></i>
            </div>
        </div>

    </div>

    <div class="mb-6 flex justify-between items-end">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Shipment Status Overview</h3>
            <p class="text-xs text-slate-500 mt-1">Real-time tracking across all couriers</p>
        </div>
        <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">View all <i class="fa-solid fa-chevron-right text-[10px] ml-1"></i></a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center mb-3">
                <div class="w-6 h-6 rounded bg-orange-100 text-orange-600 flex items-center justify-center text-xs mr-2"><i class="fa-solid fa-box"></i></div>
                <span class="text-xs font-bold text-gray-500">Pickups</span>
            </div>
            <h4 class="text-2xl font-bold text-slate-800">891</h4>
        </div>
        
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center mb-3">
                <div class="w-6 h-6 rounded bg-blue-100 text-blue-600 flex items-center justify-center text-xs mr-2"><i class="fa-solid fa-truck"></i></div>
                <span class="text-xs font-bold text-gray-500">In Transit</span>
            </div>
            <h4 class="text-2xl font-bold text-slate-800">2,341</h4>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center mb-3">
                <div class="w-6 h-6 rounded bg-green-100 text-green-600 flex items-center justify-center text-xs mr-2"><i class="fa-regular fa-circle-check"></i></div>
                <span class="text-xs font-bold text-gray-500">Delivered</span>
            </div>
            <h4 class="text-2xl font-bold text-slate-800">5,842</h4>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center mb-3">
                <div class="w-6 h-6 rounded bg-red-100 text-red-600 flex items-center justify-center text-xs mr-2"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <span class="text-xs font-bold text-gray-500">NDR Pending</span>
            </div>
            <h4 class="text-2xl font-bold text-slate-800">412</h4>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center mb-3">
                <div class="w-6 h-6 rounded bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs mr-2"><i class="fa-solid fa-arrow-rotate-left"></i></div>
                <span class="text-xs font-bold text-gray-500">RTO</span>
            </div>
            <h4 class="text-2xl font-bold text-slate-800">284</h4>
        </div>
    </div>

</div>
@endsection