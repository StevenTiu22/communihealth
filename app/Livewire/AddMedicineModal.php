<?php

namespace App\Livewire;

use App\Models\MedicineCategory;
use App\Services\MedicineService;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Validation\Rule;

class AddMedicineModal extends Component
{
    public $showModal = false;
    public $name;
    public $generic_name;
    public $manufacturer;
    public $category_id;
    public $description;
    public $tracking_number;
    public $delivery_date;
    public $manufactured_date;
    public $expiry_date;
    public $number_of_boxes;
    public $quantity_per_boxes;
    public $source;

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'generic_name' => [
                'required', 
                'string', 
                'max:255',
                'regex:/^[a-zA-Z\s-]+$/'
            ],
            'manufacturer' => ['required', 'string', 'max:255'],
            'category_id' => [
                'required', 
                'exists:medicine_categories,id'
            ],
            'description' => ['required', 'string', 'min:10'],
            'tracking_number' => [
                'required',
                'string',
                'regex:/^[A-Z0-9-]+$/',
                Rule::unique('medicines', 'tracking_number'),
            ],
            'delivery_date' => [
                'required',
                'date',
                'after_or_equal:manufactured_date',
                'before_or_equal:today'
            ],
            'manufactured_date' => [
                'required',
                'date',
                'before_or_equal:delivery_date'
            ],
            'expiry_date' => [
                'required',
                'date',
                'after:today'
            ],
            'number_of_boxes' => [
                'required', 
                'integer', 
                'min:1',
                'max:999999'
            ],
            'quantity_per_boxes' => [
                'required', 
                'integer', 
                'min:1',
                'max:999999'
            ],
            'source' => ['required', 'string', 'max:255'],
        ];
    }

    protected $messages = [
        'name.required' => 'Medicine name is required.',
        'generic_name.required' => 'Generic name is required.',
        'generic_name.max' => 'Generic name cannot exceed 255 characters.',
        'generic_name.regex' => 'Generic name must contain only letters, spaces, and hyphens.',
        'manufacturer.required' => 'Manufacturer name is required.',
        'category_id.exists' => 'Please select a valid category.',
        'description.min' => 'Description must be at least 10 characters.',
        'tracking_number.regex' => 'Tracking number must contain only uppercase letters, numbers, and hyphens.',
        'tracking_number.unique' => 'This tracking number is already in use.',
        'delivery_date.after_or_equal' => 'Delivery date must be after or equal to manufactured date.',
        'delivery_date.before_or_equal' => 'Delivery date cannot be in the future.',
        'manufactured_date.before_or_equal' => 'Manufactured date must be before or equal to delivery date.',
        'expiry_date.after' => 'Expiry date must be a future date.',
        'number_of_boxes.min' => 'Number of boxes must be at least 1.',
        'quantity_per_boxes.min' => 'Quantity per box must be at least 1.',
    ];

    public function mount()
    {
        $this->setDefaultDates();
    }

    private function setDefaultDates()
    {
        $this->manufactured_date = now()->format('Y-m-d');
        $this->delivery_date = now()->format('Y-m-d');
        $this->expiry_date = now()->addYear()->format('Y-m-d');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        if ($propertyName === 'tracking_number' && $this->tracking_number) {
            $this->tracking_number = strtoupper($this->tracking_number);
        }
    }

    public function save()
    {
        try {
            $validatedData = $this->validate();

            $medicineService = app(MedicineService::class);
            $medicine = $medicineService->createMedicine($validatedData);

            if ($medicine) {
                session()->flash('success', 'Medicine added successfully.');
                $this->closeModal();
                $this->redirectRoute('medicines.index');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error adding medicine: ' . $e->getMessage());
        }
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->reset();
        $this->setDefaultDates();
        $this->resetErrorBag();
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.add-medicine-modal', [
            'categories' => MedicineCategory::orderBy('name')->get()
        ]);
    }
}
