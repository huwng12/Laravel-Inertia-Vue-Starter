<?php

namespace App\Http\Requests\Profile;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'max:255'],
            'email' => [
                'sometimes',
                'required',
                'email',
                'lowercase',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'current_password' => ['sometimes', 'required', 'current_password'],
            'password' => ['sometimes', 'required', 'confirmed', 'min:3'],
            // 'password' => ['required', 'current_password'],
        ];
    }
}
