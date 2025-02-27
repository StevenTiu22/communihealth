<?php

namespace App\Livewire\Forms;

use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateMedicineForm extends Form
{
    #[Validate]
    public string $name = '';

    #[Validate]
    public string $generic_name = '';

    #[Validate]
    public string $manufacturer = '';

    #[Validate]
    public string $category_id = '';

    #[Validate]
    public string $description = '';

    #[Validate]
    public string $tracking_number = '';

    #[Validate]
    public string $delivery_date = '';

    #[Validate]
    public string $manufactured_date = '';

    #[Validate]
    public string $expiry_date = '';

    #[Validate]
    public string $number_of_boxes = '';

    #[Validate]
    public string $quantity_per_boxes = '';

    #[Validate]
    public string $source = '';

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

    protected function messages(): array
    {
        return [
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
    }
}
