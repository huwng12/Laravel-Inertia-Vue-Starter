<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
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
            'user_id' => ['required', 'integer'],
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'You must choose a user',
            'title.required' => 'Title is required',
            'message.required' => 'Message is required',
        ];
    }
}
