<?php

namespace App\Service;

use App\Model\ExchangeModel;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ExchangeService
{
    public const ALLOWED_FIAT_CURRENCIES = ['EUR', 'USD', 'PLN'];
    private HttpClientInterface $httpClient;

    /**
     * ExchangeService constructor.
     * @param HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getExchangeRate(ExchangeModel $exchangeModel): array
    {
        $response = $this->httpClient->request('GET', 'https://api.exchangerate.host/latest', [
            // these values are automatically encoded before including them in the URL
            'query' => [
                'base' => $exchangeModel->getFrom(),
                'amount' => $exchangeModel->getAmount(),
                'source' => 'crypto',
                'symbols' => $exchangeModel->getTo(),
            ],
        ]);

        return $response->toArray();
    }
}