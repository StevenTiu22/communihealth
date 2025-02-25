<?php

namespace App\Livewire\Medicines;

use App\Models\Medicine;
use App\Models\MedicineCategory;
use App\Services\MedicineService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
use Livewire\Component;

class EditMedicineModal extends Component
{
    public $showModal = false;
    public Medicine $medicine;

    // Form fields
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
                Rule::unique('medicines', 'tracking_number')->ignore($this->medicine->id),
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
                'after:delivery_date'
            ],
            'number_of_boxes' => ['required', 'integer', 'min:1'],
            'quantity_per_boxes' => ['required', 'integer', 'min:1'],
            'source' => ['required', 'string', 'max:255'],
        ];
    }

    protected $messages = [
        'generic_name.regex' => 'Generic name must contain only letters, spaces, and hyphens.',
        'tracking_number.regex' => 'Tracking number must contain only uppercase letters, numbers, and hyphens.',
        'tracking_number.unique' => 'This tracking number is already in use.',
        'expiry_date.after' => 'Expiry date must be after the delivery date.',
    ];

    public function mount(Medicine $medicine)
    {
        $this->medicine = $medicine;
        $this->fillForm();
    }

    private function fillForm()
    {
        $this->name = $this->medicine->name;
        $this->generic_name = $this->medicine->generic_name;
        $this->manufacturer = $this->medicine->manufacturer;
        $this->category_id = $this->medicine->category_id;
        $this->description = $this->medicine->description;
        $this->tracking_number = $this->medicine->tracking_number;
        $this->delivery_date = Carbon::parse($this->medicine->delivery_date)->format('Y-m-d');
        $this->manufactured_date = Carbon::parse($this->medicine->manufactured_date)->format('Y-m-d');
        $this->expiry_date = Carbon::parse($this->medicine->expiry_date)->format('Y-m-d');
        $this->number_of_boxes = $this->medicine->number_of_boxes;
        $this->quantity_per_boxes = $this->medicine->quantity_per_boxes;
        $this->source = $this->medicine->source;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        if ($propertyName === 'tracking_number' && $this->tracking_number) {
            $this->tracking_number = strtoupper($this->tracking_number);
        }
    }

    public function openModal()
    {
        $this->fillForm();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetErrorBag();
    }

    public function save()
    {
        try {
            $validatedData = $this->validate();

            $medicineService = app(MedicineService::class);
            $medicine = $medicineService->updateMedicine($this->medicine, $validatedData);

            if ($medicine) {
                session()->flash('success', 'Medicine updated successfully.');
                $this->closeModal();
                $this->redirectRoute('medicines.index');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating medicine: ' . $e->getMessage());
        }
    }

    private function getCategories()
    {
        return Cache::remember('medicine_categories', 3600, function () {
            try {
                $categories = MedicineCategory::orderBy('name')
                    ->select('id', 'name')
                    ->get();

                if ($categories->isEmpty()) {
                    session()->flash('warning', 'No medicine categories found. Please add categories first.');
                }

                return $categories;
            } catch (\Exception $e) {
                session()->flash('error', 'Error loading medicine categories.');
                return collect();
            }
        });
    }

    public function render()
    {
        return view('livewire.edit-medicine-modal', [
            'categories' => $this->getCategories()
        ]);
    }
}
