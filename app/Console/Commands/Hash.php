<?php

namespace App\Console\Commands;

use App\Stepn\ApiClient;
use App\Stepn\HashingService;
use Illuminate\Console\Command;

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
        dd($stepn->getAuthCode());

        $data = $this->service->getHash(
            $this->argument('code'),
            $this->argument('email')
        );

        $hash = $data->get('hash');
        
        $data = $stepn->login($hash, $this->argument('email'));
        dd($data);
    }
}