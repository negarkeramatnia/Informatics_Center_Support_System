<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\User;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::with('assignedToUser')->latest()->paginate(15);
        return view('admin.assets.index', compact('assets'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('admin.assets.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->getValidationRules());

        // Decode JSON strings before creation
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

        // Decode JSON strings before updating
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
            'assigned_to' => 'nullable|exists:users,id',
            'hardware_details' => 'nullable|json',
            'software_details' => 'nullable|json',
        ];
    }
}
