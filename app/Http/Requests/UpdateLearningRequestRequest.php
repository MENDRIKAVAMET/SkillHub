<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLearningRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'skill_id' => ['required', 'exists:skills,id'],
            'message' => ['required', 'string', 'max:1000'],
            'status' => ['required', 'string', Rule::in(['En attente', 'En cours', 'Terminée'])],
        ];
    }
}
