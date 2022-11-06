<?php

namespace App\Http\Controllers\Api;

use App\Jobs\LoadSneakersListFromStepnApi;
use App\Stepn\ApiClient;
use App\Stepn\HashingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StepnLoginController
{
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'code' => 'required'
        ]);

        $email = config('services.hashing.email');
        $hashing = new HashingService();

        $hash = $hashing->getHash($request->code, $email)->get('hash');

        $stepn = new ApiClient();
        $stepn->login($hash, $email);

        $token = include(config_path('stepn.php'));

        if (isset($token['epoch']) && (time() - $token['epoch']) / 3600 <= 1) {

            dispatch(new LoadSneakersListFromStepnApi());

            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }
}