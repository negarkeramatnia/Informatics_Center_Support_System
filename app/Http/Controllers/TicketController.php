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
    public function index()
    {
        return Ticket::with(['user', 'assignedUser'])->latest()->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'assigned_to' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'resolution_notes' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
        ]);

        $ticket = Ticket::create($validated);

        return response()->json($ticket, 201);
    }

    public function show(Ticket $ticket)
    {
        return $ticket->load(['user', 'assignedUser', 'messages']);
    }

    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'assigned_to' => 'nullable|exists:users,id',
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'resolution_notes' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
        ]);

        $ticket->update($validated);

        return response()->json($ticket);
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return response()->json(null, 204);
    }

    public function myTickets()
    {
        $myTickets = Ticket::where('user_id', Auth::id())->latest()->paginate(10);
        return view('tickets.my-tickets', ['tickets' => $myTickets]);
    }
}
