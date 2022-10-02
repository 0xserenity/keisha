<?php

namespace App\Pricing;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface;

class StepnfpdotcomClient
{
    protected ?Client $guzzleClient = null;

    protected string $baseUrl = 'https://stepnfp.com/';

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
                'X-Requested-With' => 'XMLHttpRequest'
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

    public function getGemPricing(): Collection
    {
        $response = $this->sendRequest('GET', '/assets/php/new-query/last/data_gems_last.php?tzoffset=%2b07:00&chain=SOL');
        return collect(json_decode((string)$response->getBody(), true));
    }
}