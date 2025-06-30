<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        Ticket::create($validated);

        return redirect()->route('dashboard')->with('success', 'درخواست شما با موفقیت ثبت شد.');
    }

    public function myTickets()
    {
        $myTickets = Ticket::where('user_id', Auth::id())->latest()->paginate(10);
        return view('tickets.my-tickets', ['tickets' => $myTickets]);
    }
    
    public function show(Ticket $ticket)
    {
        // Add authorization here later if needed
        return view('tickets.show', ['ticket' => $ticket]);
    }
}