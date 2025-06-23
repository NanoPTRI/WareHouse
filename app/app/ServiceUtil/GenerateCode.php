<?php

namespace App\ServiceUtil;

use App\Models\PalletCode;
use Exception;
use Illuminate\Support\Facades\Log;

class GenerateCode
{
    public static function pallet()
    {
        try {
            $last = PalletCode::latest('code')->first();
            $next = $last ? ((int) substr($last->code, 2)) + 1 : 1;

            return 'PL' . str_pad($next, 4, '0', STR_PAD_LEFT);
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return false;
        }

    }
}
