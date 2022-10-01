<?php

namespace App\Console\Commands;

use App\CoinMarketCap\ApiClient;
use App\Stepn\StepnfpdotcomClient;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class HealthPoint extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hp {hp} {sneaker} {gem}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resolve health point cost based on sneaker type and gem level';

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
        $hp = new \App\Stepn\HealthPoint(
            $this->argument('hp'),
            $this->argument('sneaker'),
            $this->argument('gem')
        );

        $gemPrice = DB::table('pricing')
            ->where('symbol', '=', sprintf('COMFORT%d', $this->argument('gem')))
            ->value('price');

        $solPrice = DB::table('pricing')
            ->where('symbol', '=', 'SOL')
            ->value('price');

        $gstPrice = DB::table('pricing')
            ->where('symbol', '=', 'GST')
            ->value('price');

        $this->info(
            sprintf(
                'Quantity: %d, GST: %d, Price in USD: %01.2f',
                $hp->getQuantity(),
                $hp->getCost(),
                number_format($hp->getQuantity() * $gemPrice * $solPrice + $hp->getQuantity() * $hp->getCost() * $gstPrice, 2)
            )
        );
    }
}