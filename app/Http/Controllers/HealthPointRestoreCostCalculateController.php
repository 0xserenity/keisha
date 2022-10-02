<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class HealthPointRestoreCostCalculateController
{
    /** @noinspection PhpUndefinedFieldInspection */
    public function __invoke(Request $request): string
    {
        $request->validate([
            'quality' => 'required|integer',
            'gem' => 'required|integer',
            'hp' => 'required'
        ]);

        Artisan::call('hp', [
            'hp' => $request->hp,
            'sneaker' => $request->quality,
            'gem' => $request->gem
        ]);

        return Str::replace('|', '<br>',Artisan::output());
    }
}