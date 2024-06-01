<?php

declare(strict_types=1);


use Fabiante\Satlib\Request;
use Fabiante\Satlib\SatlibClient;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class SatlibClientTest extends TestCase
{

    public function testPost()
    {
        $this->expectNotToPerformAssertions();

        $client = new SatlibClient(new Client());

        $req = new Request();
        $req->withInputFs(__DIR__);

        $client->post($req, "post", "https://webhook.site/003a2990-ce9e-46b1-8dd8-af952064434d");
    }
}
