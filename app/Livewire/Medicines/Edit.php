<?php

namespace App\Livewire\Medicines;

use App\Events\UserActivityEvent;
use App\Models\Medicine;
use App\Models\MedicineCategory;
use App\Services\MedicineService;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class Edit extends Component
{
    public bool $showModal = false;

    public EditMedicineForm $form;
    public ?Medicine $medicine;

    public string $medicine_id = '';
    public string $category_name = '';
    public Collection $categories;

    public function mount($medicine_id): void
    {
        $this->medicine_id = $medicine_id;

        $this->categories = MedicineCategory::all();
    }

    public function open(): void
    {
        $this->medicine = Medicine::findOrFail($this->medicine_id);

        $this->form->medicine_id = $this->medicine_id;

        $this->form->fill($this->medicine->toArray());

        $this->category_name = $this->medicine->category->name ?? '';

        $this->showModal = true;
    }

    public function close(): void
    {
        $this->showModal = false;
        $this->resetErrorBag();
        $this->resetValidation();
        $this->form->reset();
    }

    public function save(MedicineService $updater): void
    {
        $validated_data = $this->form->validate();

        try {
            $updater->update($this->medicine, $validated_data);

            event(new UserActivityEvent(
                auth()->user(),
                'Successful medicine update',
                "User " . auth()->user()->username . " updated medicine " . $this->medicine->name . " successfully",
                [
                    'medicine_id' => $this->medicine->id,
                    'validated_data' => $validated_data,
                ],
                Carbon::now()->toDateTimeString()
            ));

            session()->flash('success', 'Medicine updated successfully.');

            $this->redirect(route('medicines.index'));
        } catch (\Exception $e) {
            event(new UserActivityEvent(
                auth()->user(),
                'Failed medicine update',
                "User " . auth()->user()->username . " failed to update medicine " . $this->medicine->name,
                [
                    'medicine_id' => $this->medicine->id,
                    'validated_data' => $validated_data,
                    'error_message' => $e->getMessage(),
                ],
                Carbon::now()->toDateTimeString()
            ));

            session()->flash('error', 'Failed to update medicine: ' . $e->getMessage());

            $this->redirect(route('medicines.index'));
        }
    }

    public function render(): View
    {
        return view('livewire.medicines.edit', [
            'categories' => $this->categories,
        ]);
    }
}
