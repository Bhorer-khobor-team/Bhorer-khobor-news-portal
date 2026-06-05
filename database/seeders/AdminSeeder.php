<?php


namespace Database\Seeders;


use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // ── Step 1: Create 16 permissions ─────────────────────────────
        $permissions = [
            'news.create',          'news.edit',          'news.delete',
            'category.create',      'category.edit',      'category.delete',
            'advertisement.create', 'advertisement.edit', 'advertisement.delete',
            'role.create',          'role.edit',          'role.delete',
            'admin.create',         'admin.edit',         'admin.delete',
            'pages.create',
        ];


        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name'       => $permission,
                'guard_name' => 'admin', // must match config/permission.php
            ]);
        }


        // ── Step 2: Create roles and assign permissions ────────────────


        // Super Admin: all 16 permissions
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'admin']);
        $superAdmin->syncPermissions($permissions);


        // Editor: 7 permissions — news, category, pages only
        $editor = Role::firstOrCreate(['name' => 'Editor', 'guard_name' => 'admin']);
        $editor->syncPermissions([
            'news.create', 'news.edit', 'news.delete',
            'category.create', 'category.edit', 'category.delete',
            'pages.create',
        ]);


        // Viewer: no permissions — read-only access
        Role::firstOrCreate(['name' => 'Viewer', 'guard_name' => 'admin']);


        // ── Step 3: Create the Super Admin account ─────────────────────
        $admin = Admin::firstOrCreate(
            ['email' => 'admin@bhorerkhobor.com'],
            [
                'name'      => 'Super Admin',
                'password'  => Hash::make('Admin@1234'),
                'is_active' => true,
                'is_locked' => false,
            ]
        );
        $admin->assignRole('Super Admin');
    }
}

