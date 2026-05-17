@extends('seller.layouts.app') 

@section('content')
<div class="container mx-auto">
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6 border border-gray-200">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Set shipping label business name</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Display Name<span class="text-red-500">*</span></label>
                <input type="text" id="display_name" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-gold focus:border-gold" value="{{ auth()->user()->name }}">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Printer</label>
                <select id="printer" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-gold focus:border-gold">
                    <option>A4 Size</option>
                    <option>Thermal 4x6</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Template</label>
                <select id="template" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-gold focus:border-gold">
                    <option>Thermal 4x4</option>
                    <option>Standard A4</option>
                </select>
            </div>
        </div>
        <div class="mt-4 flex items-center justify-between">
            <div class="flex items-center">
                <input type="checkbox" id="signature" class="h-4 w-4 text-gold border-gray-300 rounded">
                <label for="signature" class="ml-2 text-sm text-gray-600">Do you want to display signature on label/invoice?</label>
            </div>
            <div class="flex space-x-3">
                <button class="px-6 py-2 bg-gray-800 text-white rounded-md hover:bg-black transition flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </button>
                <button id="updateBtn" class="px-6 py-2 bg-indigo-900 text-white rounded-md hover:bg-indigo-950 transition">
                    Update
                </button>
            </div>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Settings Panel -->
        <div class="w-full lg:w-1/3 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="font-bold text-gray-800 border-b pb-2 mb-4">Current Template</h3>
            
            @php
                // Database se saved settings fetch karein
                $savedSettings = auth()->user()->seller->template_settings ?? [];
                
                $settings = [
                    'consignee' => ['label' => 'Show Consignee Number', 'checked' => $savedSettings['consignee'] ?? true, 'target' => 'consignee-section'],
                    'products' => ['label' => 'Show Products List', 'checked' => $savedSettings['products'] ?? true, 'target' => 'products-table'],
                    'return_address' => ['label' => 'Show Return Address', 'checked' => $savedSettings['return_address'] ?? false, 'target' => 'return-address'],
                    'warehouse_contact' => ['label' => 'Show Warehouse Contact Name', 'checked' => $savedSettings['warehouse_contact'] ?? false, 'target' => 'warehouse-contact'],
                    'seller_contact' => ['label' => 'Show Seller Contact Number', 'checked' => $savedSettings['seller_contact'] ?? false, 'target' => 'seller-contact'],
                    'gst' => ['label' => 'Show GST', 'checked' => $savedSettings['gst'] ?? false, 'target' => 'gst-section'],
                    'gst_breakup' => ['label' => 'Show GST Breakup', 'checked' => $savedSettings['gst_breakup'] ?? false, 'target' => 'gst-breakup'],
                    'order_id' => ['label' => 'Show Order Id', 'checked' => $savedSettings['order_id'] ?? true, 'target' => 'order-id-section'],
                    'sku' => ['label' => 'Show SKU', 'checked' => $savedSettings['sku'] ?? true, 'target' => 'sku-column'],
                    'amount' => ['label' => 'Show Amount', 'checked' => $savedSettings['amount'] ?? true, 'target' => 'amount-column'],
                    'product_name' => ['label' => 'Show Product Name', 'checked' => $savedSettings['product_name'] ?? true, 'target' => 'product-name-column'],
                ];
            @endphp

            <div class="space-y-4">
                @foreach($settings as $key => $setting)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-700">{{ $setting['label'] }}</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input 
                            type="checkbox" 
                            class="sr-only peer toggle-switch" 
                            data-target="{{ $setting['target'] }}"
                            {{ $setting['checked'] ? 'checked' : '' }}
                            id="toggle_{{ $key }}"
                        >
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
                @endforeach
            </div>

            <div class="mt-8 p-4 bg-blue-50 rounded-lg">
                <p class="text-xs font-bold text-blue-800 uppercase mb-2">How does it work?</p>
                <p class="text-xs text-blue-700 leading-relaxed">
                    Turn the toggle on to enable the new POD template HTML for your account. Here's why you should give it a try:
                </p>
                <ul class="text-xs text-blue-700 mt-2 list-decimal ml-4 space-y-1">
                    <li>Get information like order details, delivery and return address on the POD.</li>
                    <li>Receive authentic signature of your buyer.</li>
                </ul>
            </div>
        </div>

        <!-- Invoice Preview -->
        <div class="w-full lg:w-2/3 flex justify-center bg-gray-100 p-8 rounded-lg border border-dashed border-gray-300 overflow-x-auto">
            <div class="bg-white w-[600px] border border-gray-400 p-1 shadow-lg shadow-gray-400/20" id="invoice-preview">
                <div class="flex justify-between items-start border-b border-gray-800 pb-1 mb-1">
                    <h1 class="text-2xl font-black italic text-gray-800">Fleetshyp</h1>
                    <!-- ✅ Username from Database (Not from Input) -->
                    <span class="text-[10px] text-gray-500" id="preview-seller-name">{{ auth()->user()->name }}</span>
                </div>

                <!-- Return Address (Toggle: return-address) -->
                <div id="return-address" class="text-[10px] text-gray-600 mb-1 {{ ($savedSettings['return_address'] ?? false) ? '' : 'hidden' }}">
                    <p class="font-bold">Return Address:</p>
                    <p>Warehouse Name, Address Line</p>
                    <p>City, State - Pincode | Contact: +91 XXXXX XXXXX</p>
                </div>

                <div class="grid grid-cols-12 border-b border-gray-800 mb-1">
                    <div class="col-span-8 p-2 text-[12px] leading-tight border-r border-gray-800 {{ ($savedSettings['consignee'] ?? true) ? '' : 'hidden' }}" id="consignee-section">
                        <p class="font-bold mb-1">Deliver To:</p>
                        <p id="consignee-name">Name</p>
                        <p id="consignee-address">Address Line 1, Address Line 2</p>
                        <p id="consignee-city">City, State - Pincode</p>
                        <p class="mt-1 font-bold">Mobile: <span class="font-normal" id="consignee-mobile">Mobile number</span></p>
                    </div>
                    <div class="col-span-4 p-2 text-[11px] text-right">
                        <p class="font-bold">Payment Mode</p>
                        <p>Rs. xxx</p>
                        <p class="mt-2 text-[10px]">Weight - x.x Kg(s)</p>
                        <p class="text-[10px]">(10 x 10 x 10 cm)</p>
                    </div>
                </div>

                <!-- Order ID Section (Toggle: order-id-section) -->
                <div id="order-id-section" class="text-center py-2 border-b border-gray-800 {{ ($savedSettings['order_id'] ?? true) ? '' : 'hidden' }}">
                    <p class="text-sm font-bold mb-2">Order ID - xxxxxx <span class="font-normal ml-4">Date: DD-MM-YYYY</span></p>
                    <div class="flex justify-center my-3">
                        {{-- Placeholder for Barcode --}}
                        <div class="flex items-end space-x-0.5 h-12">
                            @for($i=0; $i<40; $i++)
                                <div class="bg-black w-[2px]" style="height: {{ rand(70, 100) }}%"></div>
                                @if($i % 5 == 0) <div class="bg-black w-[4px]" style="height: 100%"></div> @endif
                            @endfor
                        </div>
                    </div>
                    <p class="text-[11px] font-bold mt-1">Courier Name - Awbno : xxxxxx</p>
                </div>

                <!-- Products Table (Toggle: products-table) -->
                <table id="products-table" class="w-full text-[11px] border-collapse border-b border-gray-800 {{ ($savedSettings['products'] ?? true) ? '' : 'hidden' }}">
                    <thead>
                        <tr class="border-b border-gray-800">
                            <th class="p-1 text-left border-r border-gray-800 w-1/2 product-name-column">Product</th>
                            <th class="p-1 border-r border-gray-800 sku-column {{ ($savedSettings['sku'] ?? true) ? '' : 'hidden' }}">SKU</th>
                            <th class="p-1 border-r border-gray-800">Qty</th>
                            <th class="p-1 border-r border-gray-800 amount-column {{ ($savedSettings['amount'] ?? true) ? '' : 'hidden' }}">Amount</th>
                            <th class="p-1 amount-column {{ ($savedSettings['amount'] ?? true) ? '' : 'hidden' }}">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-300">
                            <td class="p-1 border-r border-gray-800 font-medium product-name-column">Product Name</td>
                            <td class="p-1 border-r border-gray-800 text-center sku-column {{ ($savedSettings['sku'] ?? true) ? '' : 'hidden' }}">SKU Number</td>
                            <td class="p-1 border-r border-gray-800 text-center">xx</td>
                            <td class="p-1 border-r border-gray-800 text-center amount-column {{ ($savedSettings['amount'] ?? true) ? '' : 'hidden' }}">XXX.XX</td>
                            <td class="p-1 text-center amount-column {{ ($savedSettings['amount'] ?? true) ? '' : 'hidden' }}">XXX.XX</td>
                        </tr>
                        <tr class="font-bold bg-gray-50">
                            <td colspan="3" class="p-1 text-right border-r border-gray-800">Net Total:</td>
                            <td class="p-1 border-r border-gray-800 text-center amount-column {{ ($savedSettings['amount'] ?? true) ? '' : 'hidden' }}">XXX.XX</td>
                            <td class="p-1 text-center amount-column {{ ($savedSettings['amount'] ?? true) ? '' : 'hidden' }}">XXX.XX</td>
                        </tr>
                    </tbody>
                </table>

                <!-- GST Section (Toggle: gst-section) -->
                <div id="gst-section" class="mt-2 text-[10px] px-1 {{ ($savedSettings['gst'] ?? false) ? '' : 'hidden' }}">
                    <p class="font-bold">GST Details:</p>
                    <p>GSTIN: XXXXXXXXXXXXX</p>
                    <!-- GST Breakup (Toggle: gst-breakup) -->
                    <div id="gst-breakup" class="mt-1 {{ ($savedSettings['gst_breakup'] ?? false) ? '' : 'hidden' }}">
                        <p>CGST: XX.XX | SGST: XX.XX | IGST: XX.XX</p>
                    </div>
                </div>

                <!-- Warehouse Contact (Toggle: warehouse-contact) -->
                <div id="warehouse-contact" class="mt-2 text-[10px] px-1 {{ ($savedSettings['warehouse_contact'] ?? false) ? '' : 'hidden' }}">
                    <p class="font-bold">Warehouse Contact:</p>
                    <p>Name: XXX | Phone: +91 XXXXX XXXXX</p>
                </div>

                <!-- Seller Contact (Toggle: seller-contact) -->
                <div id="seller-contact" class="mt-2 text-[10px] px-1 {{ ($savedSettings['seller_contact'] ?? false) ? '' : 'hidden' }}">
                    <p class="font-bold">Seller Contact:</p>
                    <p>Phone: +91 XXXXX XXXXX | Email: seller@example.com</p>
                </div>

                <div class="mt-4 text-[9px] text-gray-600 italic px-1 leading-tight">
                    <p>All disputes are subject to <strong>State</strong> jurisdiction only. Goods once sold will only be taken back or exchanged as per the store's exchange/return policy.</p>
                    <p>This is computer generated document, hence does not require signature.</p>
                    <p class="text-right mt-2 not-italic font-bold">Powered By <span class="text-blue-800">Fleetshyp</span></p>
                </div>

                <!-- Signature Section (Toggle via checkbox) -->
                <div id="signature-section" class="mt-4 pt-2 border-t border-gray-300 hidden">
                    <div class="flex justify-between items-end px-2">
                        <div>
                            <p class="text-[10px] font-bold">Customer Signature</p>
                            <div class="w-32 h-8 border-b border-gray-400"></div>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold">Authorized Signatory</p>
                            <div class="w-32 h-8 border-b border-gray-400"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Toggle Functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Display Name Sync with Preview
    const displayNameInput = document.getElementById('display_name');
    const previewSellerName = document.getElementById('preview-seller-name');

    if (displayNameInput && previewSellerName) {
        displayNameInput.addEventListener('input', function() {
            previewSellerName.textContent = this.value || 'FSHIP';
        });
    }

    // 2. Toggle Switches Logic
    const toggleSwitches = document.querySelectorAll('.toggle-switch');
    
    toggleSwitches.forEach(toggle => {
        const targetId = toggle.getAttribute('data-target');
        const targetElement = document.getElementById(targetId);
        
        // Initial state set karein
        if (targetElement) {
            targetElement.classList.toggle('hidden', !toggle.checked);
        }
        
        // Change par update karein
        toggle.addEventListener('change', function() {
            if (targetElement) {
                targetElement.classList.toggle('hidden', !this.checked);
            }
        });
    });

    // 3. Signature Checkbox Logic
    const signatureCheckbox = document.getElementById('signature');
    const signatureSection = document.getElementById('signature-section');
    
    if (signatureCheckbox && signatureSection) {
        signatureSection.classList.toggle('hidden', !signatureCheckbox.checked);
        
        signatureCheckbox.addEventListener('change', function() {
            signatureSection.classList.toggle('hidden', !this.checked);
        });
    }

    // 4. Update Button Logic
   // 4. Update Button Logic
const updateBtn = document.getElementById('updateBtn');
if (updateBtn) {
    updateBtn.addEventListener('click', function() {
        const settings = {};
        
        // Toggle states collect karein
        const toggleSwitches = document.querySelectorAll('.toggle-switch');
        toggleSwitches.forEach(toggle => {
            const key = toggle.id.replace('toggle_', '');
            settings[key] = toggle.checked;
        });
        
        // ✅ Ab humein Order ID nahi chahiye, seedha data bhejenge
        const formData = {
            display_name: document.getElementById('display_name')?.value,
            printer: document.getElementById('printer')?.value,
            template: document.getElementById('template')?.value,
            show_signature: document.getElementById('signature')?.checked ? 1 : 0,
            template_settings: settings
        };
        
        const originalHtml = updateBtn.innerHTML;
        updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Saving...';
        updateBtn.disabled = true;
        
        // AJAX Call
        fetch('{{ route("shipping-label-settings.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(async response => {
            const data = await response.json();
            if (response.ok && data.success) {
                alert('Template settings saved successfully!');
            } else {
                throw new Error(data.message || 'Error saving settings');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Update failed: ' + error.message);
        })
        .finally(() => {
            updateBtn.innerHTML = originalHtml;
            updateBtn.disabled = false;
        });
    });
}
});
</script>
@endsection