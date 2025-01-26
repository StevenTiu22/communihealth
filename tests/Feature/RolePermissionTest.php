<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RolePermissionTest extends TestCase
{
    use RefreshDatabase;

    protected array $roles = [
        'barangay-official',
        'bhw',
        'doctor'
    ];
    protected array $permissions = [
        'view-users',
        'create-users',
        'update-users',
        'delete-users',
        'view-patients',
        'create-patients',
        'update-patients',
        'delete-patients',
        'view-health-record',
        'create-health-record',
        'update-health-record',
        'delete-health-record',
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
        'view-audit-logs',
    ];

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

    public function test_roles_table_has_expected_roles(): void
    {
        if ($this->assertDatabaseCount('roles', count($this->roles)))
            $this->assertTrue(true);
        else
            $this->fail('Table roles should have ' . count($this->roles) . ' records.');

        foreach ($this->roles as $role) {
            if ($this->assertDatabaseHas('roles', ['name' => $role])) {
                $this->assertTrue(true);
            } else {
                $this->fail("Table 'roles' should have a '$role' record.");
            }
        }
    }

    public function test_permissions_table_has_expected_permissions(): void
    {
        if ($this->assertDatabaseCount('permissions', count($this->permissions)))
            $this->assertTrue(true);
        else
            $this->fail('Table permissions should have ' . count($this->permissions) . ' records.');

        foreach ($this->permissions as $permission) {
            if ($this->assertDatabaseHas('permissions', ['name' => $permission]))
                $this->assertTrue(true);
            else
                $this->fail("Table 'permissions' should have a '$permission' record.");
        }
    }

    public function test_roles_have_expected_permissions(): void
    {
        foreach ($this->rolePermissions as $role => $permissions) {
            $role = Role::findByName($role);
            $this->assertNotNull($role, "Role '$role' should exist.");

            foreach ($permissions as $permission) {
                $this->assertTrue($role->hasPermissionTo($permission), "Role '$role' should have permission '$permission'.");
            }
        }
    }


    public function test_users_can_be_assigned_to_a_role(): void
    {
        $user = User::factory()->create();

        $role = Role::class::firstOrCreate(['name' => 'barangay-official']);

        $user->syncRole($role);

        $this->assertTrue($user->hasRole('barangay-official'), 'User should have a role of barangay-official.');
        $this->assertCount(1, $user->roles, 'User should have only one role.');
        $this->assertEquals('barangay-official', $user->roles->first()->name, 'User\'s role should be barangay-official.');
    }

    public function test_users_can_only_have_one_role(): void
    {
        $user = User::factory()->create();

        $BORole = Role::class::firstOrCreate(['name' => 'barangay-official']);
        $BHWRole = Role::class::firstOrCreate(['name' => 'bhw']);

        $user->syncRole($BORole);

        $this->assertTrue($user->hasRole('barangay-official'), 'User should have a role of barangay-official.');

        $this->syncRole($BHWRole);

        $this->assertTrue($user->hasRole('bhw'), 'User should have a role of bhw.');
        $this->assertFalse($user->hasRole('barangay-official'), 'User should not have a role of barangay-official, instead have a role of bhw.');
        $this->assertCount(1, $user->roles, 'User should have only one role.');
    }
}
