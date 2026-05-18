<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Validate ទិន្នន័យមុនបង្កើតសិស្សថ្មី
class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // កំណត់ rules ផ្ទៀងផ្ទាត់
    public function rules(): array
    {
        return [
            'student_id'    => ['required', 'string', 'max:20', 'unique:students,student_id'],
            'first_name'    => ['required', 'string', 'max:100'],
            'last_name'     => ['required', 'string', 'max:100'],
            'gender'        => ['required', 'in:Male,Female,Other'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'email'         => ['nullable', 'email', 'max:100', 'unique:students,email'],
            'phone'         => ['nullable', 'string', 'max:20'],
            'address'       => ['nullable', 'string', 'max:500'],
            'class_id'      => ['nullable', 'exists:school_classes,id'],
            // រូបថតត្រូវជា image ទំហំអតិបរមា 2MB
            'photo'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    // ពាក្យជំនួស Error Messages
    public function messages(): array
    {
        return [
            'student_id.required' => 'សូមបញ្ចូលលេខសម្គាល់សិស្ស។',
            'student_id.unique'   => 'លេខសម្គាល់នេះមានរួចហើយ។',
            'first_name.required' => 'សូមបញ្ចូលនាម។',
            'last_name.required'  => 'សូមបញ្ចូលឈ្មោះ។',
            'gender.required'     => 'សូមជ្រើសរើសភេទ។',
            'email.unique'        => 'អ៊ីមែលនេះមានរួចហើយ។',
            'photo.image'         => 'ឯកសារត្រូវជារូបភាព។',
            'photo.max'           => 'រូបភាពត្រូវតូចជា 2MB។',
        ];
    }
}
