<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Patients\AddPatientModal;
use App\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AddPatientModalTest extends TestCase
{
    use RefreshDatabase;

    public function can_open_modal()
    {
        Livewire::test(AddPatientModal::class)
            ->assertSet('showModal', false)
            ->call('openModal')
            ->assertSet('showModal', true);
    }


    public function can_close_modal()
    {
        Livewire::test(AddPatientModal::class)
            ->set('showModal', true)
            ->call('closeModal')
            ->assertSet('showModal', false);
    }

    public function validates_required_fields()
    {
        Livewire::test(AddPatientModal::class)
            ->call('save')
            ->assertHasErrors([
                'first_name' => 'required',
                'last_name' => 'required',
                'gender' => 'required',
                'birth_date' => 'required',
                'contact_number' => 'required',
                'house_number' => 'required',
                'street' => 'required',
                'barangay' => 'required',
                'city' => 'required',
            ]);
    }

    public function validates_contact_number_format()
    {
        Livewire::test(AddPatientModal::class)
            ->set('contact_number', '123')
            ->assertHasErrors(['contact_number' => 'digits'])
            ->set('contact_number', 'abcdefghijk')
            ->assertHasErrors(['contact_number' => 'numeric']);
    }


    public function validates_name_format()
    {
        Livewire::test(AddPatientModal::class)
            ->set('first_name', '123')
            ->assertHasErrors(['first_name' => 'regex'])
            ->set('first_name', 'John')
            ->assertHasNoErrors(['first_name']);
    }

    public function validates_philhealth_number_format()
    {
        Livewire::test(AddPatientModal::class)
            ->set('mother_philhealth', '123')
            ->assertHasErrors(['mother_philhealth' => 'regex'])
            ->set('mother_philhealth', '12-123456789-1')
            ->assertHasNoErrors(['mother_philhealth']);
    }

    public function can_create_patient_with_complete_data()
    {
        Livewire::test(AddPatientModal::class)
            ->set('first_name', 'John')
            ->set('middle_name', 'Doe')
            ->set('last_name', 'Smith')
            ->set('gender', '0')
            ->set('birth_date', '2000-01-01')
            ->set('contact_number', '09123456789')
            ->set('is_4ps', 1)
            ->set('is_NHTS', 0)
            ->set('house_number', '123')
            ->set('street', 'Main St')
            ->set('barangay', 'Sample Brgy')
            ->set('city', 'Sample City')
            ->set('mother_first_name', 'Jane')
            ->set('mother_last_name', 'Smith')
            ->set('mother_philhealth', '12-123456789-1')
            ->call('save')
            ->assertHasNoErrors();

        // Assert patient was created
        $this->assertDatabaseHas('patients', [
            'first_name' => 'John',
            'last_name' => 'Smith',
        ]);

        // Assert address was created
        $this->assertDatabaseHas('addresses', [
            'house_number' => '123',
            'street' => 'Main St',
        ]);

        // Assert parent info was created
        $this->assertDatabaseHas('parent_infos', [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'status' => 'Mother',
        ]);

        // Assert relationships
        $patient = Patient::first();
        $this->assertCount(1, $patient->addresses);
        $this->assertCount(1, $patient->parents);
    }

    public function resets_form_after_submission()
    {
        Livewire::test(AddPatientModal::class)
            ->set('first_name', 'John')
            ->set('last_name', 'Smith')
            ->call('closeModal')
            ->assertSet('first_name', '')
            ->assertSet('last_name', '');
    }

    public function can_create_patient_without_parent_info()
    {
        Livewire::test(AddPatientModal::class)
            ->set('first_name', 'John')
            ->set('last_name', 'Smith')
            ->set('gender', '0')
            ->set('birth_date', '2000-01-01')
            ->set('contact_number', '09123456789')
            ->set('house_number', '123')
            ->set('street', 'Main St')
            ->set('barangay', 'Sample Brgy')
            ->set('city', 'Sample City')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('patients', [
            'first_name' => 'John',
            'last_name' => 'Smith',
        ]);

        $patient = Patient::where('first_name', 'John')
                         ->where('last_name', 'Smith')
                         ->first();

        $this->assertNotNull($patient);
        $this->assertCount(0, $patient->parents);
        $this->assertCount(1, $patient->addresses);
    }
}
