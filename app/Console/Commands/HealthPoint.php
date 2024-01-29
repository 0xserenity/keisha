<?php

namespace App\Console\Commands;

use App\Pricing\Price;
use App\Stepn\HealthPoint as StepnHealthPoint;
use Illuminate\Console\Command;

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
        $hp = new StepnHealthPoint(
            $this->argument('hp'),
            $this->argument('sneaker'),
            $this->argument('gem')
        );

        $gemPrice = Price::symbol(sprintf('COMFORT%d', $this->argument('gem')));
        $solPrice = Price::symbol('SOL');
        $gstPrice = Price::symbol('GST');
        $gmtPrice = Price::symbol('GMT');

        $this->info(
            sprintf('To restore %01.2f%% HP using comfort gem level %d, we need:||', $this->argument('hp'), $this->argument('gem'))
        );

        $this->info(
            sprintf(
                '%d gems| %d GST for the fee| So it costs %01.2f USD in total|||',
                $hp->getQuantity(),
                $hp->getCost() * $hp->getQuantity(),
                number_format($hp->getQuantity() * $gemPrice * $gmtPrice + $hp->getQuantity() * $hp->getCost() * $gstPrice, 2)
            )
        );

        $this->info(
            sprintf(
                'Pricing:| 1 Gem = %01.3f GMT| 1 GMT = %01.2f USD| 1 GST =  %01.4f USD',
                $gemPrice,
                number_format($gmtPrice, 2),
                number_format($gstPrice, 4)
            )
        );
    }
}
