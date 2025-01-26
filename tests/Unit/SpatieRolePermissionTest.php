<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SpatieRolePermissionTest extends TestCase
{
    public function test_system_have_spatie_migrations() : void
    {
        $this->assertFileExists(database_path('migrations/0001_01_01_000005_create_permission_tables.php'),
            'Migration file for spatie/permission package not found');
    }
    public function test_system_have_spatie_tables(): void
    {
        $this->assertTrue(Schema::hasTable('roles'), "Table 'roles' not found");
        $this->assertTrue(Schema::hasTable('permissions'), "Table 'permissions' not found");
        $this->assertTrue(Schema::hasTable('model_has_permissions'), "Table 'model_has_permissions' not found");
        $this->assertTrue(Schema::hasTable('model_has_roles'), 'Table model_has_roles not found');
        $this->assertTrue(Schema::hasTable('role_has_permissions'), 'Table role_has_permissions not found');
    }

    public function test_system_have_spatie_roles_and_permissions_classes() : void
    {
        $this->assertTrue(class_exists(\Spatie\Permission\Models\Role::class),
            'Spatie Role class not found');
        $this->assertTrue(class_exists(\Spatie\Permission\Models\Permission::class),
            'Spatie Permission class not found');
    }

    public function test_spatie_classes_should_have_correct_relationships(): void
    {
        $role = new \Spatie\Permission\Models\Role();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsToMany::class, $role->permissions(),
            '$role->permissions() should return BelongsToMany relationship');
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\MorphToMany::class, $role->users(),
            '$role->users() should return MorphToMany relationship');

        $permission = new \Spatie\Permission\Models\Permission();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsToMany::class, $permission->roles(),
            '$permission->roles() should return BelongsToMany relationship');
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\MorphToMany::class, $permission->users(),
            '$permission->users() should return MorphToMany relationship');
    }
}
