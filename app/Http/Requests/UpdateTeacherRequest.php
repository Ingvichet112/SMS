<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Validate ទិន្នន័យកែប្រែគ្រូ
class UpdateTeacherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // ទទួល ID គ្រូដែលកំពុងកែ ដើម្បីដកចេញពី unique check
        $teacherId = $this->route('teacher')->id;

        return [
            'teacher_id' => ['required', 'string', 'max:20', "unique:teachers,teacher_id,{$teacherId}"],
            'name'       => ['required', 'string', 'max:100'],
            'gender'     => ['required', 'in:Male,Female,Other'],
            'email'      => ['required', 'email', "unique:teachers,email,{$teacherId}"],
            'password'   => ['nullable', 'string', 'min:8'],
            'phone'      => ['nullable', 'string', 'max:20'],
            'subjects'   => ['required', 'array', 'min:1'],
            'subjects.*' => ['string', 'max:100'],
            'address'    => ['nullable', 'string', 'max:500'],
            'photo'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
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
            'subjects.required'   => 'សូមជ្រើសរើសមុខវិជ្ជាយ៉ាងតិចមួយ។',
        ];
    }
}
