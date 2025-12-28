<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Asset;

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
    
    public function create() { 
        return view('tickets.create'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            // Uncomment and enforce this now:
            'category' => 'required|in:software,hardware,network,access_control,other', 
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->tickets()->create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'category' => $request->category, // <--- Save the category
            'status' => 'pending',
        ]);

        return redirect()->route('tickets.my')
            ->with('success', 'درخواست شما با موفقیت ثبت شد.');
    }

    public function edit(Ticket $ticket)
    {
        if (Auth::id() !== $ticket->user_id && Auth::user()->role !== 'admin') {
            abort(403);
        }
        return view('tickets.edit', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
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
        $ticket->load(['messages.user', 'user.assets', 'allocatedAssets']);
        $supportUsers = User::where('role', 'support')->get();
        $availableAssets = Asset::where('status', 'available')->orderBy('name')->get();
        return view('tickets.show', compact('ticket', 'supportUsers', 'availableAssets'));
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
        public function complete(Ticket $ticket)
    {
        if (Auth::id() !== $ticket->assigned_to && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $ticket->status = 'completed';
        $ticket->save();

        return redirect()->route('tickets.show', $ticket)->with('success', 'درخواست با موفقیت تکمیل شد.');
    }

    public function rate(Request $request, Ticket $ticket)
    {
        if (Auth::id() !== $ticket->user_id || $ticket->status !== 'completed') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        $ticket->rating = $request->rating;
        $ticket->save();

        return redirect()->route('tickets.show', $ticket)->with('success', 'امتیاز شما با موفقیت ثبت شد.');
    }
        public function allocateAsset(Request $request, Ticket $ticket)
    {
        if (Auth::user()->role !== 'admin' && Auth::id() !== $ticket->assigned_to) {
            abort(403);
        }

        $request->validate([
            'asset_id' => 'required|exists:assets,id',
        ]);

        $asset = Asset::find($request->asset_id);

        if ($asset->status !== 'available') {
            return back()->with('error', 'این قطعه در حال حاضر موجود نیست.');
        }
        $ticket->allocatedAssets()->attach($asset->id);

        $asset->status = 'assigned';
        $asset->assigned_to = $ticket->user_id;
        $asset->save();

        return back()->with('success', 'قطعه با موفقیت به این درخواست تخصیص داده شد.');
    }
}