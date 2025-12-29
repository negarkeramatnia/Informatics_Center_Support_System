<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $totalTickets = Ticket::count();
        $pendingTickets = Ticket::where('status', 'pending')->count();
        $completedTickets = Ticket::where('status', 'completed')->count();
        $averageRating = Ticket::whereNotNull('rating')->avg('rating');

        $avgResolutionTimeHours = Ticket::where('status', 'completed')
            ->select(DB::raw('AVG(TIMESTAMPDIFF(SECOND, created_at, updated_at)) as avg_seconds'))
            ->value('avg_seconds');
        $avgResolutionTime = $avgResolutionTimeHours ? number_format($avgResolutionTimeHours / 3600, 2) . ' ساعت' : 'N/A';
        
        $supportPerformance = User::where('role', 'support')
            ->withCount(['assignedTickets as completed_tickets_count' => function ($query) {
                $query->where('status', 'completed');
            }])
            ->withAvg(['assignedTickets as average_rating' => function ($query) {
                $query->whereNotNull('rating');
            }], 'rating')
            ->get();

        // --- CHART DATA PREPARATION ---

        // 1. Tickets by Category (Pie Chart)
        $ticketsByCategory = Ticket::select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->pluck('total', 'category')
            ->all();
            
        // Ensure all categories have a value, even if 0
        $allCategories = ['software', 'hardware', 'network', 'access_control', 'other'];
        $categoryCounts = [];
        foreach ($allCategories as $cat) {
            $categoryCounts[] = $ticketsByCategory[$cat] ?? 0;
        }

        // 2. Assets by Location/Department (Bar Chart)
        // This uses the "Feature 6" data you just built
        $assetsByLocation = Asset::select('location', DB::raw('count(*) as total'))
            ->whereNotNull('location')
            ->groupBy('location')
            ->pluck('total', 'location');

        $locationLabels = $assetsByLocation->keys()->toArray();
        $locationCounts = $assetsByLocation->values()->toArray();

        return view('admin.reports.index', compact(
            'totalTickets',
            'pendingTickets',
            'completedTickets',
            'averageRating',
            'avgResolutionTime',
            'supportPerformance',
            'categoryCounts',
            'locationLabels',
            'locationCounts'
        ));
    }

public function details(Request $request)
    {
        $query = Ticket::with('user'); 

        $title = 'لیست درخواست‌ها';

        // 1. Filter by Category (Chart)
        if ($request->filled('category')) {
            $query->where('category', $request->category);
            $title = 'درخواست‌های مربوط به: ' . __($request->category);
        }

        // 2. Filter by Support Agent (Table)
        if ($request->filled('support_id')) {
            $query->where('assigned_to', $request->support_id)->where('status', 'completed');
            $agentName = User::find($request->support_id)->name ?? 'ناشناس';
            $title = 'درخواست‌های تکمیل شده توسط: ' . $agentName;
        }

        // 3. Filter by Location (Chart)
        if ($request->filled('location')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('department', $request->location);
            });
            $title = 'درخواست‌های ثبت شده از واحد: ' . $request->location;
        }

        // 4. Filter by Status (For Top Cards)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
            $title = 'درخواست‌های با وضعیت: ' . __($request->status);
        }

        // 5. Filter by Rated Only (For Rating Card)
        if ($request->has('rated_only')) {
            $query->whereNotNull('rating');
            $title = 'درخواست‌های دارای امتیاز نظرسنجی';
        }

        $tickets = $query->latest()->paginate(20)->withQueryString();

        return view('admin.reports.details', compact('tickets', 'title'));
    }
}