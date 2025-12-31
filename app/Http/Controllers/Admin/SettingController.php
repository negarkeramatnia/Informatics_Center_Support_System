<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // Fetch existing settings or default to empty
        $departments = Setting::find('departments')->value ?? '';
        $categories = Setting::find('ticket_categories')->value ?? '';

        return view('admin.settings.index', compact('departments', 'categories'));
    }

    public function store(Request $request)
    {
        // Save Departments
        Setting::updateOrCreate(
            ['key' => 'departments'],
            ['value' => $request->departments]
        );

        // Save Categories
        Setting::updateOrCreate(
            ['key' => 'ticket_categories'],
            ['value' => $request->ticket_categories]
        );

        return redirect()->back()->with('success', 'تنظیمات سیستم با موفقیت بروزرسانی شد.');
    }
}