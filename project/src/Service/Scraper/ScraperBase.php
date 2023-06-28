<?php

namespace App\Service\Scraper;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class ScraperBase
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client(['headers' => [
            "User-Agent" => "Mozilla/5.0 (X11; Linux x86_64; rv:103.0) Gecko/20100101 Firefox/103.0",
        ]]);
    }

    public function responseToCrawler(Response $response): Crawler
    {
        return Cr
    }
}