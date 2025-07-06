<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        return Message::with(['user', 'ticket'])->latest()->get();
    }
    /**
     * Store a newly created message in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Ticket $ticket)
    {
        // Authorization logic remains the same
        if (
            Auth::id() !== $ticket->user_id &&
            Auth::id() !== $ticket->assigned_to &&
            Auth::user()->role !== 'admin'
        ) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'body' => 'required|string',
        ]);

        // --- FIX: Changed 'body' to 'message' to match your database column name ---
        $ticket->messages()->create([
            'user_id' => Auth::id(),
            'message' => $request->body, // The form input is named 'body', but the DB column is 'message'
        ]);

        return back()->with('success', 'پیام شما با موفقیت ثبت شد.');
    }

    public function show(Message $message)
    {
        return $message->load(['user', 'ticket']);
    }

    public function update(Request $request, Message $message)
    {
        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        $message->update($validated);

        return response()->json($message);
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return response()->json(null, 204);
    }
}