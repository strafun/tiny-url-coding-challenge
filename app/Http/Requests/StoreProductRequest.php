<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:80',
            'price' => 'required|numeric|between:0.01,167772.15',
            'category_id' => 'required',
            'description' => 'required',
            'isTop' => 'required|boolean'
        ];
    }
}
