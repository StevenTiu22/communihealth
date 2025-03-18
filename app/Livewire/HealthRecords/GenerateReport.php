<?php

namespace App\Livewire\HealthRecords;

use App\Models\Appointment;
use App\Models\AppointmentType;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;

class GenerateReport extends Component
{
    public bool $showModal = false;
    public string $dateRange = 'month';
    public ?string $startDate = null;
    public ?string $endDate = null;
    public string $appointmentTypeFilter = 'all';
    public array $appointmentTypes = [];
    public ?Collection $consultations;

    public function mount(): void
    {
        // Set default date range to current month
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
        // Load appointment types
        $this->loadAppointmentTypes();
        $this->consultations = $this->getConsultations();
    }

    public function loadAppointmentTypes(): void
    {
        $this->appointmentTypes = AppointmentType::orderBy('name')->get()->toArray();
    }

    public function open(): void
    {
        $this->showModal = true;
    }

    public function close(): void
    {
        $this->showModal = false;
    }

    public function updatedDateRange(): void
    {
        if ($this->dateRange === 'month') {
            $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
            $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
        } elseif ($this->dateRange === 'last_month') {
            $this->startDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
            $this->endDate = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
        }

        $this->consultations = $this->getConsultations();
    }

    public function updatedAppointmentTypeFilter(): void
    {
        $this->consultations = $this->getConsultations();
    }

    public function getConsultations()
    {
        $query = Appointment::with('appointmentQueue', 'appointmentType', 'patient')
            ->whereHas('appointmentQueue', function ($query) {
                $query->where('queue_status', 'completed');
            });

        // Apply date range filter
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('appointment_date', [$this->startDate, $this->endDate]);
        }

        // Apply appointment type filter
        if ($this->appointmentTypeFilter !== 'all') {
            $query->whereHas('appointmentType', function ($query) {
                $query->where('id', $this->appointmentTypeFilter);
            });
        }

        $consultations = $query->orderBy('appointment_date')->get();

        // Group by appointment type
        return $consultations->groupBy('appointmentType.name')
            ->map(function ($group) {
                return [
                    'consultations' => $group,
                    'count' => $group->count(),
                ];
            });
    }

    public function generatePDF()
    {
        $totalConsultations = collect($this->consultations)->sum('count');
        $dateRange = [
            'start' => Carbon::parse($this->startDate)->format( 'M d, Y'),
            'end' => Carbon::parse($this->endDate)->format( 'M d, Y')
        ];

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pdf.consultation_report', [
            'consultations' => $this->consultations,
            'totalConsultations' => $totalConsultations,
            'dateRange' => $dateRange,
        ]);

        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'monthly-consultation-report-' . Carbon::parse($this->startDate)->format('Y-m-d') . '.pdf');
    }

    public function render(): View
    {
        $consultations = $this->consultations;
        $totalConsultations = collect($consultations)->sum('count');

        return view('livewire.health-records.generate-report', [
            'consultations' => $consultations,
            'totalConsultations' => $totalConsultations
        ]);
    }
}
