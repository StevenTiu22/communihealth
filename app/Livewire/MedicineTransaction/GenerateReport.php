<?php

namespace App\Livewire\MedicineTransaction;

use App\Events\UserActivityEvent;
use App\Models\MedicineCategory;
use App\Models\MedicineTransaction;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GenerateReport extends Component
{
    public bool $showModal = false;
    public string $dateRange = 'all';

    #[Validate('required_if:dateRange, ""', message: 'Start date is required')]
    public string $startDate = '';

    #[Validate('required_if:dateRange, ""', message: 'End date is required')]
    public string $endDate = '';

    public string $category = 'all';
    public ?Collection $transactions;

    public function open(): void
    {
        $this->showModal = true;
    }

    public function close(): void
    {
        $this->showModal = false;
        $this->reset(['dateRange', 'startDate', 'endDate']);
    }

    public function generatePDF(): StreamedResponse
    {
        $pdf = app('dompdf.wrapper');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'isPhpEnabled' => true,
            'defaultPaperSize' => 'legal',
            'defaultFont' => 'Arial',
        ]);

        $pdf->loadView('pdf.medicine_released_reports', [
            'transactions' => $this->transactions,
        ]);

        event(new UserActivityEvent(
            auth()->user(),
            'Exported a medicine transaction report',
            'User ' . auth()->user()->username . ' exported a medicine transaction report.',
            [
                'start_date' => $this->startDate,
                'end_date' => $this->endDate,
                'pdf_name' => 'medicine_inventory_report_' . now('Asia/Manila')->format('Y-m-d') . '.pdf',
            ],
            Carbon::now()->toDateTimeString()
        ));

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'medicine_transaction_report_' . now('Asia/Manila')->format('Y-m-d') . '.pdf', [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function render(): View
    {
        $query = MedicineTransaction::query();

        if ($this->dateRange !== 'all') {
            $query->whereBetween('transaction_date', [
                $this->startDate,
                $this->endDate,
            ]);
        }

        if ($this->category !== 'all') {
            $query->whereHas('medicine.category', function ($query) {
                $query->where('id', $this->category);
            });
        }

        $this->transactions = $query->get();

        $categories = MedicineCategory::query()
            ->with(['medicines.transactions'])
            ->orderBy('name')
            ->get();

        return view('livewire.medicine-transaction.generate-report', [
            'transactions' => $this->transactions,
            'categories' => $categories,
        ]);
    }
}
