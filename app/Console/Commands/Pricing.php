<?php

namespace App\Console\Commands;

use App\CoinMarketCap\ApiClient;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class Pricing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pricing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update pricing from Coin Market Cap';

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
        $prices = Arr::pluck($this->api->getQuotes()->get('data'), 'quote.USD.price');
        DB::table('pricing')
            ->upsert(
                [
                    [
                        'symbol' => 'SOL',
                        'price' => $prices[0],
                        'updated_at' => Carbon::now()
                    ],
                    [
                        'symbol' => 'GST',
                        'price' => $prices[1],
                        'updated_at' => Carbon::now()
                    ],
                    [
                        'symbol' => 'GMT',
                        'price' => $prices[2],
                        'updated_at' => Carbon::now()
                    ]
                ],
                ['symbol'],
                ['price', 'updated_at']
            );
    }
}