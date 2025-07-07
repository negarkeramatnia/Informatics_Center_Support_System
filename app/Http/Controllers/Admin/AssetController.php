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
        $assets = Asset::with('assignedTo')->latest()->paginate(15);
        return view('admin.assets.index', compact('assets'));
    }
    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('admin.assets.create', compact('users'));
    }

    /**
     * Store a newly created asset in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'asset_tag' => 'required|string|max:255|unique:assets,asset_tag',
            'status' => 'required|in:available,assigned,in_repair,decommissioned',
            'assigned_to_user_id' => 'nullable|exists:users,id',
        ]);

        Asset::create($request->all());

        return redirect()->route('admin.assets.index')->with('success', 'قطعه با موفقیت ثبت شد.');
    }

    /**
     * Show the form for editing the specified asset.
     */
    public function edit(Asset $asset)
    {
        $users = User::orderBy('name')->get();
        return view('admin.assets.edit', compact('asset', 'users'));
    }

    /**
     * Update the specified asset in storage.
     */
    public function update(Request $request, Asset $asset)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'asset_tag' => 'required|string|max:255|unique:assets,asset_tag,' . $asset->id,
            'status' => 'required|in:available,assigned,in_repair,decommissioned',
            'assigned_to_user_id' => 'nullable|exists:users,id',
        ]);
        
        // If status is not 'assigned', un-assign the user.
        $userData = $request->all();
        if ($request->status !== 'assigned') {
            $userData['assigned_to_user_id'] = null;
        }

        $asset->update($userData);

        return redirect()->route('admin.assets.index')->with('success', 'قطعه با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified asset from storage.
     */
    public function destroy(Asset $asset)
    {
        $asset->delete();
        return redirect()->route('admin.assets.index')->with('success', 'قطعه با موفقیت حذف شد.');
    }
}
