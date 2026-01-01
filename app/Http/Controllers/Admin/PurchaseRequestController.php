<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PurchaseRequest;
use Illuminate\Http\Request;

class PurchaseRequestController extends Controller
{
    // List all requests
    public function index()
    {
        $requests = PurchaseRequest::with('user')->latest()->paginate(10);
        return view('admin.purchase-requests.index', compact('requests'));
    }

    // Show creation form
    public function create(Request $request)
    {
        $ticket = null;
        if ($request->has('ticket_id')) {
            $ticket = \App\Models\Ticket::find($request->ticket_id);
        }
        
        return view('admin.purchase-requests.create', compact('ticket'));
    }

    // Store the request
public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'estimated_price' => 'nullable|numeric',
            'reason' => 'required|string',
            'url' => 'nullable|url',
            'ticket_id' => 'nullable|exists:tickets,id', // Validate ticket
        ]);

        PurchaseRequest::create([
            'user_id' => auth()->id(),
            'ticket_id' => $request->ticket_id, // Save it
            'item_name' => $request->item_name,
            'quantity' => $request->quantity,
            'estimated_price' => $request->estimated_price,
            'url' => $request->url,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        // Optional: Add a message to the ticket saying a request was made
        if ($request->ticket_id) {
            $ticket = \App\Models\Ticket::find($request->ticket_id);
            // You could log a message here if you have a Message model
        }

        return redirect()->route('admin.purchase-requests.index')
            ->with('success', 'درخواست خرید با موفقیت ثبت شد.');
    }

    // The "Office-Ready" View
    public function show(PurchaseRequest $purchaseRequest)
    {
        return view('admin.purchase-requests.show', compact('purchaseRequest'));
    }

    // Approve/Reject logic (Optional for now, but good to have)
    public function updateStatus(Request $request, PurchaseRequest $purchaseRequest)
    {
        $purchaseRequest->update(['status' => $request->status]);
        return back()->with('success', 'وضعیت درخواست تغییر کرد.');
    }
}