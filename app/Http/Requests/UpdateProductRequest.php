<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            //
            'name'=> ['required', 'string', 'max:255'],
            'tagline'=> ['required', 'string', 'max:255'],
            'thumbnail'=> ['sometimes', 'iamge', 'mimes:png,jpg,jpeg'],
            'file'=> ['sometimes', 'file', 'mimes:pdf,docx,xlsx,csv'],
            'about'=> ['required', 'string', 'max:255'],
            'keypoints.*'=> ['required', 'string', 'max:255'],
        ];
    }
}
