@extends('seller.layouts.app')

@section('content')
<div class="min-h-screen bg-[#F5F1E8] p-4 sm:p-6">
    <div class="max-w-7xl mx-auto space-y-4">

        <!-- ✅ 1. Filter Section (Collapsible) -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="flex justify-end p-3 border-b border-gray-100 bg-[#F5F1E8]/50">
                <button onclick="document.getElementById('filterBody').classList.toggle('hidden')" 
                        class="flex items-center gap-2 px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded transition">
                    <i class="fa-solid fa-filter text-xs"></i> Filter
                </button>
            </div>
            <div id="filterBody" class="hidden p-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Product Name</label>
                    <input type="text" placeholder="Search by product" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#D4AF37]/20 focus:border-[#D4AF37] transition">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">HSN Code</label>
                    <input type="text" placeholder="Search by HSN Code" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#D4AF37]/20 focus:border-[#D4AF37] transition">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">SKU</label>
                    <input type="text" placeholder="Search by SKU" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#D4AF37]/20 focus:border-[#D4AF37] transition">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Product Category</label>
                    <div class="relative">
                        <select class="w-full appearance-none px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#D4AF37]/20 focus:border-[#D4AF37] transition bg-white cursor-pointer">
                            <option value="">Select by product category</option>
                            <option>Adivasi Oil (HSN: ) (GST%: 5)</option>
                            <option>Apparel (HSN: ) (GST%: 5)</option>
                            <option>Artificial jewellery (HSN: ) (GST%: 3)</option>
                            <option>Ayurveda (HSN: ) (GST%: 18)</option>
                            <option>Beauty (HSN: ) (GST%: 5)</option>
                            <option>GSTExempted (HSN: ) (GST%: 0)</option>
                        </select>
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[#D4AF37] pointer-events-none"><i class="fa-solid fa-chevron-down text-xs"></i></span>
                    </div>
                </div>
                <div class="lg:col-span-4 flex justify-end gap-2 pt-2 border-t border-gray-100">
                    <button class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-md transition">Clear</button>
                    <button class="px-4 py-2 bg-[#2D1B69] hover:bg-[#1A0F45] text-white text-sm font-medium rounded-md transition">Apply</button>
                </div>
            </div>
        </div>

        <!-- ✅ 2. Main Card: Tabs + Tables -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <!-- Total Count (Top) -->
            <div class="px-4 pt-4 pb-2">
                <span class="text-xs font-medium text-gray-600 bg-gray-100 px-3 py-1.5 rounded border border-gray-200">
                    Total : <span id="totalCount">0</span>
                </span>
            </div>

            <!-- Tabs (Below Total) -->
            <div class="px-4 pb-3 border-b border-gray-200">
                <div class="flex gap-6">
                    <button id="tab-mapped" class="pb-2 text-sm font-medium text-[#D4AF37] border-b-2 border-[#D4AF37] transition" onclick="switchTab('mapped')">
                        Mapped Product
                    </button>
                    <button id="tab-unmapped" class="pb-2 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-[#B8941F] transition" onclick="switchTab('unmapped')">
                        Unmapped Product
                    </button>
                </div>
            </div>

            <!-- Tables (No Scrollbar) -->
            <div class="p-4">
                <!-- MAPPED PRODUCT TABLE -->
                <div id="mapped-content">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead class="bg-[#F5F1E8] text-gray-600 uppercase text-xs font-semibold">
                            <tr class="border-b-2 border-[#D4AF37]/30">
                                <th class="px-4 py-3 w-10 border-b border-r border-gray-200"><input type="checkbox" class="rounded border-gray-300 focus:ring-[#D4AF37]"></th>
                                <th class="px-4 py-3 border-b border-r border-gray-200 cursor-pointer hover:text-gray-800">SKU <i class="fa-solid fa-sort text-gray-400 text-[10px] ml-1"></i></th>
                                <th class="px-4 py-3 border-b border-r border-gray-200 cursor-pointer hover:text-gray-800">Company Name <i class="fa-solid fa-sort text-gray-400 text-[10px] ml-1"></i></th>
                                <th class="px-4 py-3 border-b border-r border-gray-200 cursor-pointer hover:text-gray-800">Category <i class="fa-solid fa-sort text-gray-400 text-[10px] ml-1"></i></th>
                                <th class="px-4 py-3 border-b border-r border-gray-200 cursor-pointer hover:text-gray-800">Total Count <i class="fa-solid fa-sort text-gray-400 text-[10px] ml-1"></i></th>
                                <th class="px-4 py-3 border-b border-r border-gray-200">HSN Code</th>
                                <th class="px-4 py-3 border-b border-r border-gray-200">TAX Rate</th>
                                <th class="px-4 py-3 border-b border-gray-200 cursor-pointer hover:text-gray-800">Action <i class="fa-solid fa-sort text-gray-400 text-[10px] ml-1"></i></th>
                            </tr>
                        </thead>
                        <tbody id="mapped-table-body" class="divide-y divide-gray-200"></tbody>
                    </table>
                </div>

                <!-- UNMAPPED PRODUCT TABLE -->
                <div id="unmapped-content" class="hidden">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead class="bg-[#F5F1E8] text-gray-600 uppercase text-xs font-semibold">
                            <tr class="border-b-2 border-[#D4AF37]/30">
                                <th class="px-4 py-3 w-10 border-b border-r border-gray-200"><input type="checkbox" class="rounded border-gray-300 focus:ring-[#D4AF37]"></th>
                                <th class="px-4 py-3 border-b border-r border-gray-200 cursor-pointer hover:text-gray-800">Company Name <i class="fa-solid fa-sort text-gray-400 text-[10px] ml-1"></i></th>
                                <th class="px-4 py-3 border-b border-r border-gray-200 cursor-pointer hover:text-gray-800">Product Name <i class="fa-solid fa-sort text-gray-400 text-[10px] ml-1"></i></th>
                                <th class="px-4 py-3 border-b border-r border-gray-200 cursor-pointer hover:text-gray-800">Category <i class="fa-solid fa-sort text-gray-400 text-[10px] ml-1"></i></th>
                                <th class="px-4 py-3 border-b border-r border-gray-200 cursor-pointer hover:text-gray-800">SKU <i class="fa-solid fa-sort text-gray-400 text-[10px] ml-1"></i></th>
                                <th class="px-4 py-3 border-b border-r border-gray-200">HSN Code</th>
                                <th class="px-4 py-3 border-b border-r border-gray-200">Dimension & Weight</th>
                                <th class="px-4 py-3 border-b border-gray-200 cursor-pointer hover:text-gray-800">Action <i class="fa-solid fa-sort text-gray-400 text-[10px] ml-1"></i></th>
                            </tr>
                        </thead>
                        <tbody id="unmapped-table-body" class="divide-y divide-gray-200"></tbody>
                    </table>
                </div>
            </div>

            <!-- Footer / Pagination Bar -->
            <div class="px-4 py-3 border-t border-gray-200 flex items-center justify-between bg-[#F5F1E8]/30">
                <div class="flex items-center gap-3">
                    <select class="bg-[#6B7280] text-white text-sm rounded-md px-3 py-1.5 focus:outline-none cursor-pointer">
                        <option>50</option>
                        <option>100</option>
                        <option>200</option>
                    </select>
                    <span class="text-sm text-gray-600">Showing : <span id="showingText">0 to 0 of 0</span></span>
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<style>
    table td, table th { 
        border-right: 1px solid #e5e7eb; 
    }
    table td:last-child, table th:last-child { 
        border-right: none; 
    }
    .row-selected { 
        background-color: #F5F1E8 !important; 
    }
</style>

<script>
    // ✅ Dummy Data: Mapped
    const mappedData = [
        { sku: 'SKU-8842', company: 'TechCorp India', category: 'Electronics', count: 15, hsn: '8517', tax: '18%' },
        { sku: 'SKU-9910', company: 'FashionHub', category: 'Apparel', count: 42, hsn: '6109', tax: '12%' },
        { sku: 'SKU-2231', company: 'GreenFoods', category: 'Grocery', count: 8, hsn: '0901', tax: '5%' },
        { sku: 'SKU-4455', company: 'HomeDecor Co.', category: 'Furniture', count: 23, hsn: '9403', tax: '18%' },
    ];

    // ✅ Dummy Data: Unmapped
    const unmappedData = [
        { company: 'Pooja Verma', product: 'bdge', category: '', sku: '', hsn: '5202', dim: '' },
        { company: 'Pooja Verma', product: 'bffffsbv', category: '', sku: '', hsn: '5202', dim: '' },
        { company: 'Pooja Verma', product: 'bznsj', category: '', sku: '', hsn: '5202', dim: '' },
        { company: 'Pooja Verma', product: 'djosnn', category: '', sku: '', hsn: '5202', dim: '' },
        { company: 'Pooja Verma', product: 'hair growth oil and capsule', category: '', sku: '', hsn: '5202', dim: '' },
        { company: 'Pooja Verma', product: 'medicine', category: '', sku: '', hsn: '5202', dim: '' },
        { company: 'Pooja Verma', product: 'oil and capsule', category: '', sku: '', hsn: '5202', dim: '' },
        { company: 'Pooja Verma', product: 'oil capsule', category: '', sku: '', hsn: '5202', dim: '' }
    ];

    // ✅ Render Tables
    function renderTable(type) {
        const tbody = document.getElementById(`${type}-table-body`);
        const data = type === 'mapped' ? mappedData : unmappedData;
        const total = data.length;
        
        document.getElementByshivamId('totalCount').textContent = total;
        document.getElementById('showingText').textContent = total > 0 ? `0 to ${total} of ${total}` : '0 to 0 of 0';

        if (total === 0) {
            tbody.innerHTML = `<tr><td colspan="8" class="px-4 py-12 text-center text-gray-400"><i class="fa-solid fa-inbox text-2xl mb-2 block"></i>No records found</td></tr>`;
            return;
        }

        tbody.innerHTML = data.map((item, idx) => {
            if (type === 'mapped') {
                return `<tr class="hover:bg-[#F5F1E8] transition">
                    <td class="px-4 py-3 border-b border-gray-200"><input type="checkbox" class="rounded border-gray-300 focus:ring-[#D4AF37]"></td>
                    <td class="px-4 py-3 text-gray-700 border-b border-gray-200 font-mono text-xs">${item.sku}</td>
                    <td class="px-4 py-3 text-gray-700 border-b border-gray-200">${item.company}</td>
                    <td class="px-4 py-3 text-gray-500 border-b border-gray-200">${item.category}</td>
                    <td class="px-4 py-3 text-gray-700 border-b border-gray-200 text-center font-semibold">${item.count}</td>
                    <td class="px-4 py-3 text-gray-700 border-b border-gray-200">${item.hsn}</td>
                    <td class="px-4 py-3 text-gray-700 border-b border-gray-200">${item.tax}</td>
                    <td class="px-4 py-3 border-b border-gray-200">
                        <button class="px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded hover:bg-[#F5F1E8] hover:border-[#D4AF37] transition flex items-center gap-1.5">
                            <i class="fa-solid fa-link text-[#D4AF37]"></i> Map Product
                        </button>
                    </td>
                </tr>`;
            } else {
                return `<tr class="hover:bg-[#F5F1E8] transition ${idx === 3 ? 'row-selected' : ''}">
                    <td class="px-4 py-3 border-b border-gray-200"><input type="checkbox" class="rounded border-gray-300 focus:ring-[#D4AF37]"></td>
                    <td class="px-4 py-3 text-gray-700 border-b border-gray-200">${item.company}</td>
                    <td class="px-4 py-3 text-gray-700 border-b border-gray-200">${item.product}</td>
                    <td class="px-4 py-3 text-gray-500 border-b border-gray-200">${item.category || '-'}</td>
                    <td class="px-4 py-3 text-gray-500 border-b border-gray-200">${item.sku || '-'}</td>
                    <td class="px-4 py-3 text-gray-700 border-b border-gray-200">${item.hsn}</td>
                    <td class="px-4 py-3 text-gray-500 border-b border-gray-200">${item.dim || '-'}</td>
                    <td class="px-4 py-3 border-b border-gray-200">
                        <button class="px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded hover:bg-[#F5F1E8] hover:border-[#D4AF37] transition flex items-center gap-1.5">
                            <i class="fa-solid fa-pen-to-square text-[#D4AF37]"></i> Edit Product
                        </button>
                    </td>
                </tr>`;
            }
        }).join('');
    }

    // ✅ Tab Switching Logic
    function switchTab(tab) {
        const mappedBtn = document.getElementById('tab-mapped');
        const unmappedBtn = document.getElementById('tab-unmapped');
        const mappedContent = document.getElementById('mapped-content');
        const unmappedContent = document.getElementById('unmapped-content');

        if (tab === 'mapped') {
            mappedBtn.classList.add('text-[#D4AF37]', 'border-[#D4AF37]');
            mappedBtn.classList.remove('text-gray-500', 'border-transparent');
            unmappedBtn.classList.remove('text-[#D4AF37]', 'border-[#D4AF37]');
            unmappedBtn.classList.add('text-gray-500', 'border-transparent');
            
            mappedContent.classList.remove('hidden');
            unmappedContent.classList.add('hidden');
        } else {
            unmappedBtn.classList.add('text-[#D4AF37]', 'border-[#D4AF37]');
            unmappedBtn.classList.remove('text-gray-500', 'border-transparent');
            mappedBtn.classList.remove('text-[#D4AF37]', 'border-[#D4AF37]');
            mappedBtn.classList.add('text-gray-500', 'border-transparent');
            
            unmappedContent.classList.remove('hidden');
            mappedContent.classList.add('hidden');
        }
        renderTable(tab);
    }

    // ✅ Initialize
    document.addEventListener('DOMContentLoaded', () => {
        switchTab('mapped');
    });
</script>
@endpush
@endsection