<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Number of Requests
        $totalTickets = Ticket::count();
        $pendingTickets = Ticket::where('status', 'pending')->count();
        $completedTickets = Ticket::where('status', 'completed')->count();
        $averageRating = Ticket::whereNotNull('rating')->avg('rating');

        // User Satisfaction
        $avgResolutionTimeHours = Ticket::where('status', 'completed')
        ->select(DB::raw('AVG(TIMESTAMPDIFF(SECOND, created_at, updated_at)) as avg_seconds'))
        ->value('avg_seconds');
        $avgResolutionTime = $avgResolutionTimeHours ? number_format($avgResolutionTimeHours / 3600, 2) . ' ساعت' : 'N/A';

        // Response Time
        $supportPerformance = User::where('role', 'support')
        ->withCount(['assignedTickets as completed_tickets_count' => function ($query) {
            $query->where('status', 'completed');
        }])
        ->withAvg(['assignedTickets as average_rating' => function ($query) {
            $query->whereNotNull('rating');
        }], 'rating')
        ->get();

        // Prepare Data for Charts 
        $ticketsByCategory = Ticket::select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->pluck('total', 'category')
            ->all();

        // Ensure all categories exist in the array even if count is 0
        $categories = ['software', 'hardware', 'network', 'access_control', 'other'];
        $chartData = [];
        foreach ($categories as $cat) {
            $chartData[] = $ticketsByCategory[$cat] ?? 0;
        }


        return view('admin.reports.index', compact(
            'totalTickets',
            'pendingTickets',
            'completedTickets',
            'averageRating',
            'avgResolutionTime',
            'supportPerformance',
            'chartData',
        ));
    }
}
