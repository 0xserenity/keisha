<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Tracking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tracking {gmt} {energy} {durability?} {repair?} {hp?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'tracking {gmt} {energy} {?durability} {?repair} {?hp}';

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
        DB::table('tracking')->insert(
            [
                'otd' => 132635812,
                'energy' => $this->argument('energy'),
                'durability' => $this->argument('durability'),
                'repair' => $this->argument('repair'),
                'hp' => $this->argument('hp'),
                'gmt' => $this->argument('gmt'),
                'created_at' => now(),
            ]
        );
    }
}