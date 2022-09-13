<?php

namespace App\Console\Commands;

use App\Stepn\ApiClient;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Stepn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stepn';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The very first command to get data from STEPN API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $api = new ApiClient();

        collect($api->getOrderList()->get('data'))->each(function ($order) {
            $this->info(sprintf('Creating data for order %s', $order['propID']));
            DB::table('shoes')->upsert(
                [[
                    'stepn_id' => $order['propID'],
                    'price' => $order['sellPrice']
                ]],
                ['stepn_id'],
                [
                    'level',
                    'quality',
                    'efficiency',
                    'luck',
                    'comfort',
                    'resilience',
                    'price'
                ]
            );
        });
    }
}