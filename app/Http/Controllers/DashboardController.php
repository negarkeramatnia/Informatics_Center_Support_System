<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Asset;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $props = [];

        if ($user->role === 'user') {
            $props['employeeData'] = [
                'open_tickets_count' => $user->createdTickets()->whereIn('status', ['pending', 'in_progress'])->count(),
                'resolved_tickets_count' => $user->createdTickets()->where('status', 'completed')->count(),
                'recent_tickets' => $user->createdTickets()->latest()->take(5)->get(),
            ];
        } 
        elseif ($user->role === 'support') {
            $props['supportData'] = [
                'new_tickets' => Ticket::with('user:id,name')
                                    ->where('status', 'pending')
                                    ->latest()
                                    ->take(10)
                                    ->get(),
                'assigned_to_me_count' => Ticket::where('assigned_to', $user->id)
                                                ->whereIn('status', ['pending', 'in_progress'])
                                                ->count(),
            ];
        } 
        elseif ($user->role === 'admin') {
            $props['adminData'] = [
                'stats' => [
                    'total_users' => User::count(),
                    'total_open_tickets' => Ticket::whereIn('status', ['pending', 'in_progress'])->count(),
                    'total_assets' => Asset::count(),
                ],
                'quick_actions' => [
                    ['name' => 'مدیریت درخواست‌ها', 'href' => url('/admin/tickets'), 'icon' => 'fa-tasks'],
                    ['name' => 'مدیریت کاربران', 'href' => url('/admin/users'), 'icon' => 'fa-users-cog'],
                    ['name' => 'مدیریت قطعات', 'href' => url('/admin/assets'), 'icon' => 'fa-hdd'],
                    ['name' => 'گزارشات سیستم', 'href' => url('/admin/reports'), 'icon' => 'fa-chart-line'],
                ]
            ];
        }

        // Return the Inertia response, rendering the 'Dashboard' component with the prepared props
        return Inertia::render('Dashboard', $props);
    }
}