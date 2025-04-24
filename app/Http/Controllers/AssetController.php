<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index()
    {
        return Asset::with('user')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'serial_number' => 'required|string|unique:assets,serial_number',
            'purchase_date' => 'nullable|date',
            'warranty_expiration' => 'nullable|date|after_or_equal:purchase_date',
            'status' => 'required|in:available,assigned,under_maintenance,expired',
            'location' => 'nullable|string|max:255',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $asset = Asset::create($validated);

        return response()->json($asset, 201);
    }

    public function show(Asset $asset)
    {
        return $asset->load('user');
    }

    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'serial_number' => 'sometimes|required|string|unique:assets,serial_number,' . $asset->id,
            'purchase_date' => 'nullable|date',
            'warranty_expiration' => 'nullable|date|after_or_equal:purchase_date',
            'status' => 'required|in:available,assigned,under_maintenance,expired',
            'location' => 'nullable|string|max:255',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $asset->update($validated);

        return response()->json($asset);
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();

        return response()->json(null, 204);
    }
}