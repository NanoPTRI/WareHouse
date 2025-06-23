<?php

namespace App\Http\Requests;

use App\Rules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class UserUpdateRequest extends FormRequest
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
            'username' => [
                'required',
                'string',
                'max:100',
                Rule::unique('users', 'username')->ignore($this->route('id')),
            ],            'password' => [
                'nullable',
                'string',
                Password::min(8)
                    ->mixedCase()    // kombinasi huruf besar dan kecil
                    ->letters()      // harus ada huruf
                    ->numbers()      // harus ada angka
                    ->uncompromised(), // dicek ke database leak (via haveibeenpwned)
            ],
            'role' => ['nullable', new Enum(Rules::class)],
            'id_employe' => ['nullable'],
        ];
    }
}
