<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
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
        $ticket->messages()->create([
            'user_id' => Auth::id(),
            'message' => $request->body,
        ]);

        return back()->with('success', 'پیام شما با موفقیت ثبت شد.');
    }
}