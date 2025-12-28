<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\User;
use Illuminate\Http\Request;

class AssetController extends Controller
{
public function index(Request $request)
{
    $query = Asset::with('assignedToUser');

    // 1. Search Logic (Matches what you type in the box)
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")             // Search Name
              ->orWhere('serial_number', 'like', "%{$search}%")  // Search Serial
              ->orWhere('ip_address', 'like', "%{$search}%")     // Search IP
              ->orWhere('location', 'like', "%{$search}%");      // Search Location (Department)
        });
    }

    // 2. Filter by Location (If you use the dropdown)
    if ($request->filled('location')) {
        $query->where('location', $request->location);
    }

    // 3. Filter by Status (If you use the dropdown)
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $assets = $query->latest()->paginate(15)->withQueryString();
    
    // Required for the Location Dropdown to appear in the view
    $locations = ['مدیریت', 'فناوری اطلاعات', 'منابع انسانی', 'مالی', 'حراست', 'خدمات مشترکین', 'فنی و مهندسی'];

    return view('admin.assets.index', compact('assets', 'locations'));
}

    // ... (Keep the rest of your Create, Store, Edit, Update, Destroy methods exactly as they were in the previous fix) ...
    // Note: Ensure getValidationRules includes 'location' => 'nullable|string'
    
    public function create() { /* ... */ return view('admin.assets.create', compact('users')); }
    public function store(Request $request) { 
        // ... use getValidationRules() ... 
        Asset::create($request->validate($this->getValidationRules()));
        return redirect()->route('admin.assets.index')->with('success', 'دستگاه ثبت شد.');
    }
    public function edit(Asset $asset) { /* ... */ return view('admin.assets.edit', compact('asset', 'users')); }
    public function update(Request $request, Asset $asset) {
        // ... use getValidationRules($asset->id) ...
        $asset->update($request->validate($this->getValidationRules($asset->id)));
        return redirect()->route('admin.assets.index')->with('success', 'ویرایش شد.');
    }
    public function destroy(Asset $asset) { $asset->delete(); return back(); }

    protected function getValidationRules($assetId = null): array
    {
        $serialRule = 'required|string|max:255|unique:assets,serial_number';
        if ($assetId) { $serialRule .= ',' . $assetId; }

        return [
            'name' => 'required|string|max:255',
            'ip_address' => 'nullable|ip',
            'description' => 'nullable|string',
            'serial_number' => $serialRule,
            'status' => 'required|in:available,assigned,under_maintenance,decommissioned',
            'assigned_to' => 'nullable|exists:users,id',
            'location' => 'nullable|string|max:255', // <--- Don't forget this!
            'hardware_details' => 'nullable|json',
            'software_details' => 'nullable|json',
        ];
    }
}