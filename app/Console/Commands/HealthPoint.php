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
            sprintf('To restore %d%% HP using comfort gem level %d, we need:||', $this->argument('hp'), $this->argument('gem'))
        );

        $this->info(
            sprintf(
                '%d gems| %d GST for the fee| So it costs %01.2f USD in total|||',
                $hp->getQuantity(),
                $hp->getCost() * $hp->getQuantity(),
                number_format($hp->getQuantity() * $gemPrice * $solPrice + $hp->getQuantity() * $hp->getCost() * $gstPrice, 2)
            )
        );

        $this->info(
            sprintf(
                'Pricing:| 1 Gem = %01.3f SOL| 1 SOL = %01.2f USD| 1 GST =  %01.4f USD',
                $gemPrice,
                number_format($solPrice, 2),
                number_format($gstPrice, 4)
            )
        );
    }
}