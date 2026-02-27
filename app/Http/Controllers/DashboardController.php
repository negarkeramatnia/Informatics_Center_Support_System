<?php

namespace App\Http\Controllers;

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
                'assigned_assets_count' => $user->assets()->count(),
                'userAssets' => $user->assets()->get(),
            ];
            // Added $tickets here so the table in dashboard.user.blade.php has data to loop through!
            $viewData['tickets'] = $user->tickets()->latest()->take(5)->get();
        } 
elseif ($user->role === 'support') {
            // Your excellent pivot table logic
            $myTickets = Ticket::whereHas('assignees', function($query) use ($user) {
                $query->where('users.id', $user->id);
            });
            $myActiveTickets = (clone $myTickets)->whereIn('status', ['pending', 'in_progress']);
            
            // --- THE NEW AVERAGE RESPONSE TIME CALCULATOR ---
            $completedTickets = (clone $myTickets)->where('status', 'completed')->get();
            
            if ($completedTickets->isEmpty()) {
                $avgResponseTime = 'N/A';
            } else {
                // Calculate the average difference between creation and completion in minutes
                $avgMinutes = $completedTickets->avg(function ($ticket) {
                    return $ticket->created_at->diffInMinutes($ticket->updated_at);
                });

                // Format the output dynamically
                if ($avgMinutes < 60) {
                    $avgResponseTime = round($avgMinutes) . ' دقیقه';
                } elseif ($avgMinutes < 1440) {
                    $avgResponseTime = round($avgMinutes / 60) . ' ساعت';
                } else {
                    $avgResponseTime = round($avgMinutes / 1440, 1) . ' روز';
                }
            }
            // ------------------------------------------------
            
            $viewData['supportData'] = [
                'active_tickets' => $myActiveTickets->count(),
                'high_priority' => (clone $myActiveTickets)->where('priority', 'high')->count(),
                'completed_recent' => (clone $myTickets)->where('status', 'completed')
                                                        ->where('updated_at', '>=', Carbon::now()->subWeek())
                                                        ->count(),
                
                // Replace the hardcoded 'N/A' with our dynamic variable
                'avg_response_time' => $avgResponseTime,
                
                'my_active_tickets_list' => (clone $myActiveTickets)->with('user:id,name')->latest('updated_at')->take(10)->get(),
            ];
            
            $viewData['tickets'] = (clone $myTickets)->latest()->take(5)->get();
        }
        elseif ($user->role === 'admin') {
            $viewData['adminData'] = [
                'total_users' => User::count(),
                'total_open_tickets' => Ticket::whereIn('status', ['pending', 'in_progress'])->count(),
                'total_assets' => Asset::count(),
                // Your excellent pivot table logic kept intact
                'unassigned_tickets' => Ticket::whereDoesntHave('assignees')->where('status', 'pending')->count(),
                'recent_unassigned_tickets' => Ticket::with('user:id,name')
                                                ->whereDoesntHave('assignees')
                                                ->where('status', 'pending')
                                                ->latest()
                                                ->take(5)
                                                ->get(),
            ];
            // Admin sees all recent tickets
            $viewData['tickets'] = Ticket::latest()->take(5)->get();
        }

        return view('dashboard', $viewData);
    }
}