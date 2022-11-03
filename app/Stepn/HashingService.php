<?php

namespace App\Stepn;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface;

class HashingService
{
    protected ?Client $guzzleClient = null;

    protected string $baseUrl = 'http://hash.5oaqkapv5e-e9249vmxw3kr.p.temp-site.link:3030/';

    protected string $secret = '';

    public function __construct()
    {
        $this->secret = config('services.hashing.secret', '');
    }

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

    public function getHash(string $code, string $email): Collection
    {
        $response = $this->sendRequest(
            'POST',
            '/hash',
            [
                'json' => [
                    'email' => $email,
                    'password' => $code,
                    'secret' => $this->secret
                ]
            ]
        );

        return collect(json_decode((string)$response->getBody(), true));
    }
}