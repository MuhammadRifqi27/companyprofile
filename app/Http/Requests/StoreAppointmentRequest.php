<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
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
            'name'=>['required', 'string', 'max:255'],
            'phone_number'=>['required', 'string', 'max:255'],
            'brief'=>['required', 'string', 'max:65535'],
            'budget'=>['required', 'integer'],
            'email'=>['required', 'string', 'max:255'],
            'product_id'=>['required', 'integer'],
            'meeting_at'=>['required', 'date']
        ];
    }
}
