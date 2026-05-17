<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    // Display Ticket List Page
    public function index(Request $request)
{
    $query = Ticket::where('user_id', Auth::id());

    // 🔍 Search: Reference ID ya Ticket Number mein
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('reference_id', 'LIKE', "%{$search}%")
              ->orWhere('ticket_number', 'LIKE', "%{$search}%");
        });
    }

    // 🔽 Filter by Status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // 🔽 Filter by Category
    if ($request->filled('category')) {
        $query->where('category', $request->category);
    }

    $tickets = $query->latest()->paginate(15);

    return view('seller.ticket.index', compact('tickets'));
}

    // Display Create Ticket Form
    public function showcreateticket()
    {
        return view('seller.ticket.createticket');
    }

    // ✅ Store/Create New Ticket (Backend Logic)
    public function store(Request $request)
    {
        // 1. Validation
        $validated = $request->validate([
            'category' => 'required|string|in:First Mile,Last Mile,Post Delivery Dispute,Weight,Finance,Technical,Account Query,B2B Related Issues',
            'sub_category' => 'required|string',
            'reference_id' => 'required|string|max:255',
            'remark' => 'nullable|string|max:1000',
            'attachments.*' => 'nullable|file|mimes:png,jpeg,jpg,pdf,doc,docx,xls,xlsx,csv,mp3,mp4|max:5120' // Max 5MB per file
        ], [
            'category.required' => 'Please select a category',
            'sub_category.required' => 'Please select a sub-category',
            'reference_id.required' => 'Reference ID is required',
            'attachments.*.mimes' => 'Only png, jpeg, pdf, doc, xls, mp3, mp4 files are allowed',
            'attachments.*.max' => 'Each file must be less than 5MB'
        ]);

        // 2. Handle File Uploads
        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                // Store in: storage/app/public/tickets/{user_id}/
                $path = $file->store('tickets/' . Auth::id(), 'public');
                if ($path) {
                    $attachmentPaths[] = $path;
                }
            }
        }

        // 3. Create Ticket in Database
        $ticket = Ticket::create([
            'user_id' => Auth::id(),
            'ticket_number' => 'TKT-' . strtoupper(uniqid()),
            'category' => $validated['category'],
            'sub_category' => $validated['sub_category'],
            'reference_id' => $validated['reference_id'],
            'remark' => $validated['remark'] ?? null,
            'attachments' => $attachmentPaths, // Stored as JSON array
            'status' => 'open' // Default status
        ]);

        // 4. Redirect with Success Message
        return redirect()->route('seller.ticket.index')
            ->with('success', "Ticket created successfully! Ticket Number: <strong>{$ticket->ticket_number}</strong>");
    }
}