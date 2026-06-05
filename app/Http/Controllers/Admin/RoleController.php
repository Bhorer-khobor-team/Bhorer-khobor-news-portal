<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::where('guard_name', 'admin')->with('permissions')->get();
        return view('admin.roles.index', compact('roles'));
    }


    public function create()
    {
        // Group permissions by module — 'news' groups: news.create, news.edit, news.delete
        // explode('.', 'news.create')[0] = 'news'
        $permissions = Permission::where('guard_name', 'admin')
            ->get()
            ->groupBy(fn($p) => explode('.', $p->name)[0]);


        return view('admin.roles.create', compact('permissions'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|unique:roles,name',
            'permissions' => 'nullable|array',
        ]);


        $role = Role::create(['name' => $validated['name'], 'guard_name' => 'admin']);


        if (!empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }


        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully.');
    }


    public function edit(Role $role)
    {
        $permissions     = Permission::where('guard_name', 'admin')
            ->get()->groupBy(fn($p) => explode('.', $p->name)[0]);
        // Array of permission names the role currently has
        $rolePermissions = $role->permissions->pluck('name')->toArray();


        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }


    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name'        => 'required|string|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
        ]);


        $role->update(['name' => $validated['name']]);
        // syncPermissions removes old ones and adds new ones atomically
        $role->syncPermissions($validated['permissions'] ?? []);


        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully.');
    }


    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}

