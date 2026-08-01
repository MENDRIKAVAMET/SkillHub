<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserSkillRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'skill_id' => ['required', 'exists:skills,id'],
            'level' => ['required', 'string', Rule::in(['Débutant', 'Intermédiaire', 'Avancé', 'Expert'])],
        ];
    }
}
