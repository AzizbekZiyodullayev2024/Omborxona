<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
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
        $productId = $this->route('product'); // Get the product ID from the route
        return [
            'name'          => ['required', 'string', 'max:255', Rule::unique('products', 'name')->ignore($productId)],
            'description'   => ['nullable', 'string'],
            'image_url'     => ['nullable', 'url', 'max:255'],
        ];
    }
}
