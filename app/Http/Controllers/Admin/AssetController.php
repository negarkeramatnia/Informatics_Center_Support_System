<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::with('assignedTo')->latest()->paginate(15);
        return view('admin.assets.index', compact('assets'));
    }
}
