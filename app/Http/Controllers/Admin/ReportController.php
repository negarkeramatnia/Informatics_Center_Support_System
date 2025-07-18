<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // --- 1. Number of Requests ---
        $totalTickets = Ticket::count();
        $pendingTickets = Ticket::where('status', 'pending')->count();
        $completedTickets = Ticket::where('status', 'completed')->count();

        // --- 2. User Satisfaction ---
        $averageRating = Ticket::whereNotNull('rating')->avg('rating');

        // --- 3. Response Time (Advanced Calculation) ---
        // This calculates the average time in hours from ticket creation to completion.
        $avgResolutionTimeHours = Ticket::where('status', 'completed')
            ->select(DB::raw('AVG(TIMESTAMPDIFF(SECOND, created_at, updated_at)) as avg_seconds'))
            ->value('avg_seconds');

        $avgResolutionTime = $avgResolutionTimeHours ? number_format($avgResolutionTimeHours / 3600, 2) . ' ساعت' : 'N/A';
        
        // --- 4. Performance by Support Staff ---
        $supportPerformance = User::where('role', 'support')
            ->withCount(['assignedTickets as completed_tickets_count' => function ($query) {
                $query->where('status', 'completed');
            }])
            ->withAvg(['assignedTickets as average_rating' => function ($query) {
                $query->whereNotNull('rating');
            }], 'rating')
            ->get();


        return view('admin.reports.index', compact(
            'totalTickets',
            'pendingTickets',
            'completedTickets',
            'averageRating',
            'avgResolutionTime',
            'supportPerformance'
        ));
    }
}
