<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VideoUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'project_id' => ['required', 'exists:projects,id'],
            'path' => ['required', 'max:255', 'string'],
            'thumbnail' => ['nullable', 'file'],
            'position_id' => ['required', 'exists:positions,id'],
            'is_main' => ['required', 'boolean'],
        ];
    }
}
