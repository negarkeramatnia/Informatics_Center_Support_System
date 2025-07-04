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

    
    public function myTickets()
    {
        $myTickets = Ticket::where('user_id', Auth::id())->latest()->paginate(10);
        return view('tickets.my-tickets', ['tickets' => $myTickets]);
    }

    public function show(Ticket $ticket): View
    {
        $supportUsers = User::where('role', 'support')->get();
        return view('tickets.show', compact('ticket', 'supportUsers'));
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