<?php

namespace App\Stepn;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface;

class ApiClient
{
    protected ?Client $guzzleClient = null;

    protected string $baseUrl = 'https://api.stepn.com/';

    protected string $sessionID = 'LfcOCv3L3jfibSEO%3A1664448607293%3A254168';

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function sendRequest(string $method, string $endpoint, $requestOptions = []): ResponseInterface
    {
        return $this->getHttpClient()->request(
            $method,
            sprintf('%s&sessionID=%s', $endpoint, $this->sessionID),
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

    public function getOrderList($filter = null): Collection
    {
        switch ($filter) {
            case '29ugl':
                $response = $this->sendRequest('GET', '/run/orderlist?order=2001&chain=103&refresh=true&page=0&otd=&type=600&gType=&quality=2&level=30030&bread=1008');
                return collect(json_decode((string)$response->getBody(), true));
            case '30cgl':
                $response = $this->sendRequest('GET', '/run/orderlist?order=2001&chain=103&refresh=true&page=0&otd=&type=600&gType=&quality=1&level=31031&bread=1008');
                return collect(json_decode((string)$response->getBody(), true));
            case '30ugl':
                $response = $this->sendRequest('GET', '/run/orderlist?order=2001&chain=103&refresh=true&page=0&otd=&type=600&gType=&quality=2&level=31031&bread=1008');
                return collect(json_decode((string)$response->getBody(), true));
            case '30um1':
                $response = $this->sendRequest('GET', '/run/orderlist?order=2001&chain=103&refresh=true&page=0&otd=&type=600&gType=&quality=2&level=31031&bread=2002');
                return collect(json_decode((string)$response->getBody(), true));
            default:
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
}