<?php

namespace App\Livewire\Medicines;

use App\Events\UserActivityEvent;
use App\Models\Medicine;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Delete extends Component
{
    public bool $showModal = false;

    public ?Medicine $medicine;

    #[Validate('required', message: 'Please enter the medicine name to confirm deletion.')]
    public $confirmation_name = '';

    public function mount(int $medicine_id): void
    {
        $this->medicine = Medicine::findOrFail($medicine_id);
    }

    public function open(): void
    {
        $this->showModal = true;
    }

    public function close(): void
    {
        $this->showModal = false;
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset();

    }

    public function delete(): void
    {
        try {
            $this->medicine->delete();

            Log::info('Medicine deleted: ' . $this->medicine->name);

            event(new UserActivityEvent(
                auth()->user(),
                'Successful medicine deletion',
                'User ' . auth()->user()->username . ' deleted medicine ' . $this->medicine->name . '.',
                [
                    'medicine_id' => $this->medicine->id,
                    'medicine_name' => $this->medicine->name,
                ],
                Carbon::now()->toDateTimeString()
            ));

            session()->flash('success', 'Medicine deleted successfully.');

            $this->redirect(route('medicines.index'));
        } catch (\Exception $e) {
            Log::error('Error deleting medicine: ' . $e->getMessage());

            event(new UserActivityEvent(
                auth()->user(),
                'Failed medicine deletion',
                'User ' . auth()->user()->username . ' failed to delete medicine ' . $this->medicine->name . '.',
                [
                    'medicine_id' => $this->medicine->id,
                    'medicine_name' => $this->medicine->name,
                    'error_message' => $e->getMessage(),
                ],
                Carbon::now()->toDateTimeString()
            ));

            session()->flash('error', 'Failed to delete medicine. Please try again.');

            $this->redirect(route('medicines.index'));
        }
    }

    public function render(): View
    {
        return view('livewire.medicines.delete');
    }
}
