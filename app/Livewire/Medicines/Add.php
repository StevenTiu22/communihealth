<?php

namespace App\Livewire\Medicines;

use App\Events\UserActivityEvent;
use App\Livewire\Forms\CreateMedicineForm;
use App\Models\MedicineCategory;
use App\Services\MedicineService;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Add extends Component
{
    public bool $showModal = false;

    public CreateMedicineForm $form;

    public function mount(): void
    {
        $this->form->manufactured_date = now()->format('Y-m-d');
        $this->form->delivery_date = now()->format('Y-m-d');
        $this->form->expiry_date = now()->addYear()->format('Y-m-d');
        $this->form->source = "San Juan City Government";
    }

    public function open(): void
    {
        $this->showModal = true;
    }

    public function close(): void
    {
        $this->showModal = false;
        $this->reset();
        $this->resetErrorBag();
    }

    public function save(MedicineService $medicineService): void
    {
        $validated_data = $this->form->validate();

        try {
            $medicine = $medicineService->createMedicine($validated_data);

            Log::info('Medicine created', ['medicine' => $medicine]);

            event(new UserActivityEvent(
                auth()->user(),
                'Successful medicine creation',
            'User ' . auth()->user()->username . ' created a new medicine record with the tracking number ' . $medicine->tracking_number . '.',
                [
                    'medicine_id' => $medicine->id,
                    'tracking_number' => $medicine->tracking_number,
                    'name' => $medicine->name,
                    'category' => $medicine->category->name,
                    'stock' => $medicine->stock_level,
                ],
                Carbon::now()->toDateTimeString()
            ));

            session()->flash('success', 'Medicine created successfully.');

            $this->redirect(route('medicines.index'));
        } catch (\Exception $e) {
            Log::error('Error creating medicine', ['error' => $e->getMessage()]);

            event(new UserActivityEvent(
                auth()->user(),
                'Failed medicine creation',
                'User ' . auth()->user()->username . ' attempted to create a new medicine record but an error occurred.',
                [
                    'tracking_number' => $validated_data['tracking_number'],
                    'name' => $validated_data['name'],
                    'category' => $validated_data['category_id'],
                    'quantity' => $validated_data['qty_per_boxes'],
                    'error' => $e->getMessage(),
                ],
                Carbon::now()->toDateTimeString()
            ));

            session()->flash('error', 'An error occurred while creating the medicine. Please try again.');

            $this->redirect(route('medicines.index'));
        }
    }

    public function render(): View
    {
        return view('livewire.medicines.add', [
            'categories' => MedicineCategory::orderBy('name')->get()
        ]);
    }
}
