<?php

namespace App\Jobs;

use App\Stepn\ApiClient;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class LoadShoeDataFromStepnApi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $stepnOrderID;

    public function __construct(int $stepnOrderID)
    {
        $this->stepnOrderID = $stepnOrderID;
    }

    public function handle(ApiClient $client)
    {
        $order = $client->getOrderData($this->stepnOrderID)->get('data');

        DB::table('shoes')->upsert(
            [[
                'stepn_id' => $order['id'],
                'level' => $order['level'],
                'efficiency' => $order['attrs'][0],
                'luck' => $order['attrs'][1],
                'comfort' => $order['attrs'][2],
                'resilience' => $order['attrs'][3],
                'breed' => $order['breed'],
                'type' => $order['type'],
                'order_id' => $this->stepnOrderID
            ]],
            ['stepn_id'],
            [
                'level',
                'quality',
                'efficiency',
                'luck',
                'comfort',
                'resilience',
                'breed',
                'type',
                'order_id'
            ]
        );
    }
}