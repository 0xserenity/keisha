<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class GetNewDealsController
{
    /** @noinspection PhpUndefinedFieldInspection */
    public function __invoke(Request $request): RedirectResponse
    {
        $request->validate([
            'sessionId' => 'required|string'
        ]);

        Artisan::call('stepn', [
            'sessionID' => $request->sessionId,
            'filter' => $request->filter
        ]);

        return back(303);
    }
}