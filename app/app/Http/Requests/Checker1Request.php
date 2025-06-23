<?php

namespace App\Http\Requests;

use App\Rules\InventoriRules;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class Checker1Request extends FormRequest
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
            'id_data_pengiriman' => 'required|exists:data_pengiriman,id',
            'pallet_code' => 'required|exists:pallet_code,code',
            'OtherID' => ['nullable', new InventoriRules()],

            'inventori' => 'nullable',
            'inventori.*.qty' => 'nullable|integer|min:0',
        ];
    }
    public function messages()
    {
        return [
            'id_data_pengiriman.required' => 'ID pengiriman wajib diisi.',
            'id_data_pengiriman.exists'   => 'ID pengiriman tidak valid.',
            'pallet_code.required'        => 'Kode pallet harus diisi.',
            'pallet_code.exists'          => 'Kode pallet tidak ditemukan.',
            'inventori.*.qty.min'         => 'Qty minimum adalah 0.',
            'inventori.*.qty.integer'     => 'Qty harus berupa angka.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::debug('Validation failed',[$validator->getMessageBag()]);
        return redirect()->back()->with(['error' => $validator->errors()->get('id')[0] ?? "error try again"]);

    }
}
