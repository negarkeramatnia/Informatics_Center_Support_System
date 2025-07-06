<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function index(Request $request): View
    {
        $query = Ticket::with('user')->latest();

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
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
        ]);

        Auth::user()->tickets()->create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => 'pending',
        ]);

        return redirect()->route('tickets.my')->with('success', 'درخواست شما با موفقیت ثبت شد.');
    }

        public function edit(Ticket $ticket)
    {
        // Add authorization: only owner or admin can edit
        if (Auth::id() !== $ticket->user_id && Auth::user()->role !== 'admin') {
            abort(403);
        }
        return view('tickets.edit', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        // Add authorization
        if (Auth::id() !== $ticket->user_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
        ]);

        $ticket->update($request->only('title', 'description', 'priority'));

        return redirect()->route('tickets.show', $ticket)->with('success', 'درخواست با موفقیت ویرایش شد.');
    }

    public function myTickets()
    {
        $myTickets = Ticket::where('user_id', Auth::id())->latest()->paginate(10);
        return view('tickets.my-tickets', ['tickets' => $myTickets]);
    }

    public function show(Ticket $ticket): View
    {
        $ticket->load('messages.user');

        $supportUsers = User::where('role', 'support')->get();
        return view('tickets.show', compact('ticket', 'supportUsers'));
    }
    public function complete(Request $request, Ticket $ticket)
    {
        // Authorization: Ensure only the owner, assigned support, or admin can complete.
        if (
            Auth::id() !== $ticket->user_id &&
            Auth::id() !== $ticket->assigned_to &&
            Auth::user()->role !== 'admin'
        ) {
            abort(403, 'Unauthorized action.');
        }

        $ticket->status = 'completed';
        $successMessage = 'درخواست با موفقیت تکمیل شد.';

        // --- FIX: Only validate and save rating if the ticket creator is completing it ---
        if (Auth::id() === $ticket->user_id) {
            $request->validate([
                'rating' => ['required', 'integer', 'min:1', 'max:5'],
            ], [
                'rating.required' => 'لطفاً برای تکمیل، یک امتیاز از 1 تا 5 ستاره انتخاب کنید.'
            ]);
            $ticket->rating = $request->rating;
            $successMessage = 'درخواست با موفقیت تکمیل و امتیاز شما ثبت شد.';
        }

        $ticket->save();

        return redirect()->route('tickets.show', $ticket)->with('success', $successMessage);
    }
    public function assign(Request $request, Ticket $ticket)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $supportUser = User::find($request->assigned_to);
        if ($supportUser->role !== 'support') {
            return back()->with('error', 'کاربر انتخاب شده عضو تیم پشتیبانی نیست.');
        }

        $ticket->assigned_to = $request->assigned_to;
        $ticket->status = 'in_progress';
        $ticket->save();

        return redirect()->route('tickets.show', $ticket)->with('success', 'درخواست با موفقیت به ' . $supportUser->name . ' ارجاع داده شد.');
    }
}