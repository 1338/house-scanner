<?php

namespace App\Service\Scraper;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\DomCrawler\Crawler;

class ParariusScraper
{
    private client $client;

    private static $baseUrl = 'https://www.pararius.nl';

    private $results = [];



    public function __construct()
    {
        $this->client = new Client([]);
    }

    // curl 'https://www.pararius.nl/huurwoningen/leeuwarden/sorteer-prijs-op' -H 'User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:103.0) Gecko/20100101 Firefox/103.0' -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8' -H 'Accept-Language: en-US,en;q=0.5' -H 'Accept-Encoding: gzip, deflate, br' -H 'Connection: keep-alive' -H 'Cookie: OptanonConsent=isGpcEnabled=0&datestamp=Thu+Aug+18+2022+14%3A50%3A24+GMT%2B0200+(Central+European+Summer+Time)&version=6.27.0&isIABGlobal=false&hosts=&consentId=fb8bf4a1-010b-43bb-905b-3cebf4260706&interactionCount=2&landingPath=NotLandingPage&groups=C0001%3A1%2CC0002%3A1%2CC0003%3A1%2CC0004%3A1%2CSTACK42%3A1&AwaitingReconsent=false; latest_search_locations=%5B%22leeuwarden%22%5D; OptanonAlertBoxClosed=2022-08-18T12:50:24.533Z; eupubconsent-v2=CPd7hXqPd7hXqAcABBENCcCsAP_AAH_AAChQI8Nf_X__b2_j-_5_f_t0eY1P9_7__-0zjhfdl-8N3f_X_L8X52M7vF36pq4KuR4Eu3LBIQdlHOHcTUmw6okVrzPsbk2cr7NKJ7PEmnMbOydYGH9_n1_zuZKY7_____7z_v-v______f_7-3f3__p_3_-__e_V_99zfn9_____9vP___9v-_9__________3_7BHYAkw1biALsyxwZtowigRAjCsJDqBQAUUAwtEFhA6uCnZXAT6whYAIBQhOBECHEFGDAIABBIAkIiAkCPBAIgCIBAACABUAhAAxsAgsALAwCAAUA0LFGKAIQJCDIgIjlMCAqRIKCeysQSg70NMIQ6zwAoNH_FQgI1kDFYGQkLByHBEgJeLJA8xRvkAIwQoBRKgAAAAA.f_gAD_gAAAAA' -H 'Upgrade-Insecure-Requests: 1' -H 'Sec-Fetch-Dest: document' -H 'Sec-Fetch-Mode: navigate' -H 'Sec-Fetch-Site: none' -H 'Sec-Fetch-User: ?1' -H 'TE: trailers'

    public function scrape(int $page = null) {
        $page = $page ?? 1;
        $current = $this->scrapeIndex();
        dump($page, $current);

        $itemsPerPage = $current;

        while($current === $itemsPerPage) {
            sleep(rand(1, 7));
            $page++;

            try {
                $current = $this->scrapeIndex($page);
            } catch (GuzzleException $e) {
                if($e->getCode() === 400) {
                    break;
                }
                sleep(rand(1, 7));
                $current = $this->scrapeIndex($page);
            } catch (GuzzleException $e) {
                if($e->getCode() === 400) {
                    break;
                }
                dump($e->getCode());
                exit(1);
            }
            dump($page, $current);
        }

        return $this->results;
    }

    /**
     * @throws GuzzleException
     */
    public function scrapeIndex(int $page = null): int
    {

        $url = self::$baseUrl . "/huurwoningen/nederland";
        if($page !== null) {
            $url .= "/page-" . $page;
        }
        $url .= "/sorteer-prijs-op";

        $response = $this->client->get($url, [
            'headers' => [
                "User-Agent"                => "Mozilla/5.0 (X11; Linux x86_64; rv:103.0) Gecko/20100101 Firefox/103.0",
                "Accept"                    => "text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
                "Accept-Language"           => "en-US,en;q=0.5",
                "Accept-Encoding"           => "gzip, deflate, br",
                "DNT"                       => "1",
                "Referer: https://www.pararius.nl/cgi-bin/fl/captcha?q=%252Fhuurwoningen%252Fleeuwarden%252Fsorteer-prijs-op",
                "Connection"                => "keep-alive",
                "Upgrade-Insecure-Requests" => "1",
                "Sec-Fetch-Dest"            => "document",
                "Sec-Fetch-Mode"            => "navigate",
                "Sec-Fetch-Site"            => "none",
                "Sec-Fetch-User"            => "?1",
                "Cookie"                    => "latest_search_locations=%5B%22leeuwarden%22%5D; OptanonConsent=isGpcEnabled=0&datestamp=Thu+Aug+18+2022+15%3A11%3A59+GMT%2B0200+(Central+European+Summer+Time)&version=6.27.0&isIABGlobal=false&hosts=&consentId=7ee6cd47-9e66-449d-aff8-a88468f1a8c6&interactionCount=2&landingPath=NotLandingPage&groups=C0001%3A1%2CC0002%3A1%2CC0003%3A1%2CC0004%3A1%2CSTACK42%3A1&geolocation=NL%3BOV&AwaitingReconsent=false; OptanonAlertBoxClosed=2022-08-18T13:11:24.961Z; eupubconsent-v2=CPd7ki2Pd7ki2AcABBENCcCsAP_AAH_AAChQI8Nf_X__b2_j-_5_f_t0eY1P9_7__-0zjhfdl-8N3f_X_L8X52M7vF36pq4KuR4Eu3LBIQdlHOHcTUmw6okVrzPsbk2cr7NKJ7PEmnMbOydYGH9_n1_zuZKY7_____7z_v-v______f_7-3f3__p_3_-__e_V_99zfn9_____9vP___9v-_9__________3_7BHYAkw1biALsyxwZtowigRAjCsJDqBQAUUAwtEFhA6uCnZXAT6whYAIBQhOBECHEFGDAIABBIAkIiAkCPBAIgCIBAACABUAhAAxsAgsALAwCAAUA0LFGKAIQJCDIgIjlMCAqRIKCeysQSg70NMIQ6zwAoNH_FQgI1kDFYGQkLByHBEgJeLJA8xRvkAIwQoBRKgAAAAA.f_gAD_gAAAAA; fl_cp_pass_b=eyJLZXkiOiJPREpGMzZWR0ZBTldTR0NXWjJYUDNGR0RBQklNRko1UCIsIlBhc3MiOiJSRURZRjI3NEZNUFdOMlo1RVNZQ1FISUZYUUlNWUVQUyIsIlBhdGgiOiIvcHV6emxlL3ZlcmlmeSJ9",
                "TE"                        => "trailers",
            ],
        ]);


        $body = $response->getBody()->getContents();

        $dom = new Crawler($body);
        $titles = $dom->filter('.listing-search-item__link--title');
        $subTitles = $dom->filter('.listing-search-item__sub-title');

        $total = $titles->count();

        for ($i = 0; $i < $total; $i++) {
            $titleElement = $titles->getNode($i);

            $components = $this->buildComponents(
                $titleElement->textContent,
                $subTitles->getNode($i)->textContent,
                $titleElement->attributes->getNamedItem('href')->nodeValue
            );

            if (!empty($components)) {
                $this->results[] = $components;
            }
        }

        return $total;

    }



    private function buildComponents($title, $subTitle, $link): array
    {
        $title = $this->cleanTitle($title);
        $subTitle = $this->cleanSubTitle($subTitle);

        $streetAndHouseNumberParsed = $this->getStreetAndHouseNumber($title);
        if (!$streetAndHouseNumberParsed) {
            return [];
        }

        $cityAndPostalCodeParsed = $this->getCityAndPostalCode($subTitle);
        if (!$cityAndPostalCodeParsed) {
            return [];
        }

        return [
            'link' => $link,
            'site' => 'pararius',
            'street' => $streetAndHouseNumberParsed['street'],
            'houseNumber' => $streetAndHouseNumberParsed['houseNumber'],
            'postalCode' => $cityAndPostalCodeParsed['postalCode'],
            'city' => $cityAndPostalCodeParsed['city'],
        ];
    }


    private function getCityAndPostalCode($subTitle): array|bool
    {
        // the subTitle is something like "2300 AA Leiden"
        $parts = explode(' ', $subTitle);

        if (count($parts) < 3) {
            return false;
        }

        return [
            'postalCode' => $parts[0] . $parts[1],
            'city' => implode(' ', array_slice($parts, 2)),
        ];
    }

    private function getStreetAndHouseNumber($title): array|bool
    {
        // Title can contain a house number, which is the number in the string + a potential string of letters.
        // We'll split on the number, and then check if the first part is a number.
        $titleSplitOnNumbers = preg_split('/\d+/', $title);
        if ((count($titleSplitOnNumbers) > 1) && preg_match('/\d+/', $title, $matches)) {
            $street = trim($titleSplitOnNumbers[0]);
            $houseNumber = trim($matches[0]);
            if (count($titleSplitOnNumbers) > 2) {
                $houseNumber .= trim($titleSplitOnNumbers[1]);
            }
            if ($street === '' || $houseNumber === '') {
                return false;
            }
            return [
                'street' => $street,
                'houseNumber' => $houseNumber,
            ];
        }
        return false;
    }

    private function cleanTitle(string $title): array|string
    {
        return str_replace(["Appartement ", "Huis ", "Studio ", "Kamer "], "", trim($title));
    }

    private function cleanSubTitle($subTitle): string
    {
        $subTitle = trim($subTitle);
        $subTitleParts = explode(" (", $subTitle);

        return $subTitleParts[0];
    }
}