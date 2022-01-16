<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpClient\Response\CurlResponse;

abstract class AbstractApiService{

    /**
     * @var HttpClientInterface
     */
    private $client;

    public function __construct(HttpClientInterface $httpClientInterface)
    {
        $this->client = $httpClientInterface;
    }

    public function makeApicall(string $method = 'GET', string $url): CurlResponse
    {
        return $this->client->request($method, $url);
    }

    abstract protected function processResponse(string $case, CurlResponse $response): ?array;
}

