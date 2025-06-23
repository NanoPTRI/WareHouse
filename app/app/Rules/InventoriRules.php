<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class InventoriRules implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = DB::connection('sqlsrv')
            ->table('Ms_Part')
            ->where('OtherID', $value)
            ->exists();

        if (! $exists) {
            $fail("Part tidak ditemukan.");
        }
    }
}
