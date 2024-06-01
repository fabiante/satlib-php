<?php

declare(strict_types=1);


use Fabiante\Satlib\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{

    public function testToGuzzleRequestOptions()
    {
        $req = new Request();
        $req->withInputFs(__DIR__);
        $opts = $req->toGuzzleRequestOptions();

        $this->assertArrayHasKey("multipart", $opts);
    }
}
