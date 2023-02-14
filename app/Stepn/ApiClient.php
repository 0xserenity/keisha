<?php

namespace App\Stepn;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface;

class ApiClient
{
    protected ?Client $guzzleClient = null;

    protected string $baseUrl = 'https://api2.stepn.com/';

    protected string $sessionID = '';

    public function __construct()
    {
        $this->loadSessionIDFromConfig();
    }

    public function loadSessionIDFromConfig(): void
    {
        $config = include config_path('stepn.php');
        $duration = (time() - $config['epoch']) / 3600;

        if ($duration <= 1) {
            $this->sessionID = $config['sessionID'];
            return;
        }

        info('Session Expired');
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function sendRequest(string $method, string $endpoint, $requestOptions = []): ResponseInterface
    {
        return $this->getHttpClient()->request(
            $method,
            sprintf('%s&sessionID=%s&timestamp=%s', $endpoint, $this->sessionID, time()),
            $requestOptions
        );
    }

    protected function getHttpClient(): Client
    {
        if (!$this->guzzleClient) {
            $this->guzzleClient = $this->createGuzzleClient(
                $this->getDefaultRequestOptions()
            );
        }

        return $this->guzzleClient;
    }

    protected function getDefaultRequestOptions(): array
    {
        return [
            'headers' => [
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip, deflate, br'
            ],
            'decode_content' => false
        ];
    }

    protected function createGuzzleClient($options): Client
    {
        return new Client(
            array_merge(
                [
                    'base_uri' => $this->getBaseUrl(),
                    'timeout' => 30,
                    'cookies' => false,
                    'allow_redirects' => true,
                    'http_errors' => true,
                ],
                $options
            )
        );
    }

    public function getOrderList($filter = 1): Collection
    {
        switch ($filter) {
            case 1:
            case '30u': // 30 Uncommon
                $response = $this->sendRequest('GET', '/run/orderlist?order=2001&chain=103&refresh=true&page=0&otd=&type=600&gType=&quality=2&level=31031&bread=1008');
                return collect(json_decode((string)$response->getBody(), true));
            case 2:
            case '30c': // 30 Common
                $response = $this->sendRequest('GET', '/run/orderlist?order=2001&chain=103&refresh=true&page=0&otd=&type=600&gType=&quality=1&level=31031&bread=1008');
                return collect(json_decode((string)$response->getBody(), true));
            case 3:
            case '30r': // 30 Rare
                $response = $this->sendRequest('GET', '/run/orderlist?order=2001&chain=103&refresh=true&page=0&otd=&type=600&gType=&quality=3&level=31031&bread=0');
                return collect(json_decode((string)$response->getBody(), true));
            case 4:
            case '30e': // 30 Epic
                $response = $this->sendRequest('GET', '/run/orderlist?order=2001&chain=103&refresh=true&page=0&otd=&type=600&gType=&quality=4&level=31031&bread=1008');
                return collect(json_decode((string)$response->getBody(), true));
        }

        // Default is lvl 30, mint 0, uncommon
        $response = $this->sendRequest('GET', '/run/orderlist?order=2001&chain=103&refresh=true&page=0&otd=&type=600&gType=&quality=2&level=31031&bread=1001');
        return collect(json_decode((string)$response->getBody(), true));
    }

    public function getOrderData(int $stepnOrderID): Collection
    {
        $response = $this->sendRequest('GET', sprintf('/run/orderdata?orderId=%s', $stepnOrderID));

        return collect(json_decode((string)$response->getBody(), true));
    }

    public function setSessionID(string $sessionId): void
    {
        $this->sessionID = $sessionId;
    }

    public function login(string $hash, string $email): void
    {
        $response = $this->sendRequest(
            'GET',
            sprintf('/run/login?account=%s&password=%s&type=4&deviceInfo=web', $email, $hash)
        );

        $body = collect(json_decode((string)$response->getBody(), true))->toArray();

        if (isset($body['data']['sessionID'])) {
            $sessionId = $body['data']['sessionID'];

            $this->setSessionID($sessionId);

            $code = '<?php return ' . var_export(['sessionID' => $sessionId, 'epoch' => time()], true) . ';' . PHP_EOL;
            file_put_contents(config_path('stepn.php'), $code);
        }
    }

    public function getAuthCode(): array
    {
        $response = $this->sendRequest(
            'GET',
            sprintf('/run/sendlogincode?account=%s', config('services.hashing.email'))
        );

        return collect(json_decode((string)$response->getBody(), true))->toArray();
    }
}
