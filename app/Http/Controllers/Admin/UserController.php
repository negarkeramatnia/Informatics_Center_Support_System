<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /*Display a listing of the users.*/
    public function index(Request $request)
    {
        $query = User::query();

        // 1. Search Logic (Name, Username, Email, Phone)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // 2. Filter by Department
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        // 3. Filter by Role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        // Feature 8: Get Departments from Database Settings
        $departments = Setting::getList('departments');

        // Ensure we return the 'index' view, not 'create'
        return view('admin.users.index', compact('users', 'departments'));
    }

    /*Show the form for creating a new user.*/
    public function create()
    {
        // Feature 8: Get Departments from Database Settings
        $departments = Setting::getList('departments');
        return view('admin.users.create', compact('departments'));
    }

    /*Store a newly created user in storage.*/
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'department' => ['nullable', 'string'],
            'role' => ['required', 'in:user,support,admin'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'department' => $request->department,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'کاربر جدید با موفقیت ایجاد شد.');
    }

    /* Show the form for editing the specified user.*/
    public function edit(User $user)
    {
        // Feature 8: Get Departments from Database Settings
        $departments = Setting::getList('departments');
        return view('admin.users.edit', compact('user', 'departments'));
    }

    /* Update the specified user in storage.*/
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'department' => ['nullable', 'string'],
            'role' => ['required', 'in:user,support,admin'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'department' => $request->department,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'اطلاعات کاربر بروزرسانی شد.');
    }

    /*** Remove the specified user from storage.*/
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'شما نمی‌توانید حساب خودتان را حذف کنید.');
        }
        
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'کاربر با موفقیت حذف شد.');
    }
}