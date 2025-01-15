<?php

namespace App\Livewire;

use App\Models\MedicineCategory;
use Livewire\Component;
use Illuminate\Validation\Rule;

class AddCategoryModal extends Component
{
    public $showModal = false;
    public $name = '';

    protected function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'regex:/^[a-zA-Z\s-]+$/',
                Rule::unique('medicine_categories', 'name')
            ],
        ];
    }

    protected $messages = [
        'name.required' => 'Category name is required.',
        'name.min' => 'Category name must be at least 3 characters.',
        'name.regex' => 'Category name must contain only letters, spaces, and hyphens.',
        'name.unique' => 'This category name already exists.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal() 
    {
        $this->reset();
        $this->resetErrorBag();
        $this->showModal = false;
    }

    public function save()
    {
        $validatedData = $this->validate();

        try {
            MedicineCategory::create([
                'name' => ucwords(strtolower($validatedData['name']))
            ]);
            
            session()->flash('success', 'Category added successfully.');
            $this->closeModal();
            $this->redirectRoute('medicines.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Error adding category: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.add-category-modal');
    }
} 