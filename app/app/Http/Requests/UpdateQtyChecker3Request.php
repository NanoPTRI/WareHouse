<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class UpdateQtyChecker3Request extends FormRequest
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
            'qty' => 'required|integer|min:0',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::debug('Validation failed',[$validator->getMessageBag()]);
        return redirect()->back()->withErrors(['error' => 'Failed to Data  Please try again.']);
    }
}
