<?php

namespace App\Service\Scraper;

use GuzzleHttp\Client;

class HuurzoneScraper
{
    private Client $client;

    private static $baseUrl = 'https://www.huurzone.nl/';

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }


    public function scrape(string $province = null) {
        return [];

    }


    private function scrapeProvince(string $province) {
        $url = self::$baseUrl . 'huurwoningen/' . $province;
        $response = $this->client->get($url);
        $html = $response->getBody()->getContents();

    }
}