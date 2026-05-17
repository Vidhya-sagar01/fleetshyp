@extends('seller.layouts.app')

@section('content')
<div class="min-h-screen bg-[#F5F1E8] p-4 sm:p-6">
    <div class="max-w-4xl mx-auto">
        
        <!-- Header with Back Button (Gold Theme) -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Create Ticket</h2>
                <p class="text-sm text-gray-500 mt-1">Fill in the details below to raise a new ticket</p>
            </div>
            <a href="{{ route('seller.ticket.index') }}" 
               class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-[#F5F1E8] hover:text-[#D4AF37] hover:border-[#D4AF37] transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Back to Tickets
            </a>
        </div>

        <!-- Form Card (Gold Theme) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:border-[#D4AF37]/50 transition">
            <form action="{{ route('seller.ticket.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Row 1: Category & Sub Category (Dependent Dropdowns) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    
                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select id="category" name="category" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none bg-white appearance-none pr-10 hover:border-[#D4AF37] transition cursor-pointer">
                                <option value="">Select Category</option>
                                <option value="First Mile">First Mile</option>
                                <option value="Last Mile">Last Mile</option>
                                <option value="Post Delivery Dispute">Post Delivery Dispute</option>
                                <option value="Weight">Weight</option>
                                <option value="Finance">Finance</option>
                                <option value="Technical">Technical</option>
                                <option value="Account Query">Account Query</option>
                                <option value="B2B Related Issues">B2B Related Issues</option>
                            </select>
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[#D4AF37] pointer-events-none">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Sub Category (Dynamic - Exact Options as per your requirement) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Sub Category <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select id="subCategory" name="sub_category" required disabled
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none bg-[#F5F1E8] appearance-none pr-10 disabled:text-gray-400 disabled:cursor-not-allowed hover:border-[#D4AF37] transition">
                                <option value="">Select Sub-Category</option>
                            </select>
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[#D4AF37] pointer-events-none">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Reference ID -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Reference ID <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[#D4AF37]">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input type="text" name="reference_id" required
                               placeholder="Enter AWB/Order IDs Separated by Comma"
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none bg-[#F5F1E8]/50 hover:border-[#D4AF37] transition">
                    </div>
                </div>

                <!-- Remark -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Remark</label>
                    <textarea name="remark" rows="3" placeholder="Enter Remark"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none resize-none bg-[#F5F1E8]/50 hover:border-[#D4AF37] transition"></textarea>
                </div>

                <!-- Attachment (Gold Theme) -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Attachment</label>
                    <div class="border-2 border-dashed border-[#D4AF37]/40 rounded-lg p-8 text-center hover:border-[#D4AF37] hover:bg-[#F5F1E8] transition cursor-pointer"
                         onclick="document.getElementById('fileInput').click()">
                        <input type="file" id="fileInput" name="attachments[]" class="hidden" multiple onchange="handleFileSelect(this)">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fa-solid fa-cloud-arrow-up text-4xl text-[#D4AF37] mb-3"></i>
                            <p class="text-sm font-medium text-gray-700">Browse or Drag your files here</p>
                            <p class="text-xs text-gray-400 mt-1">Supporting formats .png .jpeg .pdf .mp3 .mp4 .csv .xls .xlsx</p>
                        </div>
                        <div id="fileList" class="mt-4 text-sm text-gray-600"></div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('seller.ticket.index') }}"
                       class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-[#F5F1E8] hover:text-[#D4AF37] hover:border-[#D4AF37] transition">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-8 py-2.5 bg-gradient-gold text-white rounded-lg text-sm font-medium hover:bg-gold-dark transition shadow-sm">
                        Submit Ticket
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

<!-- ✅ CSS + JavaScript - COMPLETE -->
@push('scripts')
<style>
/* Custom Dropdown Styling - Prevents positioning issues */
select {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-image: none !important;
}
.bg-gradient-gold {
    background: linear-gradient(135deg, #D4AF37 0%, #B8941F 100%);
}
.bg-gradient-gold:hover {
    background: linear-gradient(135deg, #B8941F 0%, #9A7A1A 100%);
}
.transition-all-300 {
    transition: all 0.3s ease;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // ✅ EXACT Sub-Category Mapping (Aapke requirements ke hisaab se)
    const subCategoriesMap = {
        'First Mile': [
            'Pickup Not Done',
            'Picked up but not connected'
        ],
        'Last Mile': [
            'Branch Address Info',
            'RTO Request',
            'Expedite Delivery',
            'NDR Reattempt',
            'Update Buyer details',
            'Status Mismatch',
            'RTO Without Attempt'
        ],
        'Post Delivery Dispute': [
            'Delivered not received RTO',
            'Short/Empty Shipment Received RTO',
            'Delivery not received by Buyer',
            'Damage Shipment Received by Buyer',
            'Wrong Delivery Received by Buyer',
            'Wrong Delivery Received RTO',
            'Short/Empty Shipment Received by Buyer',
            'Damage Shipment Received RTO',
            'Return from buyer'
        ]
        // Other categories ke liye empty array (no sub-categories will show)
    };

    const categorySelect = document.getElementById('category');
    const subCategorySelect = document.getElementById('subCategory');

    // Category change hone par Sub-Category update karein
    categorySelect.addEventListener('change', function() {
        const selected = this.value;
        
        // 1. Purane options clear karein
        subCategorySelect.innerHTML = '<option value="">Select Sub-Category</option>';
        
        // 2. Agar category map mein exist karti hai → options add karein
        if (selected && subCategoriesMap[selected]) {
            subCategoriesMap[selected].forEach(sub => {
                const option = document.createElement('option');
                option.value = sub;
                option.textContent = sub;
                subCategorySelect.appendChild(option);
            });
            // Enable dropdown with gold theme
            subCategorySelect.disabled = false;
            subCategorySelect.classList.remove('bg-[#F5F1E8]', 'text-gray-400', 'cursor-not-allowed');
            subCategorySelect.classList.add('bg-white', 'text-gray-700', 'cursor-pointer');
        } else {
            // Disable agar koi mapping nahi hai
            subCategorySelect.disabled = true;
            subCategorySelect.classList.add('bg-[#F5F1E8]', 'text-gray-400', 'cursor-not-allowed');
            subCategorySelect.classList.remove('bg-white', 'text-gray-700', 'cursor-pointer');
        }
    });
});

// ✅ File Upload Handler (Gold Theme)
function handleFileSelect(input) {
    const fileList = document.getElementById('fileList');
    if (input.files.length > 0) {
        let html = '<div class="space-y-2">';
        Array.from(input.files).forEach((file, index) => {
            const size = (file.size / 1024).toFixed(1);
            html += `
                <div class="flex items-center justify-between bg-[#F5F1E8] px-3 py-2 rounded-md border border-[#D4AF37]/20">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-file text-[#D4AF37]"></i>
                        <span class="text-sm text-gray-700 truncate max-w-[200px]">${file.name}</span>
                        <span class="text-xs text-gray-400">(${size} KB)</span>
                    </div>
                    <button type="button" onclick="removeFile(${index})" class="text-red-500 hover:text-red-700 transition">
                        <i class="fa-solid fa-trash text-xs"></i>
                    </button>
                </div>
            `;
        });
        html += '</div>';
        fileList.innerHTML = html;
    }
}

// Remove File from List
function removeFile(index) {
    const fileInput = document.getElementById('fileInput');
    const files = Array.from(fileInput.files);
    files.splice(index, 1);
    
    const dataTransfer = new DataTransfer();
    files.forEach(file => dataTransfer.items.add(file));
    fileInput.files = dataTransfer.files;
    
    handleFileSelect(fileInput);
}

// Drag & Drop Support (Optional)
const dropZone = document.querySelector('.border-dashed');
if (dropZone) {
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-[#D4AF37]', 'bg-[#F5F1E8]');
    });
    
    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('border-[#D4AF37]', 'bg-[#F5F1E8]');
    });
    
    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-[#D4AF37]', 'bg-[#F5F1E8]');
        const files = e.dataTransfer.files;
        document.getElementById('fileInput').files = files;
        handleFileSelect(document.getElementById('fileInput'));
    });
}
</script>
@endpush
@endsection