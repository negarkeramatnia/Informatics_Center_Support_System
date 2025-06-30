<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Asset;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $viewData = [];

        if ($user->role === 'user') {
            $viewData['employeeData'] = [
                'open_tickets_count' => $user->createdTickets()->whereIn('status', ['pending', 'in_progress'])->count(),
                'resolved_tickets_count' => $user->createdTickets()->where('status', 'completed')->count(),
                'recent_tickets' => $user->createdTickets()->latest()->take(5)->get(),
                'assigned_assets_count' => $user->assets()->count(),
            ];
        } 
        elseif ($user->role === 'support') {
            $viewData['supportData'] = [
                'new_tickets_count' => Ticket::where('status', 'pending')->count(),
                'assigned_to_me_count' => Ticket::where('assigned_to', $user->id)->whereIn('status', ['pending', 'in_progress'])->count(),
                'resolved_today_count' => Ticket::where('status', 'completed')->whereDate('updated_at', today())->count(),
                'new_high_priority_tickets' => Ticket::with('user:id,name')->where('status', 'pending')->where('priority', 'high')->latest()->take(5)->get(),
            ];
        } 
        elseif ($user->role === 'admin') {
            $viewData['adminData'] = [
                'total_users' => User::count(),
                'total_open_tickets' => Ticket::whereIn('status', ['pending', 'in_progress'])->count(),
                'total_assets' => Asset::count(),
            ];
        }

        return view('dashboard', $viewData);
    }
}