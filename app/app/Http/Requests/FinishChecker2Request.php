<?php

namespace App\Http\Requests;

use App\Rules\FinishChecker2Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class FinishChecker2Request extends FormRequest
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
            'id' => ['required', new FinishChecker2Rule()]
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::debug('Validation failed',[$validator->getMessageBag()]);
        return redirect()->back()->with(['error' => $validator->errors()->get('id')[0] ?? "error try again"]);

    }
}
