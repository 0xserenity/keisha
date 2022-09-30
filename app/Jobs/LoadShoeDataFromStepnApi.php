<?php

namespace App\Jobs;

use App\Stepn\ApiClient;
use Carbon\Carbon;
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
        $holes = collect($order['holes']);

        DB::table('sneakers')->upsert(
            [[
                'stepn_id' => $order['id'],
                'level' => $order['level'],
                'efficiency' => $order['attrs'][0] + $order['attrs'][4],
                'luck' => $order['attrs'][1] + $order['attrs'][5],
                'comfort' => $order['attrs'][2] + $order['attrs'][6],
                'resilience' => $order['attrs'][3] + $order['attrs'][7],
                'breed' => $order['breed'],
                'type' => $order['type'],
                'order_id' => $this->stepnOrderID,
                'quality' => $order['quality'],
                'efficiency_base' => $order['attrs'][0],
                'luck_base' => $order['attrs'][1],
                'comfort_base' => $order['attrs'][2],
                'resilience_base' => $order['attrs'][3],
                'efficiency_socket' => $holes->where('type', '=', 1)->count(),
                'luck_socket' => $holes->where('type', '=', 2)->count(),
                'comfort_socket' => $holes->where('type', '=', 3)->count(),
                'resilience_socket' => $holes->where('type', '=', 4)->count(),
                'updated_at' => Carbon::now(),
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
                'order_id',
                'efficiency_base',
                'luck_base',
                'comfort_base',
                'resilience_base',
                'efficiency_socket',
                'luck_socket',
                'comfort_socket',
                'resilience_socket',
                'updated_at'
            ]
        );
    }
}