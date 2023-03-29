<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InteractStoreRequest extends FormRequest
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
            'video_id' => ['required', 'exists:videos,id'],
            'link_to' => ['required', 'exists:videos,id'],
            'content' => ['required', 'max:255', 'string'],
            'position_id' => ['required', 'exists:positions,id'],
        ];
    }
}
