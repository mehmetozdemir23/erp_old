<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('product.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'category_id' => ['required', 'exists:product_categories,id'],
            'images' => ['required', 'array', 'min:1', 'max:4'],
            'images.*' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The product name is required.',
            'name.string' => 'The product name must be a valid string.',
            'name.min' => 'The product name must be at least :min characters.',
            'name.max' => 'The product name cannot exceed :max characters.',

            'price.required' => 'The product price is required.',
            'price.numeric' => 'The product price must be a valid number.',
            'price.min' => 'The product price must be at least :min.',

            'description.string' => 'The product description must be a valid string.',

            'category_id.required' => 'Please select a category for the product.',
            'category_id.exists' => 'The selected category is invalid.',

            'images.required' => 'Please upload at least one image of the product.',
            'images.array' => 'The images must be provided in an array.',
            'images.min' => 'Please upload at least :min image(s) of the product.',
            'images.max' => 'You can upload up to :max images of the product.',

            'images.*.required' => 'Each image must be provided.',
            'images.*.image' => 'Please upload a valid image file.',
            'images.*.mimes' => 'Incorrect file format for one or more images. Allowed formats: jpeg, png, jpg, gif.',
            'images.*.max' => 'One or more images exceeds the maximum file size of :max kilobytes.',
        ];
    }
}
