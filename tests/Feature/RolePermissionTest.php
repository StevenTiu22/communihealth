<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
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

    public function test_users_has_roles_trait(): void
    {

    }
}
