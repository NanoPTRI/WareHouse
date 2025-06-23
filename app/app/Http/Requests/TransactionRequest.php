<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class TransactionRequest extends FormRequest
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
            'expedisi' => 'required|max:100',
            'supir' => 'required|max:100',
            'no_mobil' => 'required|max:10',
            'no_loading' => 'required|max:8',
            'no_cont' => 'required|max:255',
            'mulai' => 'required|date_format:H:i',
            'sampai' => 'required|date_format:H:i',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::debug('Validation failed',[$validator->getMessageBag()]);
        return redirect()->back()->withErrors(['error' => 'Failed to Data  Please try again.']);
    }
}
