<?php

namespace App\Livewire\Medicines;

use App\Models\Medicine;
use App\Models\Patient;
use App\Services\MedicineService;
use Livewire\Component;

class AddMedicineTransactionModal extends Component
{
    public $showModal = false;
    public Medicine $medicine;
    public $patient_id;
    public $quantity;
    public $transaction_date;

    protected $rules = [
        'patient_id' => 'required|exists:patients,id',
        'quantity' => 'required|integer|min:1',
        'transaction_date' => 'required|date|before_or_equal:today'
    ];

    public function mount(Medicine $medicine)
    {
        $this->medicine = $medicine;
        $this->transaction_date = now()->format('Y-m-d');
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset();
    }

    public function save(MedicineService $medicineService)
    {
        $this->validate();

        try {
            $medicineService->dispenseMedicine([
                'medicine_id' => $this->medicine->id,
                'patient_id' => $this->patient_id,
                'user_id' => auth()->id(),
                'quantity' => $this->quantity,
                'transaction_date' => $this->transaction_date
            ]);

            $this->dispatch('medicine-dispensed');
            $this->reset(['patient_id', 'quantity']);
            $this->showModal = false;
            session()->flash('success', 'Medicine dispensed successfully.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.add-medicine-transaction-modal', [
            'patients' => Patient::all()
        ]);
    }
}
