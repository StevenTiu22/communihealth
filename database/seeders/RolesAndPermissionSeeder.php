<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionSeeder extends Seeder
{
    protected array $rolePermissions = [
        'barangay-official' => [
            'view-users',
            'create-users',
            'update-users',
            'delete-users',
            'view-patients',
            'view-health-record',
            'view-appointments',
            'view-medicines',
            'view-medicine-transactions',
            'view-tb-predictions',
            'view-audit-logs',
        ],
        'bhw' => [
            'view-users',
            'view-patients',
            'create-patients',
            'update-patients',
            'delete-patients',
            'view-health-record',
            'view-appointments',
            'create-appointments',
            'update-appointments',
            'delete-appointments',
            'view-medicines',
            'create-medicines',
            'update-medicines',
            'delete-medicines',
            'view-medicine-transactions',
            'create-medicine-transactions',
            'update-medicine-transactions',
            'delete-medicine-transactions',
            'view-tb-predictions',
        ],
        'doctor' => [
            'view-users',
            'view-patients',
            'view-health-record',
            'create-health-record',
            'update-health-record',
            'delete-health-record',
            'view-appointments',
            'view-medicines',
            'view-medicine-transactions',
            'view-tb-predictions',
        ],
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->rolePermissions as $role => $permissions) {
            $role = Role::create(['name' => $role, 'guard_name' => 'web']);
            foreach ($permissions as $permission) {
                $permission = Permission::findOrCreate($permission, 'web');
                $role->givePermissionTo($permission);
            }
        }
    }
}
