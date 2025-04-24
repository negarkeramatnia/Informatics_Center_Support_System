<?php

namespace App\Http\Controllers;

use App\Models\MessageRead;
use Illuminate\Http\Request;

class MessageReadController extends Controller
{
    public function index()
    {
        return MessageRead::with(['user', 'message'])->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'message_id' => 'required|exists:messages,id',
        ]);

        // Avoid duplicate reads
        $exists = MessageRead::where('user_id', $validated['user_id'])
                             ->where('message_id', $validated['message_id'])
                             ->first();

        if ($exists) {
            return response()->json(['message' => 'Already marked as read.'], 200);
        }

        $messageRead = MessageRead::create($validated);

        return response()->json($messageRead, 201);
    }

    public function show(MessageRead $messageRead)
    {
        return $messageRead->load(['user', 'message']);
    }

    public function destroy(MessageRead $messageRead)
    {
        $messageRead->delete();

        return response()->json(null, 204);
    }
}