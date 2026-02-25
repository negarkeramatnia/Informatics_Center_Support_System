<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // Fetch your existing settings from the database
        $departments = Setting::where('key', 'departments')->value('value');
        $ticketCategories = Setting::where('key', 'ticket_categories')->value('value');
    
        // Pass them to the view so the textareas can pre-fill
        return view('admin.settings.index', compact('departments', 'ticketCategories'));
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