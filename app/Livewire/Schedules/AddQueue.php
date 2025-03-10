<?php

namespace App\Livewire\Schedules;

use App\Events\UserActivityEvent;
use App\Livewire\Forms\CreateAppointmentForm;
use App\Models\AppointmentType;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use App\Services\QueueService;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class AddQueue extends Component
{
    public bool $showModal = false;
    public CreateAppointmentForm $form;

    // Queue properties
    #[Validate('required', message: "Please specify an appointment. If there's none, add first.")]
    #[Validate('exists:appointments,id', message: "The appointment ID is invalid.")]
    public int $appointment_id = 0;
    public int $queueNumber = 0;

    #[Validate('required', message: "Please specify a queue date.")]
    #[Validate('date', message: "The queue date must be a valid date.")]
    #[Validate('date_equals:today', message: "The queue date must be today.")]
    public string $queueDate = '';

    #[Validate('required', message: "Please specify a queue status.")]
    #[Validate('in:waiting,in progress,completed,no show,cancelled', message: "The queue status must be one of the following: waiting, in progress, completed, no show, cancelled.")]
    public string $queueStatus = '';

    #[Validate('required', message: "Please specify a queue type.")]
    public string $queueType = 'walk-in';

    public Doctor|Collection $doctors;

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

    public function updated($propertyName): void
    {
        if ($propertyName === 'form.appointment_type_id') {
            $this->doctors = User::query()->role('doctor')
                ->whereHas('specializations', function ($query) {
                    $query->where('appointment_type_id', $this->form->appointment_type_id);
                })
                ->orderBy('last_login_at', 'desc')
                ->get();
        }
    }

    public function save(QueueService $queue_service): void
    {
        $this->validate();

        try {
            $queue_service->create([
                'appointment_id' => $this->appointment_id,
                'queue_date' => $this->queueDate,
                'queue_status' => $this->queueStatus,
                'queue_type' => $this->queueType,
                'remarks' => $this->remarks,
            ]);

            Log::info('Queue added successfully', [
                'appointment_id' => $this->appointment_id,
                'queue_number' => $this->queueNumber,
                'queue_date' => $this->queueDate,
                'queue_status' => $this->queueStatus,
                'queue_type' => $this->queueType,
            ]);

            event(new UserActivityEvent(
                auth()->user(),
                'Successfully added a queue',
                "User " . auth()->user()->username . " added a queue with number " . $this->queueNumber,
                [
                    'appointment_id' => $this->appointment_id,
                    'queue_number' => $this->queueNumber,
                    'queue_date' => $this->queueDate,
                    'queue_status' => $this->queueStatus,
                    'queue_type' => $this->queueType,
                ],
                Carbon::now()->toDateTimeString()
            ));

            session()->flash('success', 'Queue added successfully!');

            $this->redirect(route('schedules.index'));
        } catch (\Exception $e) {
            Log::error('Error adding queue', [
                'error' => $e->getMessage(),
                'appointment_id' => $this->appointment_id,
            ]);

            event(new UserActivityEvent(
                auth()->user(),
                'Failed to add a queue',
                "User " . auth()->user()->username . " failed to add a queue",
                [
                    'error' => $e->getMessage(),
                    'appointment_id' => $this->appointment_id,
                ],
                Carbon::now()->toDateTimeString()
            ));

            session()->flash('error', 'Failed to add queue. Error: ' . $e->getMessage());

            $this->redirect(route('schedules.index'));
        }
    }

    public function render(): View
    {
        $appointment_types = AppointmentType::all();

        $patients = Patient::orderBy('last_name', 'desc')->get();

        $this->doctors = User::query()->role('doctor')->orderBy('last_login_at', 'desc')->get();

        return view('livewire.schedules.add-queue', [
            'appointmentTypes' => $appointment_types,
            'patients' => $patients,
        ]);
    }
}
