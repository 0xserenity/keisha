<?php

namespace App\Console\Commands;

use App\Jobs\LoadShoeDataFromStepnApi;
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
    protected $signature = 'stepn {sessionID} {filter?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The very first command to get data from STEPN API';

    protected ApiClient $api;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->api = new ApiClient();
    }

    public function handle()
    {
        $this->api->setSessionID($this->argument('sessionID'));

        collect($this->api->getOrderList($this->argument('filter'))->get('data'))->each(function ($order) {
            $this->info(sprintf('Creating data for order %s', $order['propID']));
            $this->createOrderData($order);
        });
    }

    public function createOrderData($order)
    {
        DB::table('sneakers')->upsert(
            [[
                'stepn_id' => $order['propID'],
                'price' => $order['sellPrice'],
                'otd' => $order['otd']
            ]],
            ['stepn_id'],
            [
                'price',
                'otd'
            ]
        );

        (new LoadShoeDataFromStepnApi($order['id']))->handle($this->api);
    }
}