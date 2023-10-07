<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateBlogRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255', 'min:3'],
            'content' => ['required', 'string', 'max:255', 'min:10'],
//            'image' => ['required', 'image', 'size:1024', 'mimes:jpeg,jpg,png,gif'],
            'image' => ['required', 'image'],
            'status' => ['required', Rule::in([1,0])],
        ];
    }
}
