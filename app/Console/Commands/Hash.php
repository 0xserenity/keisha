<?php

namespace App\Console\Commands;

use App\Jobs\LoadShoeDataFromStepnApi;
use App\Stepn\ApiClient;
use App\Stepn\HashingService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Hash extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hash {email} {code}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get hashing from email and password';

    protected HashingService $service;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->service = new HashingService();
    }

    public function handle()
    {
        $stepn = new ApiClient();
        $data = $this->service->getHash(
            $this->argument('code'),
            $this->argument('email')
        );

        $hash = $data->get('hash');
        
        $data = $stepn->login($hash);
        dd($data);
    }
}