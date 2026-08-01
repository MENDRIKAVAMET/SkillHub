<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateHelpRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'receiver_id' => ['required', 'exists:users,id'],
            'skill_id' => ['required', 'exists:skills,id'],
            'message' => ['required', 'string', 'max:1000'],
            'status' => ['required', 'string', Rule::in(['En attente', 'Acceptée', 'Refusée'])],
        ];
    }
}
