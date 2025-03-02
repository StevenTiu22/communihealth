<?php

namespace App\Livewire\Medicines;

use App\Events\UserActivityEvent;
use App\Models\MedicineCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AddCategory extends Component
{
    public bool $showModal = false;

    #[Validate]
    public string $name = '';

    protected function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'regex:/^[a-zA-Z\s-]+$/',
                Rule::unique('category_categories', 'name')
            ],
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'The category name is required.',
            'name.string' => 'The category name must be a string.',
            'name.min' => 'The category name must be at least 3 characters.',
            'name.max' => 'The category name must not be greater than 255 characters.',
            'name.regex' => 'The category name must only contain letters, spaces, and hyphens.',
            'name.unique' => 'The category name already exists.',
        ];
    }

    public function openModal(): void
    {
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->reset();
        $this->resetErrorBag();
        $this->showModal = false;
    }

    public function save(): void
    {
        $validatedData = $this->validate();

        try {
            $category = MedicineCategory::create([
                'name' => ucwords(strtolower($validatedData['name']))
            ]);

            Log::info('Category created successfully', ['category' => $category]);

            event(new UserActivityEvent(
                auth()->user(),
                'Successful medicine category creation',
                'User ' . auth()->user()->username . ' created a new medicine category with the name ' . $category->name . '.',
                [
                    'category_id' => $category->id,
                    'name' => $category->name,
                ],
                Carbon::now()->toDateTimeString()
            ));

            session()->flash('success', 'Category created successfully.');

            $this->redirect(route('medicines.index'));
        } catch (\Exception $e) {
            Log::error('Error creating category', ['error' => $e->getMessage()]);

            event(new UserActivityEvent(
                auth()->user(),
                'Failed medicine category creation',
                'User ' . auth()->user()->username . ' attempted to create a new category category but an error occurred.',
                [
                    'name' => $validatedData['name'],
                    'error' => $e->getMessage(),
                ],
                Carbon::now()->toDateTimeString()
            ));

            session()->flash('error', 'An error occurred while creating the category. Please try again.');

            $this->redirect(route('medicines.index'));
        }
    }

    public function render(): View
    {
        return view('livewire.add-category');
    }
}
