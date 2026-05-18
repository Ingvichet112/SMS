<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Validate ទិន្នន័យគ្រូ
class StoreTeacherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // ទទួល ID គ្រូ (ប្រសិនណែនាំ update)
        $teacherId = $this->route('teacher')?->id;

        return [
            'teacher_id' => ['required', 'string', 'max:20', "unique:teachers,teacher_id,{$teacherId}"],
            'name'       => ['required', 'string', 'max:100'],
            'gender'     => ['required', 'in:Male,Female,Other'],
            'email'      => ['required', 'email', "unique:teachers,email,{$teacherId}"],
            'phone'      => ['nullable', 'string', 'max:20'],
            'subject'    => ['required', 'string', 'max:100'],
            'address'    => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'teacher_id.required' => 'សូមបញ្ចូលលេខសម្គាល់គ្រូ។',
            'teacher_id.unique'   => 'លេខសម្គាល់នេះមានរួចហើយ។',
            'name.required'       => 'សូមបញ្ចូលឈ្មោះគ្រូ។',
            'email.required'      => 'សូមបញ្ចូលអ៊ីមែល។',
            'email.unique'        => 'អ៊ីមែលនេះមានរួចហើយ។',
            'subject.required'    => 'សូមបញ្ចូលមុខវិជ្ជា។',
        ];
    }
}
