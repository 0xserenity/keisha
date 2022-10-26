<?php

namespace App\Console\Commands;

use App\Pricing\CoinMarketCapApiClient;
use App\Pricing\StepnfpdotcomClient;
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
    protected $description = 'Update pricing from Coin Market Cap & other sources';

    protected CoinMarketCapApiClient $cmcClient;

    protected StepnfpdotcomClient $sfpClient;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->cmcClient = new CoinMarketCapApiClient();
        $this->sfpClient = new StepnfpdotcomClient();
    }

    public function handle()
    {
        $prices = Arr::pluck($this->cmcClient->getQuotes()->get('data'), 'quote.USD.price');

        DB::table('pricing')
            ->upsert(
                [
                    [
                        'symbol' => 'BTC',
                        'price' => $prices[0],
                        'updated_at' => Carbon::now()
                    ],
                    [
                        'symbol' => 'BNB',
                        'price' => $prices[1],
                        'updated_at' => Carbon::now()
                    ],
                    [
                        'symbol' => 'SOL',
                        'price' => $prices[2],
                        'updated_at' => Carbon::now()
                    ],
                    [
                        'symbol' => 'AXS',
                        'price' => $prices[3],
                        'updated_at' => Carbon::now()
                    ],
                    [
                        'symbol' => 'ACH',
                        'price' => $prices[4],
                        'updated_at' => Carbon::now()
                    ],
                    [
                        'symbol' => 'GST',
                        'price' => $prices[5],
                        'updated_at' => Carbon::now()
                    ],
                    [
                        'symbol' => 'GMT',
                        'price' => $prices[6],
                        'updated_at' => Carbon::now()
                    ]
                ],
                ['symbol'],
                ['price', 'updated_at']
            );

        $gemPrices = $this->sfpClient->getGemPricing()->toArray();
        DB::table('pricing')
            ->upsert(
                [
                    [
                        'symbol' => 'COMFORT1',
                        'price' => $gemPrices['comfort1'],
                        'updated_at' => Carbon::now()
                    ],
                    [
                        'symbol' => 'COMFORT2',
                        'price' => $gemPrices['comfort2'],
                        'updated_at' => Carbon::now()
                    ],
                    [
                        'symbol' => 'COMFORT3',
                        'price' => $gemPrices['comfort3'],
                        'updated_at' => Carbon::now()
                    ],
                    [
                        'symbol' => 'COMFORT4',
                        'price' => $gemPrices['comfort4'],
                        'updated_at' => Carbon::now()
                    ]
                ],
                ['symbol'],
                ['price', 'updated_at']
            );
    }
}