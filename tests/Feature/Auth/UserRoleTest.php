<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;

class UserRoleTest extends TestCase
{
    protected array $roles = [
        'barangay-official',
        'bhw',
        'doctor'
    ];

    public function setUp(): void
    {
        parent::setUp();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function test_newly_created_user_has_no_role(): void
    {
        $user = User::factory()->create();

        $this->assertCount(0, $user->roles, 'User should have no role.');
    }


    public function test_users_can_be_assigned_to_a_role(): void
    {
        $user = User::factory()->create();

        $role = $this->roles[0];

        $user->syncRoles($role);

        $this->assertTrue($user->hasRole($role), 'User should have a role of barangay-official.');
        $this->assertCount(1, $user->roles, 'User should have only one role.');
        $this->assertEquals($role, $user->roles->first()->name, 'User\'s role should be barangay-official.');
    }

    public function test_users_can_only_have_one_role(): void
    {
        $user = User::factory()->create();

        $BORole = $this->roles[0];
        $BHWRole = $this->roles[1];

        $user->syncRoles($BORole);

        $this->assertTrue($user->hasRole($BORole), 'User should have a role of barangay-official.');

        $user->syncRoles($BHWRole);

        $this->assertTrue($user->hasRole($BHWRole), 'User should have a role of bhw.');
        $this->assertFalse($user->hasRole($BORole), 'User should not have a role of barangay-official, instead have a role of bhw.');
        $this->assertCount(1, $user->roles, 'User should have only one role.');
    }

    public function test_barangay_official_can_access_designated_dashboard(): void
    {
        $user = User::factory()->create();
        $role = $this->roles[0];

        $user->syncRoles($role);

        $response = $this->actingAs($user)->get('/barangay-official/dashboard');

        $response->assertStatus(200)
            ->assertViewIs('dashboard.barangay-official')
            ->assertSee('Barangay Official Dashboard')
            ->assertViewHas('user', $user);
    }

    public function test_bhw_can_access_designated_dashboard(): void
    {
        $user = User::factory()->create();
        $role = $this->roles[1];

        $user->syncRoles($role);

        $response = $this->actingAs($user)->get('/bhw/dashboard');

        $response->assertStatus(200)
            ->assertViewIs('dashboard.bhw')
            ->assertSee('BHW Dashboard')
            ->assertViewHas('user', $user);
    }

    public function test_doctor_can_access_designated_dashboard(): void
    {
        $user = User::factory()->create();
        $role = $this->roles[2];

        $user->syncRoles($role);

        $response = $this->actingAs($user)->get('/doctor/dashboard');

        $response->assertStatus(200)
            ->assertViewIs('dashboard.doctor')
            ->assertSee('Doctor Dashboard')
            ->assertViewHas('user', $user);
    }

    public function test_users_without_a_role_cannot_access_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/barangay-official/dashboard');

        $response->assertForbidden();

        $response = $this->actingAs($user)->get('/bhw/dashboard');

        $response->assertForbidden();

        $response = $this->actingAs($user)->get('/doctor/dashboard');

        $response->assertForbidden();
    }

    public function test_barangay_officials_are_redirected_to_dashboard_after_login(): void
    {
        $user = User::factory()->withRole($this->roles[0])->create();

        $response = $this->actingAs($user)->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/barangay-official/dashboard');
    }

    public function test_bhw_are_redirected_to_dashboard_after_login(): void
    {
        $user = User::factory()->withRole($this->roles[1])->create();

        $response = $this->actingAs($user)->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/bhw/dashboard');
    }

    public function test_doctors_are_redirected_to_dashboard_after_login(): void
    {
        $user = User::factory()->withRole($this->roles[2])->create();

        $response = $this->actingAs($user)->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/doctor/dashboard');
    }

    public function test_barangay_officials_can_access_user_management(): void
    {
        $user = User::factory()->withRole($this->roles[0])->create();

        $response = $this->actingAs($user)->get('/barangay-official/users');

        $response->assertStatus(200)
            ->assertViewIs('barangay-official.user-accounts')
            ->assertSee('User Accounts');
    }

    public function test_barangay_officials_can_access_audit_trail(): void
    {
        $user = User::factory()->withRole($this->roles[0])->create();

        $response = $this->actingAs($user)->get('/barangay-official/audit-trail');

        $response->assertStatus(200)
            ->assertViewIs('barangay-official.audit-trail')
            ->assertSee('Audit Trail');
    }

    public function test_barangay_officials_can_access_patient_records(): void
    {
        $user = User::factory()->withRole($this->roles[0])->create();

        $response = $this->actingAs($user)->get('/patients');

        $response->assertStatus(200)
            ->assertViewIs('patient-records.index')
            ->assertSee('Patient Records');
    }

    public function test_barangay_officials_can_access_medicine_inventory(): void
    {
        $user = User::factory()->withRole($this->roles[0])->create();

        $response = $this->actingAs($user)->get('/medicines');

        $response->assertStatus(200)
            ->assertViewIs('medicines.index')
            ->assertSee('Medicine Inventory');
    }

    public function test_barangay_officials_can_access_schedules(): void
    {
        $user = User::factory()->withRole($this->roles[0])->create();

        $response = $this->actingAs($user)->get('/schedules');

        $response->assertStatus(200)
            ->assertViewIs('schedules.index')
            ->assertSee('Schedules');
    }

    public function test_barangay_officials_can_access_tb_prediction(): void
    {
        $user = User::factory()->withRole($this->roles[0])->create();

        $response = $this->actingAs($user)->get('/tb-prediction');

        $response->assertStatus(200)
            ->assertViewIs('tb-prediction.index')
            ->assertSee('TB Prediction');
    }

    public function test_barangay_officials_can_access_disease_demographics(): void
    {
        $user = User::factory()->withRole($this->roles[0])->create();

        $response = $this->actingAs($user)->get('/disease-demographics');

        $response->assertStatus(200)
            ->assertViewIs('disease-demographics.index')
            ->assertSee('Disease Demographics');
    }

    public function test_barangay_officials_can_access_health_records(): void
    {
        $user = User::factory()->withRole($this->roles[0])->create();

        $response = $this->actingAs($user)->get('/health-records');

        $response->assertStatus(200)
            ->assertViewIs('health-records.index')
            ->assertSee('Health Records');
    }

    public function test_bhw_can_access_patient_records(): void
    {
        $user = User::factory()->withRole($this->roles[1])->create();

        $response = $this->actingAs($user)->get('/patients');

        $response->assertStatus(200)
            ->assertViewIs('patient-records.index')
            ->assertSee('Patient Records');
    }

    public function test_bhw_can_access_medicine_inventory(): void
    {
        $user = User::factory()->withRole($this->roles[1])->create();

        $response = $this->actingAs($user)->get('/medicines');

        $response->assertStatus(200)
            ->assertViewIs('medicine-inventory.index')
            ->assertSee('Medicine Inventory');
    }

    public function test_bhw_can_access_schedules(): void
    {
        $user = User::factory()->withRole($this->roles[1])->create();

        $response = $this->actingAs($user)->get('/schedules');

        $response->assertStatus(200)
            ->assertViewIs('schedules.index')
            ->assertSee('Scheduling');
    }

    public function test_bhw_can_access_tb_prediction(): void
    {
        $user = User::factory()->withRole($this->roles[1])->create();

        $response = $this->actingAs($user)->get('/tb-prediction');

        $response->assertStatus(200)
            ->assertViewIs('tb-prediction.index')
            ->assertSee('TB Prediction');
    }

    public function test_bhw_can_access_disease_demographics(): void
    {
        $user = User::factory()->withRole($this->roles[1])->create();

        $response = $this->actingAs($user)->get('/disease-demographics');

        $response->assertStatus(200)
            ->assertViewIs('disease-demographics.index')
            ->assertSee('Disease Demographics');
    }

    public function test_bhw_can_access_health_records(): void
    {
        $user = User::factory()->withRole($this->roles[1])->create();

        $response = $this->actingAs($user)->get('/health-records');

        $response->assertStatus(200)
            ->assertViewIs('health-records.index')
            ->assertSee('Health Records');
    }

    public function test_doctor_can_access_patient_records(): void
    {
        $user = User::factory()->withRole($this->roles[2])->create();

        $response = $this->actingAs($user)->get('/patients');

        $response->assertStatus(200)
            ->assertViewIs('patient-records.index')
            ->assertSee('Patient Records');
    }

    public function test_doctor_can_access_medicine_inventory(): void
    {
        $user = User::factory()->withRole($this->roles[2])->create();

        $response = $this->actingAs($user)->get('/medicines');

        $response->assertStatus(200)
            ->assertViewIs('medicine-inventory.index')
            ->assertSee('Medicine Inventory');
    }

    public function test_doctor_can_access_schedules(): void
    {
        $user = User::factory()->withRole($this->roles[2])->create();

        $response = $this->actingAs($user)->get('/schedules');

        $response->assertStatus(200)
            ->assertViewIs('schedules.index')
            ->assertSee('Scheduling');
    }

    public function test_doctor_can_access_tb_prediction(): void
    {
        $user = User::factory()->withRole($this->roles[2])->create();

        $response = $this->actingAs($user)->get('/tb-prediction');

        $response->assertStatus(200)
            ->assertViewIs('tb-prediction.index')
            ->assertSee('TB Prediction');
    }

    public function test_doctor_can_access_disease_demographics(): void
    {
        $user = User::factory()->withRole($this->roles[2])->create();

        $response = $this->actingAs($user)->get('/disease-demographics');

        $response->assertStatus(200)
            ->assertViewIs('disease-demographics.index')
            ->assertSee('Disease Demographics');
    }

    public function test_doctor_can_access_health_records(): void
    {
        $user = User::factory()->withRole($this->roles[2])->create();

        $response = $this->actingAs($user)->get('/health-records');

        $response->assertStatus(200)
            ->assertViewIs('health-records.index')
            ->assertSee('Health Records');
    }

    public function test_unauthorized_users_cannot_access_user_management(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/barangay-official/users');

        $response->assertForbidden();
    }

    public function test_unauthorized_users_cannot_access_audit_trail(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/barangay-official/audit-trail');

        $response->assertForbidden();
    }

    public function test_unauthorized_users_cannot_access_patient_records(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/patients');

        $response->assertForbidden();
    }

    public function test_unauthorized_users_cannot_access_medicine_inventory(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/medicines');

        $response->assertForbidden();
    }

    public function test_unauthorized_users_cannot_access_schedules(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/schedules');

        $response->assertForbidden();
    }

    public function test_unauthorized_users_cannot_access_tb_prediction(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/tb-prediction');

        $response->assertForbidden();
    }

    public function test_unauthorized_users_cannot_access_disease_demographics(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/disease-demographics');

        $response->assertForbidden();
    }

    public function test_unauthorized_users_cannot_access_health_records(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/health-records');

        $response->assertForbidden();
    }

    public function test_bhw_cannot_access_user_management(): void
    {
        $user = User::factory()->withRole($this->roles[1])->create();

        $response = $this->actingAs($user)->get('/barangay-official/users');

        $response->assertForbidden();
    }

    public function test_bhw_cannot_access_audit_trail(): void
    {
        $user = User::factory()->withRole($this->roles[1])->create();

        $response = $this->actingAs($user)->get('/barangay-official/audit-trail');

        $response->assertForbidden();
    }

    public function test_doctor_cannot_access_user_management(): void
    {
        $user = User::factory()->withRole($this->roles[2])->create();

        $response = $this->actingAs($user)->get('/barangay-official/users');

        $response->assertForbidden();
    }

    public function test_doctor_cannot_access_audit_trail(): void
    {
        $user = User::factory()->withRole($this->roles[2])->create();

        $response = $this->actingAs($user)->get('/barangay-official/audit-trail');

        $response->assertForbidden();
    }
}
