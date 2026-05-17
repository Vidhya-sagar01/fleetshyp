@extends('seller.layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-4 sm:p-6">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Add New Channel</h2>
            <p class="text-sm text-gray-500 mt-1">Select your sales platform to connect and start syncing orders.</p>
        </div>

        <!-- Platform Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            
            <!-- Shopify Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex flex-col items-center justify-center p-8 hover:shadow-lg transition-all duration-300 min-h-[280px]">
                <div class="w-40 h-40 mb-6 flex items-center justify-center">
                    <img src="{{ asset('assets/img/channel/shopify.png') }}" alt="Shopify" class="max-w-full max-h-full object-contain">
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-6 uppercase tracking-wide">Shopify</h3>
                <a href="#" class="inline-flex items-center px-8 py-2 bg-[#2d1b6f] text-white text-sm font-medium rounded-md hover:bg-[#1e124a] transition shadow-lg">
                    <i class="fa-solid fa-plus mr-2"></i> Add
                </a>
            </div>

            <!-- WooCommerce Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex flex-col items-center justify-center p-8 hover:shadow-lg transition-all duration-300 min-h-[280px]">
                <div class="w-40 h-40 mb-6 flex items-center justify-center">
                    <img src="{{ asset('assets/img/channel/woocommerce.png') }}" alt="WooCommerce" class="max-w-full max-h-full object-contain">
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-6 uppercase tracking-wide">WooCommerce</h3>
                <a href="#" class="inline-flex items-center px-8 py-2 bg-[#2d1b6f] text-white text-sm font-medium rounded-md hover:bg-[#1e124a] transition shadow-lg">
                    <i class="fa-solid fa-plus mr-2"></i> Add
                </a>
            </div>

            <!-- Unicommerce Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex flex-col items-center justify-center p-8 hover:shadow-lg transition-all duration-300 min-h-[280px]">
                <div class="w-40 h-40 mb-6 flex items-center justify-center">
                    <img src="{{ asset('assets/img/channel/unicommerce.png') }}" alt="Unicommerce" class="max-w-full max-h-full object-contain">
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-6 uppercase tracking-wide">Unicommerce</h3>
                <a href="#" class="inline-flex items-center px-8 py-2 bg-[#2d1b6f] text-white text-sm font-medium rounded-md hover:bg-[#1e124a] transition shadow-lg">
                    <i class="fa-solid fa-plus mr-2"></i> Add
                </a>
            </div>

            <!-- Easyecom Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex flex-col items-center justify-center p-8 hover:shadow-lg transition-all duration-300 min-h-[280px]">
                <div class="w-40 h-40 mb-6 flex items-center justify-center">
                    <img src="{{ asset('assets/img/channel/easyeom.png') }}" alt="Easyecom" class="max-w-full max-h-full object-contain">
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-6 uppercase tracking-wide">Easyecom</h3>
                <a href="#" class="inline-flex items-center px-8 py-2 bg-[#2d1b6f] text-white text-sm font-medium rounded-md hover:bg-[#1e124a] transition shadow-lg">
                    <i class="fa-solid fa-plus mr-2"></i> Add
                </a>
            </div>

            <!-- Ecwid Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex flex-col items-center justify-center p-8 hover:shadow-lg transition-all duration-300 min-h-[280px]">
                <div class="w-40 h-40 mb-6 flex items-center justify-center">
                    <img src="{{ asset('assets/img/channel/ecwid.png') }}" alt="Ecwid" class="max-w-full max-h-full object-contain">
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-6 uppercase tracking-wide">Ecwid</h3>
                <a href="#" class="inline-flex items-center px-8 py-2 bg-[#2d1b6f] text-white text-sm font-medium rounded-md hover:bg-[#1e124a] transition shadow-lg">
                    <i class="fa-solid fa-plus mr-2"></i> Add
                </a>
            </div>

            <!-- Amazon Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex flex-col items-center justify-center p-8 hover:shadow-lg transition-all duration-300 min-h-[280px]">
                <div class="w-40 h-40 mb-6 flex items-center justify-center">
                    <img src="{{ asset('assets/img/channel/amazon.png') }}" alt="Amazon" class="max-w-full max-h-full object-contain">
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-6 uppercase tracking-wide">Amazon</h3>
                <a href="#" class="inline-flex items-center px-8 py-2 bg-[#2d1b6f] text-white text-sm font-medium rounded-md hover:bg-[#1e124a] transition shadow-lg">
                    <i class="fa-solid fa-plus mr-2"></i> Add
                </a>
            </div>

        </div>

        <!-- Back Button -->
        <div class="mt-8">
            <a href="/seller/channel/showchannel" 
               class="inline-flex items-center px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition shadow-sm">
                <i class="fa-solid fa-arrow-left mr-2"></i> Back to Channels
            </a>
        </div>
    </div>
</div>

<style>
    /* Card hover animation */
    .hover\\:shadow-lg:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
</style>
@endsection