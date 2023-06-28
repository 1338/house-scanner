<?php

namespace App\Service\Scraper;

//use App\House\HouseSearchOptions;
use GuzzleHttp\Client;

class FundaScraper
{
    private $client;

    private $baseUri = 'https://www.funda.nl/';

    public $distanceOption = [
        0 => null,
        1 => '+1km',
        2 => '+2km',
        5 => '+5km',
        10 => '+10km',
        15 => '+15km',
        30 => '+30km',
        50 => '+50km',
        100 => '+100km'
    ];

    public $costType = [
        'rent' => 'huur',
        'buy' => 'koop'
    ];

    public $houseType = [
        'appartement' => 'appartement',
    ];

    public $defaultLocation = 'heel-nederland';

    public function __construct()
    {
        $this->client = new Client([]);
    }

    public function scrape(string $type, string $houseType = null, string $location = null, string $radius = null) {
        $paramString = $this->buildIndexString($type, $location, $houseType , $radius, 1);

        //dump($paramString);

        $firstResponse = $this->client->get('https://www.funda.nl/huur/leeuwarden/appartement/', [
            "Host" => "www.funda.nl",
            "User-Agent" => "Mozilla/5.0 (X11; Linux x86_64; rv:103.0) Gecko/20100101 Firefox/103.0",
            "Accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
            "Accept-Language" => "en-US,en;q=0.5",
            "Accept-Encoding" => "gzip, deflate, br",
            "DNT" => "1",
            "Connection" => "keep-alive",
            "Upgrade-Insecure-Requests" => "1",
            "Sec-Fetch-Dest" => "document",
            "Sec-Fetch-Mode" => "navigate",
            "Sec-Fetch-Site" => "none",
            "Sec-Fetch-User" => "?1",
            "Cookie" => "SNLBCORS=74c27b417c1cde18e77321c7c384274f; SNLB=74c27b417c1cde18e77321c7c384274f; .ASPXANONYMOUS=bBB-cWUniJMJizGU0k6wEpGTOUKTaeePyg5r0f2jnjkbTY9cG9-1IR6SRixgF12yfQMrUqmNDOLdwsQUOtAbbgqWvYuj5b-5q8LcT63SLDdhrKHYSAdt6zUpMn8vWYub_ksM4pKf1yRgom5im0FK1jOdT4w1; sr=0%7cfalse; ak_bmsc=3D136DED87F88E2F0134C2ED2A0A2C62~000000000000000000000000000000~YAAQjFZhaLmIxKyCAQAA7E/BsBCcD2hsHnGZXpGwbgJEKZOUIrr4+5hIsZJ6I1ZnjAZlUc8OSqmvJRhx7CiwhxOs9gzHr2WzLGfC+b7/wIFng3bTjVUeWfLlv8404g7R5J2wXAJ3jCVBdUVpYRQ4TNl8kn7yN4gcmLSv5P2Hya6…5tAuUP/GlXA9cK43uEuBfmO7laWyvFbGGZFeV9010m8YMtVZSd98go2cR00FRSLItdNIEY7gbNFguAa9kkxrUiT7A5Bm4LFlxxFl3SZ6RD0KkiRYEDvjgfx4nHK6oXwKDRvytm3WJY3dmquTFsqnrZs4W9MrDqojmdp+v7YES4JY4PKRvGQ1bCGoaf5xU7UvZ6FgdhrothxdblOKdcBbMTlO1qDPk=~1; lzo=huur=%2fhuur%2fleeuwarden%2fappartement%2f; objectnotfound=objectnotfound=false; lzo_sort=huur=%7b%22Key%22%3a%22huurprijs%22%2c%22Value%22%3a%22Ascending%22%7d; __RequestVerificationToken=z2Lc3f_ZQc8cPhrIOAEmyPDVSI6p16myiHM-nLg1kmqD3XiXsCNJ_8OydgZN_el_QpQyXHbRaznQMD4v6sz4cGZKZUI1"
        ]);

        dump($firstResponse->getBody()->getContents(), $firstResponse->getStatusCode());

    }


    private function buildIndexString($type, string $location = null, $houseType, int $radius = null, $page = 1) {
        if($location === null) {
            $location = $this->defaultLocation;
        }
        $costType = $this->costType[$type];

        if($costType === 'huur') {
            $filter = 'sorteer-huurprijs-op';
        }

        $normalizedHouseType = $this->houseType[$houseType];

        $url = $this->baseUri . "$costType/$location";

        $url .= "/$normalizedHouseType";

        $url .= "/$filter";

        if($page !== 1) {
            $url .= "/p$page";
        }

        return $url;
    }

    private function fetchIndexPage($uri) {

    }
}