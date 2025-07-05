<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        // Start building the query
        $query = Ticket::with('user')->latest();

        // Apply filters based on the request
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'open':
                    $query->whereIn('status', ['pending', 'in_progress']);
                    break;
                case 'unassigned':
                    $query->whereNull('assigned_to')->where('status', 'pending');
                    break;
            }
        }

        $tickets = $query->paginate(15);

        return view('tickets.index', compact('tickets'));
    }
    
    public function create() { return view('tickets.create'); }

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
        return view('tickets.show', ['ticket' => $ticket]);
    }
}