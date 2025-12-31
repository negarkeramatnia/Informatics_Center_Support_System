<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PhonebookController extends Controller
{
    /**
     * Display the company phonebook.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Simple search for Name, Phone, or Department
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Order by Name and paginate
        $users = $query->orderBy('name')->paginate(20)->withQueryString();

        return view('phonebook.index', compact('users'));
    }
}