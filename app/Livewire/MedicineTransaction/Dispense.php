<?php

namespace App\Livewire\MedicineTransaction;

use App\Events\UserActivityEvent;
use App\Models\Medicine;
use App\Models\MedicineTransaction;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Dispense extends Component
{
    public bool $showModal = false;

    public string $reference_number = '';

    public ?int $medicine_id = null;
    public ?int $patient_id = null;
    public string $transaction_date = '';
    public string $transaction_time = '';
    public ?int $previous_stock_level = null;
    public ?int $current_stock_level = null;

    #[Validate('required', message: 'The quantity field is required.')]
    #[Validate('integer', message: 'The quantity must be an integer.')]
    #[Validate('min:1', message: 'The quantity must be at least 1.')]
    #[Validate('max:100', message: 'The quantity may not be greater than 100.')]
    public int $quantity = 0;

    public string $remarks = '';

    public function open(): void
    {
        $this->showModal = true;
    }

    public function close(): void
    {
        $this->showModal = false;
        $this->reset();
    }

    public function dispense(): void
    {
        try {
            $medicine = Medicine::find($this->medicine_id);
            $this->previous_stock_level = $medicine->stock_level;
            $current_stock_level = $this->previous_stock_level - $this->quantity;
            $this->transaction_date = Carbon::now()->format('Y-m-d');
            $this->transaction_time = Carbon::now()->format('H:i:s');

            $medicine->update([
                'stock_level' => $current_stock_level,
            ]);

            MedicineTransaction::create([
                'reference_number' => $this->reference_number,
                'bhw_id' => auth()->user()->id,
                'medicine_id' => $this->medicine_id,
                'patient_id' => $this->patient_id,
                'transaction_date' => $this->transaction_date,
                'transaction_time' => $this->transaction_time,
                'quantity' => $this->quantity,
                'previous_stock_level' => $this->previous_stock_level,
                'remarks' => $this->remarks,
            ]);

            event(new UserActivityEvent(
                auth()->user(),
                'Successfully dispensed medicine',
                'BHW ' .auth()->user()->last_name . ' dispensed ' . $this->quantity . ' of ' . $medicine->name . ' to patient ' . Patient::find($this->patient_id)->full_name,
                [
                    'reference_number' => $this->reference_number,
                    'bhw_id' => auth()->user()->id,
                    'patient_id' => $this->patient_id,
                    'transaction_date' => $this->transaction_date,
                    'transaction_time' => $this->transaction_time,
                    'quantity' => $this->quantity,
                    'previous_stock_level' => $this->previous_stock_level,
                    'remarks' => $this->remarks,
                ],
                Carbon::now()->toDateTimeString()
            ));

            session()->flash('success', 'Medicine dispensed successfully.');

            $this->redirect(route('medicine-transactions.index'));
        } catch (\Exception $e) {
            Log::error('Error dispensing medicine: ' . $e->getMessage());

            event(new UserActivityEvent(
                auth()->user(),
                'Failed to dispense medicine',
                'BHW ' .auth()->user()->last_name . ' failed to dispense ' . $this->quantity . ' of ' . $medicine->name . ' to patient ' . Patient::find($this->patient_id)->full_name,
                [
                    'reference_number' => $this->reference_number,
                    'bhw_id' => auth()->user()->id,
                    'patient_id' => $this->patient_id,
                    'transaction_date' => $this->transaction_date,
                    'transaction_time' => $this->transaction_time,
                    'quantity' => $this->quantity,
                    'previous_stock_level' => $this->previous_stock_level,
                    'remarks' => $this->remarks,
                ],
                Carbon::now()->toDateTimeString()
            ));

            session()->flash('error', 'An error occurred while dispensing the medicine. Please try again.');

            $this->redirect(route('medicine-transactions.index'));
        }
    }

    public function render(): View
    {
        $patients = Patient::orderBy('last_name')->get();
        $medicines = Medicine::orderBy('name')->get();

        return view('livewire.medicine-transaction.dispense', [
            'patients' => $patients,
            'medicines' => $medicines,
        ]);
    }
}
