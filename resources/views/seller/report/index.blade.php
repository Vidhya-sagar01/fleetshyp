@extends('seller.layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Page Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h1 class="text-2xl font-bold text-gray-800">MIS Report</h1>
    </div>

    <!-- ✅ Main Filter Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6">
            <form action="#" method="GET" id="reportForm">
                
                <!-- Row 1: Waybill, Payment, Pickup Address, Status -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <!-- Waybill Number -->
                    <div class="space-y-1">
                        <label class="block text-xs font-medium text-gray-700">Waybill number</label>
                        <input type="text" name="waybill_number" class="form-control w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all" placeholder="Search by waybill number">
                    </div>

                    <!-- Payment -->
                    <div class="space-y-1">
                        <label class="block text-xs font-medium text-gray-700">Payment</label>
                        <div class="relative">
                            <select name="payment_mode" class="form-control w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all bg-white appearance-none">
                                <option value="">Search by mode</option>
                                <option value="cod">COD</option>
                                <option value="prepaid">Prepaid</option>
                            </select>
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                <i class="fa fa-chevron-down text-xs"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Pickup Address -->
                    <div class="space-y-1">
                        <label class="block text-xs font-medium text-gray-700">Pickup Address</label>
                        <div class="relative">
                            <select name="pickup_address" class="form-control w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all bg-white appearance-none">
                                <option value="">Select by pickup address</option>
                                <option value="1">Mumbai Warehouse</option>
                                <option value="2">Delhi Warehouse</option>
                                <option value="3">Bangalore Warehouse</option>
                            </select>
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                <i class="fa fa-chevron-down text-xs"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="space-y-1">
                        <label class="block text-xs font-medium text-gray-700">Status</label>
                        <div class="relative">
                            <select name="status" class="form-control w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all bg-white appearance-none">
                                <option value="">Select by status</option>
                                <option value="new">New</option>
                                <option value="booked">Booked</option>
                                <option value="in_transit">In Transit</option>
                                <option value="out_for_delivery">Out for Delivery</option>
                                <option value="delivered">Delivered</option>
                                <option value="rto">RTO</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                <i class="fa fa-chevron-down text-xs"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Row 2: Date Type, Date, Fulfilled By -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <!-- Date Type -->
                    <div class="space-y-1">
                        <label class="block text-xs font-medium text-gray-700">Date Type</label>
                        <div class="relative">
                            <select name="date_type" class="form-control w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all bg-white appearance-none">
                                <option value="awb">AWB Date</option>
                                <option value="order">Order Date</option>
                                <option value="delivery">Delivery Date</option>
                            </select>
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                <i class="fa fa-chevron-down text-xs"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Date Range -->
                    <div class="space-y-1">
                        <label class="block text-xs font-medium text-gray-700">Date</label>
                        <div class="relative">
                            <input type="text" name="date_range" class="form-control w-full pl-10 pr-10 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all" placeholder="Select date range" id="dateRangePicker">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <i class="fa fa-calendar-alt text-blue-500"></i>
                            </span>
                            <button type="button" id="clearDate" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500 transition-colors">
                                <i class="fa fa-trash-alt text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Fulfilled By (Courier) -->
                    <div class="space-y-1">
                        <label class="block text-xs font-medium text-gray-700">Fulfilled by</label>
                        <div class="relative">
                            <select name="courier" class="form-control w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all bg-white appearance-none">
                                <option value="">Select by courier partner</option>
                                <option value="delhivery">Delhivery</option>
                                <option value="bluedart">BlueDart</option>
                                <option value="shadowfax">Shadowfax</option>
                                <option value="amazon">Amazon</option>
                                <option value="ekart">Ekart</option>
                            </select>
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                <i class="fa fa-chevron-down text-xs"></i>
                            </span>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <!-- ✅ Additional Fields Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6">
            <h3 class="text-base font-semibold text-gray-800 mb-4">Additional Fields you might require in MIS report</h3>
            
            <form id="columnSelectionForm">
                <!-- Select All -->
                <div class="mb-4">
                    <label class="flex items-center cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors">
                        <input type="checkbox" id="selectAllFields" class="form-checkbox rounded border-gray-300 text-gold focus:ring-gold mr-2">
                        <span class="text-sm text-gray-700 font-medium">Select All</span>
                    </label>
                </div>

                <!-- Checkboxes Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
                    
                    <label class="flex items-center p-2 hover:bg-gray-50 cursor-pointer transition-colors">
                        <input type="checkbox" name="columns[]" value="pickup_date" class="form-checkbox rounded border-gray-300 text-gold focus:ring-gold mr-2 field-checkbox">
                        <span class="text-sm text-gray-700">Pickup Date</span>
                    </label>

                    <label class="flex items-center p-2 hover:bg-gray-50 cursor-pointer transition-colors">
                        <input type="checkbox" name="columns[]" value="pickup_address" class="form-checkbox rounded border-gray-300 text-gold focus:ring-gold mr-2 field-checkbox">
                        <span class="text-sm text-gray-700">Pickup Address</span>
                    </label>

                    <label class="flex items-center p-2 hover:bg-gray-50 cursor-pointer transition-colors">
                        <input type="checkbox" name="columns[]" value="pickup_pincode" class="form-checkbox rounded border-gray-300 text-gold focus:ring-gold mr-2 field-checkbox">
                        <span class="text-sm text-gray-700">Pickup Pincode</span>
                    </label>

                    <label class="flex items-center p-2 hover:bg-gray-50 cursor-pointer transition-colors">
                        <input type="checkbox" name="columns[]" value="pickup_city" class="form-checkbox rounded border-gray-300 text-gold focus:ring-gold mr-2 field-checkbox">
                        <span class="text-sm text-gray-700">Pickup City</span>
                    </label>

                    <label class="flex items-center p-2 hover:bg-gray-50 cursor-pointer transition-colors">
                        <input type="checkbox" name="columns[]" value="pickup_state" class="form-checkbox rounded border-gray-300 text-gold focus:ring-gold mr-2 field-checkbox">
                        <span class="text-sm text-gray-700">Pickup State</span>
                    </label>

                    <label class="flex items-center p-2 hover:bg-gray-50 cursor-pointer transition-colors">
                        <input type="checkbox" name="columns[]" value="pickup_phone" class="form-checkbox rounded border-gray-300 text-gold focus:ring-gold mr-2 field-checkbox">
                        <span class="text-sm text-gray-700">Pickup Phone</span>
                    </label>

                    <label class="flex items-center p-2 hover:bg-gray-50 cursor-pointer transition-colors">
                        <input type="checkbox" name="columns[]" value="1st_attempt_date" class="form-checkbox rounded border-gray-300 text-gold focus:ring-gold mr-2 field-checkbox">
                        <span class="text-sm text-gray-700">1<sup>st</sup> Attempt Date</span>
                    </label>

                    <label class="flex items-center p-2 hover:bg-gray-50 cursor-pointer transition-colors">
                        <input type="checkbox" name="columns[]" value="2nd_attempt_date" class="form-checkbox rounded border-gray-300 text-gold focus:ring-gold mr-2 field-checkbox">
                        <span class="text-sm text-gray-700">2<sup>nd</sup> Attempt Date</span>
                    </label>

                    <label class="flex items-center p-2 hover:bg-gray-50 cursor-pointer transition-colors">
                        <input type="checkbox" name="columns[]" value="3rd_attempt_date" class="form-checkbox rounded border-gray-300 text-gold focus:ring-gold mr-2 field-checkbox">
                        <span class="text-sm text-gray-700">3<sup>rd</sup> Attempt Date</span>
                    </label>

                    <label class="flex items-center p-2 hover:bg-gray-50 cursor-pointer transition-colors">
                        <input type="checkbox" name="columns[]" value="last_attempt_date" class="form-checkbox rounded border-gray-300 text-gold focus:ring-gold mr-2 field-checkbox">
                        <span class="text-sm text-gray-700">Last Attempt Date</span>
                    </label>

                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mt-6 pt-6 border-t border-gray-100">
                    <a href="{{ url()->previous() }}" class="w-full sm:w-auto px-6 py-2.5 text-sm font-medium text-white bg-indigo-900 hover:bg-indigo-800 rounded-lg transition-all flex items-center justify-center">
                        <i class="fa fa-arrow-left mr-2"></i> Back
                    </a>
                    
                    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                        <button type="button" id="clearFilters" class="w-full sm:w-auto px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-all flex items-center justify-center">
                            <i class="fa fa-undo mr-2"></i> Clear Filter
                        </button>
                        <button type="submit" class="w-full sm:w-auto px-6 py-2.5 text-sm font-medium text-white bg-gradient-gold hover:shadow-lg rounded-lg transition-all flex items-center justify-center">
                            <i class="fa fa-download mr-2"></i> Download Report
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

<!-- CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .form-control:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15);
    }
</style>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Date Range Picker
        const datePicker = flatpickr("#dateRangePicker", {
            mode: "range",
            dateFormat: "M d - M d",
            defaultDate: ["Feb 01", "Apr 30"],
            locale: { firstDayOfWeek: 1 },
            allowInput: true
        });

        // Clear Date Button
        document.getElementById('clearDate')?.addEventListener('click', function() {
            datePicker.clear();
        });

        // Select All Checkboxes
        document.getElementById('selectAllFields')?.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.field-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        // Individual checkbox change - update Select All
        document.querySelectorAll('.field-checkbox').forEach(cb => {
            cb.addEventListener('change', function() {
                const totalCheckboxes = document.querySelectorAll('.field-checkbox').length;
                const checkedCheckboxes = document.querySelectorAll('.field-checkbox:checked').length;
                const selectAll = document.getElementById('selectAllFields');
                
                if (selectAll) {
                    selectAll.checked = (totalCheckboxes === checkedCheckboxes);
                    selectAll.indeterminate = (checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes);
                }
            });
        });

        // Clear Filters
        document.getElementById('clearFilters')?.addEventListener('click', function() {
            if(confirm('Clear all filters and reset form?')) {
                document.getElementById('reportForm')?.reset();
                document.getElementById('columnSelectionForm')?.reset();
                datePicker.clear();
                
                showToast('Filters cleared successfully', 'success');
            }
        });

        // Form Submit Handler
        document.getElementById('columnSelectionForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const selectedColumns = Array.from(
                document.querySelectorAll('input[name="columns[]"]:checked')
            ).map(cb => cb.value);
            
            if (selectedColumns.length === 0) {
                showToast('Please select at least one additional field', 'danger');
                return;
            }
            
            // Show loading
            showToast('Preparing report... Please wait', 'info');
            
            // Simulate download (Replace with actual AJAX/Form submit)
            setTimeout(() => {
                showToast('Report downloaded successfully! 📥', 'success');
                
                // Actual form submit example:
                // const formData = new FormData(document.getElementById('reportForm'));
                // selectedColumns.forEach(col => formData.append('columns[]', col));
                // window.location.href = "#?" + new URLSearchParams(formData);
            }, 1500);
        });

        // Toast Notification
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white text-sm z-50 transition-all transform translate-y-0 ${
                type === 'success' ? 'bg-green-600' : type === 'danger' ? 'bg-red-600' : 'bg-blue-600'
            }`;
            toast.innerHTML = `<div class="flex items-center"><i class="fa fa-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-circle' : 'info-circle'} mr-2"></i>${message}</div>`;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
    });
</script>

@endsection