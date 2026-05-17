@extends('seller.layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-4 sm:p-6">
    
    <!-- Header with Add Button -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Channels</h2>
            <p class="text-sm text-gray-500 mt-1">Manage your sales channels and integrations</p>
        </div>
              <a href="/seller/channel/addchannel" 
   class="inline-flex items-center px-4 py-2 bg-[#D4AF37] text-white border border-[#D4AF37] rounded hover:bg-[#b8932c] hover:border-[#b8932c] transition">
    <i class="fa-solid fa-plus mr-2"></i> Add Channel
</a>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        
        <!-- Search Bar -->
        <div class="p-4 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <input type="text" placeholder="Search channels..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none">
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-xs uppercase text-gray-600 font-semibold">
                    <tr>
                        <th class="px-4 py-3">Store Name</th>
                        <th class="px-4 py-3">Store Url</th>
                        <th class="px-4 py-3">Pickup Address</th>
                        <th class="px-4 py-3">User Name</th>
                        <th class="px-4 py-3">Channel Name</th>
                        <th class="px-4 py-3">Tags</th>
                        <th class="px-4 py-3">Is Active</th>
                        <th class="px-4 py-3">Pull Date</th>
                        <th class="px-4 py-3">Connect/Disconnect</th>
                        <th class="px-4 py-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <!-- Row 1 -->
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 font-medium text-gray-900">My Shopify Store</td>
                        <td class="px-4 py-3">
                            <a href="#" class="text-blue-600 hover:underline text-xs">mystore.myshopify.com</a>
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-600">Mumbai, Maharashtra</td>
                        <td class="px-4 py-3">John Doe</td>
                        <td class="px-4 py-3 font-medium">
                            Main Store
                            <div class="text-xs text-gray-500">Shopify</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-wrap gap-1">
                                <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-[10px] rounded-full">VIP</span>
                                <span class="px-2 py-0.5 bg-green-100 text-green-700 text-[10px] rounded-full">Priority</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700">
                                Active
                            </span>
                        </td>
                        <td class="px-4 py-3 text-xs">15 Jan 2025</td>
                        <td class="px-4 py-3">
                            <button class="px-3 py-1 text-xs font-medium rounded bg-red-100 text-red-700 hover:bg-red-200 transition">
                                Disconnect
                            </button>
                        </td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="#" class="text-blue-600 hover:text-blue-800 text-xs" title="Edit">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <a href="#" class="text-red-600 hover:text-red-800 text-xs" title="Delete">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 font-medium text-gray-900">WooCommerce Shop</td>
                        <td class="px-4 py-3">
                            <a href="#" class="text-blue-600 hover:underline text-xs">myshop.com</a>
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-600">Delhi</td>
                        <td class="px-4 py-3">Jane Smith</td>
                        <td class="px-4 py-3 font-medium">
                            Online Store
                            <div class="text-xs text-gray-500">WooCommerce</div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-gray-400 text-xs">-</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-gray-100 text-gray-600">
                                Inactive
                            </span>
                        </td>
                        <td class="px-4 py-3 text-xs">-</td>
                        <td class="px-4 py-3">
                            <button class="px-3 py-1 text-xs font-medium rounded bg-green-100 text-green-700 hover:bg-green-200 transition">
                                Connect
                            </button>
                        </td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="#" class="text-blue-600 hover:text-blue-800 text-xs" title="Edit">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <a href="#" class="text-red-600 hover:text-red-800 text-xs" title="Delete">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>

                    <!-- Row 3 -->
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 font-medium text-gray-900">Amazon Seller</td>
                        <td class="px-4 py-3">
                            <a href="#" class="text-blue-600 hover:underline text-xs">amazon.in</a>
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-600">Bangalore, Karnataka</td>
                        <td class="px-4 py-3">Mike Johnson</td>
                        <td class="px-4 py-3 font-medium">
                            Amazon IN
                            <div class="text-xs text-gray-500">Amazon</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-wrap gap-1">
                                <span class="px-2 py-0.5 bg-purple-100 text-purple-700 text-[10px] rounded-full">FBA</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700">
                                Active
                            </span>
                        </td>
                        <td class="px-4 py-3 text-xs">20 Jan 2025</td>
                        <td class="px-4 py-3">
                            <button class="px-3 py-1 text-xs font-medium rounded bg-red-100 text-red-700 hover:bg-red-200 transition">
                                Disconnect
                            </button>
                        </td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="#" class="text-blue-600 hover:text-blue-800 text-xs" title="Edit">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <a href="#" class="text-red-600 hover:text-red-800 text-xs" title="Delete">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>

                    <!-- Row 4 -->
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 font-medium text-gray-900">Flipkart Store</td>
                        <td class="px-4 py-3">
                            <a href="#" class="text-blue-600 hover:underline text-xs">flipkart.com</a>
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-600">Pune, Maharashtra</td>
                        <td class="px-4 py-3">Sarah Williams</td>
                        <td class="px-4 py-3 font-medium">
                            Flipkart Plus
                            <div class="text-xs text-gray-500">Flipkart</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-wrap gap-1">
                                <span class="px-2 py-0.5 bg-orange-100 text-orange-700 text-[10px] rounded-full">Express</span>
                                <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-[10px] rounded-full">New</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700">
                                Active
                            </span>
                        </td>
                        <td class="px-4 py-3 text-xs">18 Jan 2025</td>
                        <td class="px-4 py-3">
                            <button class="px-3 py-1 text-xs font-medium rounded bg-red-100 text-red-700 hover:bg-red-200 transition">
                                Disconnect
                            </button>
                        </td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="#" class="text-blue-600 hover:text-blue-800 text-xs" title="Edit">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <a href="#" class="text-red-600 hover:text-red-800 text-xs" title="Delete">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-4 py-3 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="text-sm text-gray-600">
                Showing <strong>1</strong> to <strong>4</strong> of <strong>12</strong> entries
            </div>
            
            <div class="flex items-center gap-1">
                <button class="px-3 py-1 text-gray-400 border rounded cursor-not-allowed">Previous</button>
                <button class="px-3 py-1 bg-[#D4AF37] text-white border border-[#D4AF37] rounded">1</button>
                <button class="px-3 py-1 text-blue-600 border rounded hover:bg-blue-50">2</button>
                <button class="px-3 py-1 text-blue-600 border rounded hover:bg-blue-50">3</button>
                <button class="px-3 py-1 text-blue-600 border rounded hover:bg-blue-50">Next</button>
            </div>
        </div>
    </div>
</div>
@endsection