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
    public int $queueNumber = 0;

    #[Validate('required', message: "Please specify a queue date.")]
    #[Validate('date', message: "The queue date must be a valid date.")]
    #[Validate('date_equals:today', message: "The queue date must be today.")]
    public string $queueDate = '';

    #[Validate('required', message: "Please specify a queue status.")]
    #[Validate('in:waiting,in progress,completed,no show,cancelled', message: "The queue status must be one of the following: waiting, in progress, completed, no show, cancelled.")]
    public string $queueStatus = 'waiting';

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

    public function save(QueueService $queue_service): void
    {
        $this->form->bhw_id = auth()->user()->id;
        $this->form->appointment_date = Carbon::now('UTC')->format('Y-m-d');
        $this->form->time_in = Carbon::now('UTC');
        $this->queueDate = Carbon::now('UTC')->format('Y-m-d');


        $this->validate();
        $this->form->validate();

        try {
            $appointment_queue = $queue_service->create([
                'patient_id' => $this->form->patient_id,
                'bhw_id' => $this->form->bhw_id,
                'doctor_id' => $this->form->doctor_id,
                'appointment_type_id' => $this->form->appointment_type_id,
                'appointment_date' => $this->form->appointment_date,
                'time_in' => $this->form->time_in,
                'chief_complaint' => $this->form->chief_complaint,
                'queue_date' => $this->queueDate,
                'queue_status' => $this->queueStatus,
                'queue_type' => $this->queueType,
                'remarks' => $this->form->remarks,
            ]);

            Log::info('Queue added successfully', [
                'appointment_id' => $appointment_queue->appointment->id,
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
                    'appointment_id' => $appointment_queue->appointment->id,
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
            ]);

            event(new UserActivityEvent(
                auth()->user(),
                'Failed to add a queue',
                "User " . auth()->user()->username . " failed to add a queue",
                [
                    'error' => $e->getMessage(),
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

        $doctors_query = User::query()->role('doctor');

        // Filter doctors by appointment type if one is selected
        if (!empty($this->form->appointment_type_id)) {
            $appointmentType = AppointmentType::find($this->form->appointment_type_id);

            if ($appointmentType) {
                $doctors_query->whereHas('doctor', function($doctorQuery) use ($appointmentType) {
                    $doctorQuery->whereHas('specializations', function($specializationQuery) use ($appointmentType) {
                        $specializationQuery->where('specializations.id', $appointmentType->specialization->id);
                    });
                });
            }
        }

        // Execute the query and sort by last login
        $this->doctors = $doctors_query->orderBy('last_login_at', 'desc')->get();

        return view('livewire.schedules.add-queue', [
            'appointmentTypes' => $appointment_types,
            'patients' => $patients,
        ]);
    }
}
