<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Validate ទិន្នន័យមុខវិជ្ជា
class StoreCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $courseId = $this->route('course')?->id;

        return [
            'course_code' => ['required', 'string', 'max:20', "unique:courses,course_code,{$courseId}"],
            'course_name' => ['required', 'string', 'max:200'],
            'description' => ['nullable', 'string'],
            'credit'      => ['required', 'integer', 'min:1', 'max:10'],
        ];
    }

    public function messages(): array
    {
        return [
            'course_code.required' => 'សូមបញ្ចូលលេខកូដមុខវិជ្ជា។',
            'course_code.unique'   => 'លេខកូដនេះមានរួចហើយ។',
            'course_name.required' => 'សូមបញ្ចូលឈ្មោះមុខវិជ្ជា។',
            'credit.required'      => 'សូមបញ្ចូលចំនួនក្រេឌីត។',
        ];
    }
}
