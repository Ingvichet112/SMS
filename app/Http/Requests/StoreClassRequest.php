<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Validate ទិន្នន័យថ្នាក់
class StoreClassRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'class_name'  => ['required', 'string', 'max:100'],
            'room_number' => ['nullable', 'string', 'max:50'],
            'teacher_id'  => ['nullable', 'exists:teachers,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'class_name.required' => 'សូមបញ្ចូលឈ្មោះថ្នាក់។',
            'teacher_id.exists'   => 'គ្រូដែលជ្រើសរើសមិនមាន។',
        ];
    }
}
