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

    //used for store() and update()
    protected function getValidationRules($assetId = null): array
    {
        $serialRule = 'required|string|max:255|unique:assets,serial_number';
        if ($assetId) {
            $serialRule .= ',' . $assetId;
        }

        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'serial_number' => $serialRule,
            'purchase_date' => 'nullable|date',
            'warranty_expiration' => 'nullable|date',
            'status' => 'required|in:available,assigned,under_maintenance,expired',
            'location' => 'nullable|string|max:255',
            'assigned_to' => 'nullable|exists:users,id',
        ];
    }
}