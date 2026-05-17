@extends('admin.layouts.app') 

@section('content')
<div class="space-y-6">

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-sm flex justify-between items-center">
            <div class="flex items-center">
                <i class="fa-solid fa-check-circle text-green-500 mr-3"></i>
                <span class="text-green-700 font-medium">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700"><i class="fa-solid fa-times"></i></button>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded shadow-sm flex justify-between items-center">
            <div class="flex items-center">
                <i class="fa-solid fa-exclamation-circle text-red-500 mr-3"></i>
                <span class="text-red-700 font-medium">{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700"><i class="fa-solid fa-times"></i></button>
        </div>
    @endif

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Agreement Management</h1>
            <p class="text-sm text-slate-500 mt-1">Manage seller agreements, track versions, and monitor acceptance status.</p>
        </div>
        <button onclick="document.getElementById('uploadModal').classList.remove('hidden')" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-colors flex items-center">
            <i class="fa-solid fa-plus mr-2"></i> Upload New Version
        </button>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-slate-700">Published Agreement Logs</h2>
            <!-- Search Input -->
            <div class="relative hidden sm:block">
                <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search version or section..." class="pl-9 pr-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none w-64">
                <i class="fa-solid fa-search absolute left-3 top-2.5 text-slate-400 text-xs"></i>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="agreementTable">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 text-xs uppercase tracking-wider font-semibold">
                        <!-- DB Columns: section_name, version, change_description, uploaded_by, published_at, file_path, status -->
                        <th class="p-4 border-b border-slate-200">Section Name</th>
                        <th class="p-4 border-b border-slate-200">Version</th>
                        <th class="p-4 border-b border-slate-200">Change Description</th>
                        <th class="p-4 border-b border-slate-200">Uploaded By</th>
                        <th class="p-4 border-b border-slate-200">Published On</th>
                        <th class="p-4 border-b border-slate-200 text-center">Document</th>
                        
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700 divide-y divide-slate-100">
                    @forelse($agreements as $item)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <!-- 1. Section Name -->
                        <td class="p-4 font-medium text-slate-800">{{ $item->section_name }}</td>
                        
                        <!-- 2. Version -->
                        <td class="p-4">
                            <span class="bg-indigo-50 text-indigo-700 border border-indigo-100 px-2 py-1 rounded text-xs font-bold">
                                v{{ $item->version }}
                            </span>
                        </td>
                        
                        <!-- 3. Change Description -->
                        <td class="p-4 max-w-xs truncate" title="{{ $item->change_description }}">
                            {{ $item->change_description ?? '-' }}
                        </td>
                        
                        <!-- 4. Uploaded By (Relation: uploaded_by -> User) -->
                        <td class="p-4 text-slate-600">
                            @if($item->uploader)
                                <div class="font-medium text-slate-800">{{ $item->uploader->name }}</div>
                                <div class="text-xs text-slate-400">{{ $item->uploader->email }}</div>
                            @else
                                <span class="text-slate-400 italic">System / Unknown</span>
                            @endif
                        </td>
                        
                        <!-- 5. Published On (DB: published_at) -->
                        <td class="p-4 text-slate-500 whitespace-nowrap">
                            {{ $item->published_at ? \Carbon\Carbon::parse($item->published_at)->format('d-m-Y h:i A') : '-' }}
                        </td>
                        
                        <!-- 6. Document Link (DB: file_path) -->
                        <td class="p-4 text-center">
                            @if($item->file_path)
                                <a href="{{ Storage::url($item->file_path) }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition-colors font-medium text-xs border border-red-200">
                                    <i class="fa-solid fa-file-pdf text-lg"></i> 
                                    View PDF
                                </a>
                            @else
                                <span class="text-slate-400 text-xs">No File</span>
                            @endif
                        </td>
                        
                        
                      
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fa-solid fa-folder-open text-4xl text-slate-300 mb-3"></i>
                                <p class="text-lg font-medium">No agreements found</p>
                                <p class="text-sm">Upload the first version to get started.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($agreements->hasPages())
        <div class="p-4 border-t border-slate-200 bg-slate-50 flex justify-between items-center flex-wrap gap-4">
            <span class="text-xs text-slate-500">
                Showing <strong>{{ $agreements->firstItem() }}</strong> to <strong>{{ $agreements->lastItem() }}</strong> of <strong>{{ $agreements->total() }}</strong> entries
            </span>
            <div class="flex gap-1">
                {{ $agreements->links('pagination::simple-tailwind') }}
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Upload Modal -->
<div id="uploadModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity backdrop-blur-sm" onclick="document.getElementById('uploadModal').classList.add('hidden')"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
            
            <!-- Modal Header -->
            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fa-solid fa-cloud-arrow-up text-indigo-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                        <h3 class="text-base font-semibold leading-6 text-slate-900" id="modal-title">Upload New Agreement</h3>
                        <div class="mt-2">
                            <p class="text-sm text-slate-500 mb-4">This version will be published to all sellers immediately.</p>
                            
                            <form action="{{ route('admin.agreements.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="mb-4">
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Section Name</label>
                                    <input type="text" name="section_name" value="Seller Agreement" class="w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2 bg-slate-100 text-slate-500" readonly>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Version Number <span class="text-red-500">*</span></label>
                                    <input type="text" name="version" value="{{ old('version') }}" placeholder="e.g. 1.1" required class="w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2 @error('version') @enderror">
                                    @error('version') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Change Description <span class="text-red-500">*</span></label>
                                    <textarea name="change_description" rows="3" required class="w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2 @error('change_description') @enderror" placeholder="What has changed in this version?">{{ old('change_description') }}</textarea>
                                    @error('change_description') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="block text-xs font-medium text-slate-700 mb-1">PDF Document <span class="text-red-500">*</span></label>
                                    <input type="file" name="agreement_pdf" accept=".pdf" required class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-slate-300 rounded-md p-2 @error('agreement_pdf') @enderror">
                                    @error('agreement_pdf') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    <p class="text-xs text-slate-400 mt-1">Only PDF files allowed (Max 10MB).</p>
                                </div>

                                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse gap-2">
                                    <button type="submit" class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 sm:w-auto">
                                        Publish Now
                                    </button>
                                    <button type="button" onclick="document.getElementById('uploadModal').classList.add('hidden')" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Simple client-side search filter for Version and Section Name
    function filterTable() {
        let input = document.getElementById("searchInput");
        let filter = input.value.toUpperCase();
        let table = document.getElementById("agreementTable");
        let tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
            // Column 0: Section Name, Column 1: Version
            let tdSection = tr[i].getElementsByTagName("td")[0];
            let tdVersion = tr[i].getElementsByTagName("td")[1];
            
            if (tdSection || tdVersion) {
                let txtValueS = tdSection.textContent || tdSection.innerText;
                let txtValueV = tdVersion.textContent || tdVersion.innerText;
                
                if (txtValueS.toUpperCase().indexOf(filter) > -1 || txtValueV.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
@endpush
@endsection