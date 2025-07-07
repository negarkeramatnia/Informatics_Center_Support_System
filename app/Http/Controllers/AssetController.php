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
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'serial_number' => 'required|string|max:255|unique:assets,serial_number',
            'purchase_date' => 'nullable|date',
            'warranty_expiration' => 'nullable|date',
            'status' => 'required|in:available,assigned,under_maintenance,decommissioned',
            'location' => 'nullable|string|max:255',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        Asset::create($request->all());
        return redirect()->route('admin.assets.index')->with('success', 'قطعه با موفقیت ثبت شد.');
    }

    public function edit(Asset $asset)
    {
        $users = User::orderBy('name')->get();
        return view('admin.assets.edit', compact('asset', 'users'));
    }

    public function update(Request $request, Asset $asset)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'serial_number' => 'required|string|max:255|unique:assets,serial_number,' . $asset->id,
            'purchase_date' => 'nullable|date',
            'warranty_expiration' => 'nullable|date',
            'status' => 'required|in:available,assigned,under_maintenance,decommissioned',
            'location' => 'nullable|string|max:255',
            'assigned_to' => 'nullable|exists:users,id',
        ]);
        
        $data = $request->all();
        if ($request->status !== 'assigned') {
            $data['assigned_to'] = null;
        }

        $asset->update($data);
        return redirect()->route('admin.assets.index')->with('success', 'قطعه با موفقیت ویرایش شد.');
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();
        return redirect()->route('admin.assets.index')->with('success', 'قطعه با موفقیت حذف شد.');
    }
}
