@extends('layouts.app')

@section('title', 'Seller Agreement Acceptance')

@section('content')
<div class="min-h-screen bg-linear-to-br from-slate-50 to-blue-50 py-8 px-4">
    <div class="max-w-5xl mx-auto">
        
        <!-- Header Card -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6 border-l-4 border-blue-600">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">📄 Seller Agreement</h1>
                    <p class="text-gray-500 mt-1">Please read and accept the agreement to continue</p>
                </div>
                <div class="flex items-center gap-3 bg-blue-50 px-4 py-2 rounded-xl">
                    <span class="text-sm text-gray-600">Version:</span>
                    <span class="font-semibold text-blue-700">{{ $agreement->version ?? '1.0' }}</span>
                </div>
            </div>
            
            @if($agreement->change_description)
            <div class="mt-4 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                <p class="text-sm text-amber-800">
                    <strong>🔄 What's New:</strong> {{ $agreement->change_description }}
                </p>
            </div>
            @endif
        </div>

        <!-- PDF Viewer Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
            <div class="bg-gray-800 text-white px-6 py-4 flex items-center justify-between">
                <h2 class="font-semibold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Agreement Document
                </h2>
                @if($agreement->doc_link)
                <a href="{{ $agreement->doc_link }}" target="_blank" 
                   class="text-sm bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg transition flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download PDF
                </a>
                @endif
            </div>
            
            <!-- PDF Viewer Container -->
            <div class="relative" style="height: 600px;">
                @if($agreement->doc_link)
                <iframe src="{{ $agreement->doc_link }}#toolbar=0" 
                        class="w-full h-full border-0"
                        title="Seller Agreement PDF">
                </iframe>
                @else
                <div class="flex items-center justify-center h-full bg-gray-50">
                    <p class="text-gray-500 text-center">
                        📭 Agreement document not available yet.<br>
                        <span class="text-sm">Please contact admin.</span>
                    </p>
                </div>
                @endif
                
                <!-- Scroll Hint -->
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 
                            bg-black/70 text-white text-xs px-3 py-1.5 rounded-full 
                            animate-bounce pointer-events-none">
                    ↓ Scroll to read full agreement
                </div>
            </div>
        </div>

        <!-- Acceptance Form Card -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border-t-4 border-green-500">
            <form id="agreementForm" action="{{ route('seller.agreement.accept') }}" method="POST">
                @csrf
                <input type="hidden" name="agreement_id" value="{{ $agreement->id ?? '' }}">
                <input type="hidden" name="version" value="{{ $agreement->version ?? '1.0' }}">
                <input type="hidden" name="section_name" value="{{ $agreement->section_name ?? 'Seller Agreement' }}">
                
                <!-- Acceptance Checkbox -->
                <div class="flex items-start gap-4 p-4 bg-green-50 rounded-xl border border-green-200 mb-6">
                    <div class="flex items-center h-5">
                        <input type="checkbox" id="acceptCheckbox" name="accept" required
                               class="w-5 h-5 text-green-600 border-gray-300 rounded 
                                      focus:ring-green-500 focus:ring-2 cursor-pointer">
                    </div>
                    <label for="acceptCheckbox" class="text-gray-700 cursor-pointer select-none">
                        <strong>I have read, understood, and agree to</strong> the terms and conditions outlined in the Seller Agreement. 
                        I acknowledge that this acceptance is legally binding.
                    </label>
                </div>

                <!-- Info Text -->
                <div class="flex items-start gap-3 text-sm text-gray-500 mb-6 bg-gray-50 p-4 rounded-lg">
                    <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p>
                        By accepting, your IP address (<strong>{{ request()->ip() }}</strong>) and timestamp will be recorded for audit purposes. 
                        You can view your acceptance history in your account settings.
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-end">
                    <button type="button" id="viewLaterBtn"
                            class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 
                                   rounded-xl font-medium transition focus:outline-none focus:ring-2 
                                   focus:ring-gray-400">
                        View Later
                    </button>
                    <button type="submit" id="acceptBtn" disabled
                            class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white 
                                   rounded-xl font-semibold transition focus:outline-none 
                                   focus:ring-2 focus:ring-green-400 disabled:opacity-50 
                                   disabled:cursor-not-allowed flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Accept & Continue
                    </button>
                </div>
            </form>
        </div>

        <!-- Already Accepted Badge -->
        @if(isset($alreadyAccepted) && $alreadyAccepted)
        <div class="mt-6 p-4 bg-green-100 border border-green-300 rounded-xl text-center">
            <p class="text-green-800 font-medium">
                ✅ You have already accepted this agreement on 
                <strong>{{ $acceptance->acceptance_date ?? 'N/A' }}</strong>
            </p>
        </div>
        @endif

    </div>
</div>

<!-- Success Toast (Hidden by default) -->
<div id="successToast" class="fixed top-4 right-4 bg-green-600 text-white px-6 py-4 
                             rounded-xl shadow-2xl transform translate-x-full transition-transform 
                             duration-300 z-50 flex items-center gap-3">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
    </svg>
    <span>Agreement accepted successfully! 🎉</span>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkbox = document.getElementById('acceptCheckbox');
    const acceptBtn = document.getElementById('acceptBtn');
    const form = document.getElementById('agreementForm');
    const viewLaterBtn = document.getElementById('viewLaterBtn');
    const successToast = document.getElementById('successToast');

    // Enable button only when checkbox is checked
    checkbox.addEventListener('change', function() {
        acceptBtn.disabled = !this.checked;
    });

    // View Later - save as pending
    viewLaterBtn.addEventListener('click', function() {
        if(confirm('Do you want to save this as "Pending" and continue later?')) {
            // Optional: AJAX call to save pending status
            window.location.href = "{{ route('seller.dashboard') }}";
        }
    });

    // Form Submission with Animation
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Disable button to prevent double submit
        acceptBtn.disabled = true;
        acceptBtn.innerHTML = `
            <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Accepting...
        `;

        // Submit form via Fetch for better UX
        const formData = new FormData(form);
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // Show success toast
                successToast.classList.remove('translate-x-full');
                setTimeout(() => {
                    successToast.classList.add('translate-x-full');
                    // Redirect after toast
                    window.location.href = data.redirect_url || "{{ route('seller.dashboard') }}";
                }, 2000);
            } else {
                throw new Error(data.message || 'Submission failed');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ ' + (error.message || 'Something went wrong. Please try again.'));
            acceptBtn.disabled = false;
            acceptBtn.innerHTML = `
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Accept & Continue
            `;
        });
    });
});
</script>
@endpush