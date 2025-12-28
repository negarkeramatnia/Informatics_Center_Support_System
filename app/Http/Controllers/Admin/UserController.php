<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UserController extends Controller
{

    public function index(Request $request)
    {
    $query = User::query();

    // 1. Search by Name, Email, or Username
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('username', 'like', "%{$search}%")
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

    $users = $query->latest()->paginate(15)->withQueryString(); // Keep filters when clicking "Next Page"
    
    // Pass the list of departments to the view for the dropdown
    $departments = ['مدیریت', 'فناوری اطلاعات', 'منابع انسانی', 'مالی', 'حراست', 'خدمات مشترکین', 'فنی و مهندسی'];

    return view('admin.users.index', compact('users', 'departments'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'numeric', 'digits:11'],
            'department' => ['required', 'string', 'max:255'],
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

        return redirect()->route('admin.users.index')->with('success', 'کاربر با موفقیت ایجاد شد.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'numeric', 'digits:11'],
            'department' => ['required', 'string', 'max:255'],
            'role' => ['required', 'in:user,support,admin'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $userData = $request->except('password');
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('admin.users.index')->with('success', 'اطلاعات کاربر با موفقیت ویرایش شد.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            return back()->with('error', 'شما نمی‌توانید حساب کاربری خود را حذف کنید.');
        }
        
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'کاربر با موفقیت حذف شد.');
    }
}