<?php

namespace App\Rules;

use App\Models\Pallet;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FinishChecker2Rule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = Pallet::where('id_data_pengiriman', $value)
            ->whereNull('checker2')
            ->exists();
        if ($exists) {
            $fail("Scan All Pallet Before Finish This Pallet");
        }
    }
}
