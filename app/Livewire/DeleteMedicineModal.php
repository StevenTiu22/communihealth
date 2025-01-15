<?php

namespace App\Livewire;

use App\Models\Medicine;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class DeleteMedicineModal extends Component
{
    public $showModal = false;
    public Medicine $medicine;
    public $confirmationName = '';

    protected $rules = [
        'confirmationName' => 'required'
    ];

    public function mount(Medicine $medicine)
    {
        $this->medicine = $medicine;
    }

    public function openModal()
    {
        $this->showModal = true;
        $this->confirmationName = '';
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->confirmationName = '';
        $this->resetValidation();
    }

    public function delete()
    {
        // Validate confirmation
        if (strtolower($this->confirmationName) !== strtolower($this->medicine->name)) {
            $this->addError('confirmationName', 'The medicine name does not match.');
            return;
        }

        try {
            // Record deletion details
            $deletionDetails = [
                'medicine_id' => $this->medicine->id,
                'name' => $this->medicine->name,
                'deleted_at' => now()
            ];
            
            Log::info('Medicine deleted', $deletionDetails);

            // Perform soft delete
            $this->medicine->delete();

            $this->closeModal();
            $this->dispatch('medicine-deleted');
            
            session()->flash('success', 'Medicine "' . $this->medicine->name . '" has been deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting medicine: ' . $e->getMessage());
            session()->flash('error', 'Failed to delete medicine. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.delete-medicine-modal');
    }
} 