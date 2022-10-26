<?php

namespace App\Pricing;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface;

class CoinMarketCapApiClient
{
    protected ?Client $guzzleClient = null;

    protected string $baseUrl = 'https://pro-api.coinmarketcap.com/';

    protected string $key = '';

    public function __construct()
    {
        $this->key = config('services.coinmarketcap.key', '');
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
                'X-CMC_PRO_API_KEY' => $this->key
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
        //return collect(json_decode('{"status":{"timestamp":"2022-10-01T12:00:28.416Z","error_code":0,"error_message":null,"elapsed":41,"credit_count":1,"notice":null},"data":{"5426":{"id":5426,"name":"Solana","symbol":"SOL","slug":"solana","num_market_pairs":388,"date_added":"2020-04-10T00:00:00.000Z","tags":[{"slug":"pos","name":"PoS","category":"ALGORITHM"},{"slug":"platform","name":"Platform","category":"CATEGORY"},{"slug":"solana-ecosystem","name":"Solana Ecosystem","category":"PLATFORM"},{"slug":"cms-holdings-portfolio","name":"CMS Holdings Portfolio","category":"CATEGORY"},{"slug":"kenetic-capital-portfolio","name":"Kenetic Capital Portfolio","category":"CATEGORY"},{"slug":"alameda-research-portfolio","name":"Alameda Research Portfolio","category":"CATEGORY"},{"slug":"multicoin-capital-portfolio","name":"Multicoin Capital Portfolio","category":"CATEGORY"},{"slug":"okex-blockdream-ventures-portfolio","name":"OKEx Blockdream Ventures Portfolio","category":"CATEGORY"}],"max_supply":null,"circulating_supply":355284672.73150396,"total_supply":511616946.142289,"is_active":1,"platform":null,"cmc_rank":9,"is_fiat":0,"self_reported_circulating_supply":null,"self_reported_market_cap":null,"tvl_ratio":null,"last_updated":"2022-10-01T11:59:00.000Z","quote":{"USD":{"price":33.03043526476253,"volume_24h":1121539908.9734333,"volume_change_24h":10.3508,"percent_change_1h":-0.21272673,"percent_change_24h":-2.73835604,"percent_change_7d":-4.30550643,"percent_change_30d":4.93366017,"percent_change_60d":-18.66938401,"percent_change_90d":0.36359577,"market_cap":11735207383.220284,"market_cap_dominance":1.2509,"fully_diluted_market_cap":16898930419.91,"tvl":null,"last_updated":"2022-10-01T11:59:00.000Z"}}},"16352":{"id":16352,"name":"Green Satoshi Token (SOL)","symbol":"GST","slug":"green-satoshi-token","num_market_pairs":38,"date_added":"2021-12-22T01:37:42.000Z","tags":[{"slug":"solana-ecosystem","name":"Solana Ecosystem","category":"PLATFORM"},{"slug":"move-to-earn","name":"Move To Earn","category":"CATEGORY"}],"max_supply":null,"circulating_supply":579739994.5280733,"total_supply":589739994.5280733,"platform":{"id":5426,"name":"Solana","symbol":"SOL","slug":"solana","token_address":"AFbX8oGjGpmVFywbVouvhQSRmiW2aR1mohfahi4Y2AdB"},"is_active":1,"cmc_rank":660,"is_fiat":0,"self_reported_circulating_supply":null,"self_reported_market_cap":null,"tvl_ratio":null,"last_updated":"2022-10-01T11:59:00.000Z","quote":{"USD":{"price":0.025757357203913717,"volume_24h":7139308.02976775,"volume_change_24h":-65.4095,"percent_change_1h":-0.49460823,"percent_change_24h":-3.76602495,"percent_change_7d":-11.90331141,"percent_change_30d":-28.04095497,"percent_change_60d":-53.85941069,"percent_change_90d":-74.54059164,"market_cap":14932570.12445457,"market_cap_dominance":0,"fully_diluted_market_cap":15190143.7,"tvl":null,"last_updated":"2022-10-01T11:59:00.000Z"}}},"18069":{"id":18069,"name":"STEPN","symbol":"GMT","slug":"green-metaverse-token","num_market_pairs":153,"date_added":"2022-03-09T12:47:15.000Z","tags":[{"slug":"collectibles-nfts","name":"Collectibles & NFTs","category":"CATEGORY"},{"slug":"gaming","name":"Gaming","category":"INDUSTRY"},{"slug":"binance-smart-chain","name":"BNB Smart Chain","category":"PLATFORM"},{"slug":"binance-launchpad","name":"Binance Launchpad","category":"CATEGORY"},{"slug":"solana-ecosystem","name":"Solana Ecosystem","category":"PLATFORM"},{"slug":"bnb-chain","name":"BNB Chain","category":"PLATFORM"},{"slug":"move-to-earn","name":"Move To Earn","category":"CATEGORY"}],"max_supply":6000000000,"circulating_supply":600000000,"total_supply":6000000000,"platform":{"id":1839,"name":"BNB","symbol":"BNB","slug":"bnb","token_address":"0x3019BF2a2eF8040C242C9a4c5c4BD4C81678b2A1"},"is_active":1,"cmc_rank":88,"is_fiat":0,"self_reported_circulating_supply":null,"self_reported_market_cap":null,"tvl_ratio":null,"last_updated":"2022-10-01T11:59:00.000Z","quote":{"USD":{"price":0.6428978923437237,"volume_24h":68519561.32475537,"volume_change_24h":-23.7102,"percent_change_1h":0.07861758,"percent_change_24h":0.62101952,"percent_change_7d":0.74512749,"percent_change_30d":-4.88875045,"percent_change_60d":-30.38905935,"percent_change_90d":-21.27013191,"market_cap":385738735.40623426,"market_cap_dominance":0.0411,"fully_diluted_market_cap":3857387354.06,"tvl":null,"last_updated":"2022-10-01T11:59:00.000Z"}}}}}', true));
        $response = $this->sendRequest('GET', '/v2/cryptocurrency/quotes/latest?id=18069,16352,5426,1839,1,6958,6783');

        return collect(json_decode((string)$response->getBody(), true));
    }
}