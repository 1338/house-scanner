<?php

namespace App\Service\API;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Psr\Http\Message\ResponseInterface;

class HouseLocator
{
    private Client $client;

    private static self|null $houseLocator = null;

    private static int $lastCall = 0;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param string $streetName
     * @param string $houseNumber
     * @param string $postalCode
     * @param string $location
     * @return null|array
     * @throws JsonException
     */
    public function locate(string $streetName, string $houseNumber, string $postalCode, string $location): array|null
    {

        $q = implode(', ', [
            $houseNumber,
            $streetName,
            $location,
            '',
            $postalCode
        ]);

        $paramString = '?format=json&addressdetails=1&q=' . urlencode($q);

        $url = "https://nominatim.openstreetmap.org/search" . $paramString;

        $response = $this->doCall('GET', $url, [
            'User-Agent' => 'House-Scanner',
            "accept" => "*/*",
        ], []);

         $result = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

         if(count($result) === 0 || $result[0]['osm_type'] !== 'node') {
             return null;
         }
        return $result[0];
    }

    /**
     * @throws GuzzleException
     */
    private function doCall(string $method, string $url, array $headers, array  $body): ResponseInterface
    {
        $now = time();
        while($now <= self::$lastCall)
        {
            sleep(1);
            $now = time();
        }
        self::$lastCall = $now;

        $options = [];
        if(empty($headers) === false) {
            $options['headers'] = $headers;
        }
        if(empty($body) === false) {
            $options['body'] = $body;
        }

        return $this->client->request($method, $url, $options);
    }

    public static function getInstance() {
        if(self::$houseLocator === null) {
            self::$houseLocator = new self();
        }
        return self::getInstance();
    }

}