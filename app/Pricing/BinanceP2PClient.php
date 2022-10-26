<?php

namespace App\Pricing;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface;

class BinanceP2PClient
{
    protected ?Client $guzzleClient = null;

    protected string $baseUrl = 'https://p2p.binance.com/';

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function sendRequest(string $method, string $endpoint, $requestOptions = []): ResponseInterface
    {
        return $this->getHttpClient()->request(
            $method,
            $endpoint,
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
                'Accept' => 'application/json'
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

    public function getQuotes(): Collection
    {
        $response = $this->sendRequest(
            'POST',
            '/bapi/c2c/v2/friendly/c2c/adv/search',
            [
                'json' => [
                    'proMerchantAds' => false,
                    'page' => 1,
                    'rows' => 10,
                    'payTypes' => [],
                    'countries' => [],
                    'publisherType' => null,
                    'asset' => 'BUSD',
                    'fiat' => 'VND',
                    'tradeType' => 'BUY'
                ],
            ]
        );

        return collect(json_decode((string)$response->getBody(), true));
    }
}