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

        // 1. General Search (Text Box)
        // Searches Name, Serial, IP, AND Location
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // 2. Filter by Location (Dropdown)
        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        // 3. Filter by Status (Dropdown)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $assets = $query->latest()->paginate(15)->withQueryString();

        // DATA FOR THE DROPDOWN (Matches User Departments)
        $locations = ['مدیریت', 'فناوری اطلاعات', 'منابع انسانی', 'مالی', 'حراست', 'خدمات مشترکین', 'فنی و مهندسی'];

        return view('admin.assets.index', compact('assets', 'locations'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('admin.assets.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->getValidationRules());
        // JSON fields removed as they are not in your form, but keeping code safe
        $validated['hardware_details'] = json_decode($validated['hardware_details'] ?? '[]', true);
        $validated['software_details'] = json_decode($validated['software_details'] ?? '[]', true);

        Asset::create($validated);
        return redirect()->route('admin.assets.index')->with('success', 'دستگاه با موفقیت ثبت شد.');
    }

    public function edit(Asset $asset)
    {
        $users = User::orderBy('name')->get();
        return view('admin.assets.edit', compact('asset', 'users'));
    }

    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate($this->getValidationRules($asset->id));
        $validated['hardware_details'] = json_decode($validated['hardware_details'] ?? '[]', true);
        $validated['software_details'] = json_decode($validated['software_details'] ?? '[]', true);
        
        if ($request->status !== 'assigned') {
            $validated['assigned_to'] = null;
        }

        $asset->update($validated);
        return redirect()->route('admin.assets.index')->with('success', 'دستگاه با موفقیت ویرایش شد.');
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();
        return redirect()->route('admin.assets.index')->with('success', 'دستگاه با موفقیت حذف شد.');
    }

    protected function getValidationRules($assetId = null): array
    {
        $serialRule = 'required|string|max:255|unique:assets,serial_number';
        if ($assetId) {
            $serialRule .= ',' . $assetId;
        }

        return [
            'name' => 'required|string|max:255',
            'ip_address' => 'nullable|ip',
            'description' => 'nullable|string',
            'serial_number' => $serialRule,
            'status' => 'required|in:available,assigned,under_maintenance,decommissioned',
            'location' => 'nullable|string|max:255',
            'assigned_to' => 'nullable|exists:users,id',
            'hardware_details' => 'nullable|json',
            'software_details' => 'nullable|json',
        ];
    }
}