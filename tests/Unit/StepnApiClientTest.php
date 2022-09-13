<?php

namespace Tests\Unit;

use App\Stepn\ApiClient;
use PHPUnit\Framework\TestCase;

class StepnApiClientTest extends TestCase
{
    public function test_client_can_get_order_list()
    {
        $client = new ApiClient();

        dd($client->getOrderList());
    }
}
