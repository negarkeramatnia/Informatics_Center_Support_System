<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Ticket;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        return Message::with(['user', 'ticket'])->latest()->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $message = Message::create($validated);

        return response()->json($message, 201);
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