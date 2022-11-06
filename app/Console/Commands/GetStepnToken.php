<?php

namespace App\Console\Commands;

use App\Stepn\ApiClient;
use App\Stepn\HashingService;
use Illuminate\Console\Command;

class GetStepnToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stepn:token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get STEPN Token';

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
        $stepn = new ApiClient();

        $stepn->getAuthCode();
    }
}