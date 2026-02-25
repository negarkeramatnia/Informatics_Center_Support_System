<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        // 1. FIXED 403 ERROR: Check the new 'assignees' pivot table, NOT the deleted 'assigned_to' column
        if (
            Auth::id() !== $ticket->user_id &&
            !$ticket->assignees->contains(Auth::id()) &&
            Auth::user()->role !== 'admin'
        ) {
            abort(403, 'Unauthorized action.');
        }

        // 2. FIXED VALIDATION: The form sends 'message', so we validate 'message', not 'body'
        $request->validate([
            'message' => 'required|string',
        ]);
        
        $ticket->messages()->create([
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return back()->with('success', 'پیام شما با موفقیت ثبت شد.');
    }
}