<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LoadSneakersListFromStepnApi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $filter = 1;

    public function __construct(int $filter = 1)
    {
        $this->filter = $filter;
    }

    public function handle()
    {
        if (in_array($this->filter, [1, 2, 3, 4])) {
            Artisan::call('stepn', [
                'filter' => $this->filter
            ]);

            dispatch(
                new self($this->filter + 1)
            )->delay(
                now()->addMinutes(2)
            );
        }
    }
}