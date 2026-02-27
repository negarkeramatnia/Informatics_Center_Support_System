<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Asset;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewTicketCreated;

class TicketController extends Controller
{
public function index(\Illuminate\Http\Request $request)
    {
        // 1. Start a fresh database query
        $query = \App\Models\Ticket::query();
        $user = auth()->user();

        // 2. STRICT ROLE-BASED SECURITY
        if ($user->role === 'user') {
            // Normal users ONLY see tickets they created
            $query->where('user_id', $user->id);
            $pageTitle = 'همه درخواست‌های من';
        } 
        elseif ($user->role === 'support') {
            // Support users ONLY see tickets assigned to them via the pivot table!
            $query->whereHas('assignees', function($q) use ($user) {
                $q->where('users.id', $user->id);
            });
            $pageTitle = 'درخواست‌های ارجاع شده به من';
        }
        else {
            // Admins see everything
            $pageTitle = 'همه درخواست‌ها در سیستم';
        }

        // 3. The Dashboard Filters (Refining the secure base query)
        if ($request->status === 'active') {
            $query->whereIn('status', ['pending', 'open', 'in_progress']);
            $pageTitle = $user->role === 'support' ? 'درخواست‌های فعال من' : 'درخواست‌های فعال';
        } 
        elseif ($request->status === 'in_progress') {
            $query->where('status', 'in_progress'); 
            $pageTitle = 'درخواست‌های در حال بررسی';
        } 
        elseif ($request->status === 'completed') {
            $query->where('status', 'completed');
            $pageTitle = 'درخواست‌های تکمیل شده';
        } 
        elseif ($request->priority === 'high') {
            $query->where('priority', 'high');
            $pageTitle = 'درخواست‌های اولویت بالا';
        }
        elseif ($request->status === 'completed_recent') {
            $query->where('status', 'completed')
                  ->where('updated_at', '>=', now()->subDays(7));
            $pageTitle = 'تکمیل شده (هفته اخیر)';
        }

        // 4. Fetch the results and preserve the URL parameters
        $tickets = $query->latest()->paginate(10)->withQueryString();
        
        return view('tickets.index', compact('tickets', 'pageTitle'));
    }
    
    public function create() { return view('tickets.create'); }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'category' => 'required|in:software,hardware,network,access_control,other', 
        ]);

        $ticket = Auth::user()->tickets()->create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'category' => $request->category,
            'status' => 'pending',
        ]);

        $recipients = User::whereIn('role', ['admin', 'support'])->get();
        Notification::send($recipients, new NewTicketCreated($ticket));

        return redirect()->route('tickets.my')->with('success', 'درخواست شما با موفقیت ثبت شد.');
    }

    public function edit(Ticket $ticket)
    {
        if (Auth::id() !== $ticket->user_id && Auth::user()->role !== 'admin') abort(403);
        return view('tickets.edit', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        if (Auth::id() !== $ticket->user_id && Auth::user()->role !== 'admin') abort(403);

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
        $ticket->load(['messages.user', 'user.assets', 'allocatedAssets', 'assignees']);
        $supportUsers = User::where('role', 'support')->get();
        $availableAssets = Asset::where('status', 'available')->orderBy('name')->get();
        return view('tickets.show', compact('ticket', 'supportUsers', 'availableAssets'));
    }

    public function assign(Request $request, Ticket $ticket)
    {
        if (Auth::user()->role !== 'admin') abort(403, 'Unauthorized action.');

        $request->validate([
            'assigned_to' => 'required|array',
            'assigned_to.*' => 'exists:users,id',
        ]);

        // Sync attaches an array of IDs to the pivot table
        $ticket->assignees()->sync($request->assigned_to);
        $ticket->status = 'in_progress';
        $ticket->save();

        return redirect()->route('tickets.show', $ticket)->with('success', 'درخواست با موفقیت به کارشناسان ارجاع داده شد.');
    }

    public function complete(Ticket $ticket)
    {
        if (!$ticket->assignees->contains(Auth::id()) && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $ticket->status = 'completed';
        $ticket->save();

        return redirect()->route('tickets.show', $ticket)->with('success', 'درخواست با موفقیت تکمیل شد.');
    }

    public function rate(Request $request, Ticket $ticket)
    {
        if (Auth::id() !== $ticket->user_id || $ticket->status !== 'completed') abort(403);

        $request->validate(['rating' => ['required', 'integer', 'min:1', 'max:5']]);
        $ticket->rating = $request->rating;
        $ticket->save();

        return redirect()->route('tickets.show', $ticket)->with('success', 'امتیاز شما با موفقیت ثبت شد.');
    }

    public function allocateAsset(Request $request, Ticket $ticket)
    {
        if (Auth::user()->role !== 'admin' && !$ticket->assignees->contains(Auth::id())) abort(403);

        $request->validate(['asset_id' => 'required|exists:assets,id']);

        $asset = Asset::find($request->asset_id);
        if ($asset->status !== 'available') return back()->with('error', 'این قطعه در حال حاضر موجود نیست.');
        
        $ticket->allocatedAssets()->attach($asset->id);
        $asset->status = 'assigned';
        $asset->assigned_to = $ticket->user_id;
        $asset->save();

        return back()->with('success', 'قطعه با موفقیت تخصیص داده شد.');
    }
}