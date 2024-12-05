<?php

namespace App\Http\Requests\Listing;

use Illuminate\Foundation\Http\FormRequest;

class UpdateListingRequest extends FormRequest
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
            'title' => ['required', 'max:255'],
            'desc' => ['required'],
            'tags' => ['required', 'string'],
            'email' => ['nullable', 'email'],
            'link' => ['nullable', 'url'],
            'image' => ['nullable', 'file', 'max:3072', 'mimes:jpeg,jpg,png,webp'],
            'category_id' => ['required', 'exists:categories,id']
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required',
            'desc.required' => 'Description is required',
            'tags.required' => 'Tags are required',
            'category_id.required' => 'Category is required',
            'category_id.exists' => 'Category does not exist',
            'image.max' => 'Image size should not exceed 3MB',
            'image.mimes' => 'Image should be of type jpeg, jpg, png or webp',
        ];
    }
}
