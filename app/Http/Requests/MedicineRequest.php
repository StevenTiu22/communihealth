<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicineRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'generic_name' => ['required', 'string'],
            'manufacturer' => ['required', 'string'],
            'description' => ['required', 'string'],
            'tracking_number' => ['required', 'string'],
            'manufactured_date' => ['required', 'date', 'before_or_equal:today', 'before:delivery_date'],
            'delivery_date' => ['required', 'date', 'before_or_equal:today', 'after:manufactured_date'],
            'expiry_date' => ['required', 'date', 'after:today'],
            'number_of_boxes' => ['required', 'integer'],
            'quantity_per_boxes' => ['required', 'integer']
        ];
    }
}
