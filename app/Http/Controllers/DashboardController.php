<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Asset;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $viewData = [];

        if ($user->role === 'user') {
            $viewData['employeeData'] = [
                'open_tickets_count' => $user->tickets()->whereIn('status', ['pending', 'in_progress'])->count(),
                'resolved_tickets_count' => $user->tickets()->where('status', 'completed')->count(),
                'recent_tickets' => $user->tickets()->latest()->take(5)->get(),
                'assigned_assets_count' => $user->assets()->count(),
                'userAssets' => $user->assets()->get(), // This fetches the assets for the view
            ];
        } 
        elseif ($user->role === 'support') {
            $myTickets = Ticket::where('assigned_to', $user->id);
            $myActiveTickets = (clone $myTickets)->whereIn('status', ['pending', 'in_progress']);

            $viewData['supportData'] = [
                'my_active_tickets_count' => $myActiveTickets->count(),
                'high_priority_count' => (clone $myActiveTickets)->where('priority', 'high')->count(),
                'completed_last_week' => (clone $myTickets)->where('status', 'completed')
                                             ->where('updated_at', '>=', Carbon::now()->subWeek())
                                             ->count(),
                'avg_response_time' => 'N/A', // Placeholder for now
                'my_active_tickets_list' => (clone $myActiveTickets)->with('user:id,name')->latest('updated_at')->take(10)->get(),
            ];
        } 
        elseif ($user->role === 'admin') {
            $viewData['adminData'] = [
                'total_users' => User::count(),
                'total_open_tickets' => Ticket::whereIn('status', ['pending', 'in_progress'])->count(),
                'total_assets' => Asset::count(),
                'unassigned_tickets' => Ticket::whereNull('assigned_to')->where('status', 'pending')->count(),
                'recent_unassigned_tickets' => Ticket::with('user:id,name')
                                                ->whereNull('assigned_to')
                                                ->where('status', 'pending')
                                                ->latest()
                                                ->take(5)
                                                ->get(),
            ];
        }

        // This single view will now handle displaying the correct partial
        return view('dashboard', $viewData);
    }
}