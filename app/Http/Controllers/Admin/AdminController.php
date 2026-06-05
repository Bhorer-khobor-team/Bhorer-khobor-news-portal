<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;


class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::with('roles')->latest()->paginate(20);
        return view('admin.admins.index', compact('admins'));
    }


    public function create()
    {
        // Only show roles for the admin guard
        $roles = Role::where('guard_name', 'admin')->get();
        return view('admin.admins.create', compact('roles'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:admins,email',
            'phone'     => 'nullable|string|max:20',
            'password'  => 'required|min:8|confirmed',
            'role'      => 'required|exists:roles,name',
            'is_locked' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);


        $admin = Admin::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'phone'     => $validated['phone'] ?? null,
            'password'  => Hash::make($validated['password']), // always hash
            'is_locked' => $request->boolean('is_locked'),
            'is_active' => $request->boolean('is_active', true),
        ]);


        // Assign the selected role
        $admin->assignRole($validated['role']);


        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin created successfully.');
    }


    public function edit(Admin $admin)
    {
        $roles       = Role::where('guard_name', 'admin')->get();
        $currentRole = $admin->roles->first()?->name; // current role name
        return view('admin.admins.edit', compact('admin', 'roles', 'currentRole'));
    }


    public function update(Request $request, Admin $admin)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:admins,email,' . $admin->id,
            'phone'     => 'nullable|string|max:20',
            'password'  => 'nullable|min:8|confirmed', // optional on edit
            'role'      => 'required|exists:roles,name',
            'is_locked' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);


        $data = [
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'phone'     => $validated['phone'] ?? null,
            'is_locked' => $request->boolean('is_locked'),
            'is_active' => $request->boolean('is_active', true),
        ];


        // Only update password if a new one was provided
        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }


        $admin->update($data);
        $admin->syncRoles([$validated['role']]); // replaces old role


        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin updated successfully.');
    }


    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin deleted successfully.');
    }
}

