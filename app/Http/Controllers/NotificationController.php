<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SystemAlert;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
            
            // Redirect to the target URL (e.g., the ticket page)
            return redirect($notification->data['url']);
        }

        return back();
    }

    public function markAllRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'همه اعلان‌ها خوانده شدند.');
    }

    public function createAlert()
    {
        // Only allow admins
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
        return view('admin.notifications.create');
    }

    // Step 6.2: Send the alert
    public function sendAlert(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Send to ALL users
        $users = User::all();
        
        Notification::send($users, new SystemAlert($request->title, $request->message));

        return back()->with('success', 'اعلان عمومی با موفقیت ارسال شد.');
    }
}