<?php

declare(strict_types=1);


namespace Fabiante\Satlib;



use GuzzleHttp\Client;

class SatlibClient
{
    public function __construct(
        private readonly Client $client,
    ) {}

    public function post(Request $request, string $method, string $url): void
    {
        $opts = $request->toGuzzleRequestOptions();
        $req = new \GuzzleHttp\Psr7\Request($method, $url);
        $response = $this->client->send($req, $opts);
    }

}
