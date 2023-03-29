<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VideoStoreRequest extends FormRequest
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
            'name' => ['required', 'max:255', 'string'],
            'desktop_path' => ['required', 'max:255', 'string'],
            'desktop_thumbnail' => ['image', 'max:1024', 'nullable'],
            'is_main' => ['nullable', 'boolean'],
            'mobile_path' => ['required', 'max:255', 'string'],
            'mobile_thumbnail' => ['image', 'max:1024', 'nullable'],
            'interaction_id' => ['required', 'exists:interactions,id'],
        ];
    }
}
